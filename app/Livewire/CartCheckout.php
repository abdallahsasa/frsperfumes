<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Services\CartService;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CartCheckout extends Component
{
    public array $cartItems = [];
    public float $subtotal = 0.0;
    public float $shipping = 15.0;
    public float $total = 0.0;

    // Form Fields
    public string $customer_name = '';
    public string $phone = '';
    public string $whatsapp = '';
    public string $city = '';
    public string $area = '';
    public string $full_address = '';
    public string $notes = '';

    protected array $rules = [
        'customer_name' => 'required|min:3|max:255',
        'phone' => 'required|string|min:7|max:20',
        'whatsapp' => 'required|string|min:7|max:20',
        'city' => 'required|string|max:100',
        'area' => 'required|string|max:100',
        'full_address' => 'required|string|max:500',
        'notes' => 'nullable|string|max:500',
    ];

    public function mount(CartService $cartService): void
    {
        $this->loadCart($cartService);
        
        // Populate custom shipping fee if set
        $shippingSetting = Setting::getValue('shipping_fee');
        if ($shippingSetting !== null && is_numeric($shippingSetting)) {
            $this->shipping = (float) $shippingSetting;
        }
        
        $this->calculateTotals();
    }

    public function loadCart(CartService $cartService): void
    {
        $this->cartItems = $cartService->get();
    }

    public function calculateTotals(): void
    {
        $sub = 0.0;
        foreach ($this->cartItems as $item) {
            $sub += $item['price'] * $item['quantity'];
        }
        $this->subtotal = $sub;
        $this->total = $this->subtotal > 0 ? ($this->subtotal + $this->shipping) : 0.0;
    }

    public function incrementQty(int $perfumeId, CartService $cartService): void
    {
        if (isset($this->cartItems[$perfumeId])) {
            $newQty = $this->cartItems[$perfumeId]['quantity'] + 1;
            if ($newQty <= 10) {
                $cartService->update($perfumeId, $newQty);
                $this->loadCart($cartService);
                $this->calculateTotals();
                $this->dispatch('cartUpdated');
            }
        }
    }

    public function decrementQty(int $perfumeId, CartService $cartService): void
    {
        if (isset($this->cartItems[$perfumeId])) {
            $newQty = $this->cartItems[$perfumeId]['quantity'] - 1;
            if ($newQty > 0) {
                $cartService->update($perfumeId, $newQty);
            } else {
                $cartService->remove($perfumeId);
            }
            $this->loadCart($cartService);
            $this->calculateTotals();
            $this->dispatch('cartUpdated');
        }
    }

    public function removeItem(int $perfumeId, CartService $cartService): void
    {
        $cartService->remove($perfumeId);
        $this->loadCart($cartService);
        $this->calculateTotals();
        $this->dispatch('cartUpdated');
        session()->flash('message', __('messages.item_removed'));
    }

    public function placeOrder(CartService $cartService)
    {
        if (empty($this->cartItems)) {
            return;
        }

        $this->validate();

        // Generate Order number
        $orderNumber = 'FRS-' . time() . '-' . rand(100, 999);

        // 1. Create Order DB Record
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $this->customer_name,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'city' => $this->city,
            'area' => $this->area,
            'full_address' => $this->full_address,
            'notes' => $this->notes,
            'status' => 'pending',
            'total_price' => $this->total,
        ]);

        // 2. Create Order Items
        foreach ($this->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'perfume_id' => $item['id'],
                'perfume_name' => $item['name_en'], // Storing snapshot of name
                'brand_name' => $item['brand_en'], // Storing snapshot of brand
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'size_ml' => $item['size_ml'],
            ]);
        }

        // 3. Send Email notification to admin
        $adminEmail = Setting::getValue('contact_email', 'admin@frsperfumes.com');
        try {
            Mail::to($adminEmail)->send(new OrderPlacedMail($order));
        } catch (\Exception $e) {
            // Log exception or handle siliently in demo
            logger()->error('Failed to send order email to admin: ' . $e->getMessage());
        }

        // 4. Generate WhatsApp Message
        $whatsappMessage = $this->generateWhatsAppText($order);

        // 5. Clear Cart
        $cartService->clear();
        $this->loadCart($cartService);
        $this->calculateTotals();
        $this->dispatch('cartUpdated');

        // Get admin's WhatsApp number to redirect to
        $adminWhatsapp = Setting::getValue('whatsapp_number', '966500000000');
        
        // Clean phone number from non-numeric chars for wa.me API (except potentially keeping country code format)
        $adminWhatsapp = preg_replace('/[^0-9]/', '', $adminWhatsapp);

        $whatsappUrl = 'https://wa.me/' . $adminWhatsapp . '?text=' . rawurlencode($whatsappMessage);

        return redirect()->away($whatsappUrl);
    }

    private function generateWhatsAppText(Order $order): string
    {
        $locale = app()->getLocale();

        if ($locale === 'ar') {
            $msg = "* طلب جديد من FRS Perfumes! *\n\n";
            $msg .= "*تفاصيل الطلب:*\n";
            $msg .= "- رقم الطلب: `" . $order->order_number . "`\n";
            $msg .= "- الاسم: " . $order->customer_name . "\n";
            $msg .= "- رقم الجوال: " . $order->phone . "\n";
            $msg .= "- رقم الواتساب: " . $order->whatsapp . "\n";
            $msg .= "- العنوان: " . $order->city . " - " . $order->area . " - " . $order->full_address . "\n";
            if ($order->notes) {
                $msg .= "- ملاحظات: " . $order->notes . "\n";
            }
            $msg .= "\n*العطور المطلوبة:*\n";
            foreach ($order->items as $item) {
                // Fetch Arabic name if possible
                $perfume = \App\Models\Perfume::find($item->perfume_id);
                $name = $perfume ? $perfume->name_ar : $item->perfume_name;
                $brand = $perfume && $perfume->brand ? $perfume->brand->name_ar : $item->brand_name;
                $msg .= "- " . $brand . " - " . $name . " (" . $item->size_ml . " مل) × " . $item->quantity . " - $" . number_format($item->price, 2) . "\n";
            }
            $msg .= "\n*الملخص المالي:*\n";
            $msg .= "- المجموع الفرعي: $" . number_format($order->total_price - $this->shipping, 2) . "\n";
            $msg .= "- رسوم الشحن: $" . number_format($this->shipping, 2) . "\n";
            $msg .= "- *الإجمالي الكلي: $" . number_format($order->total_price, 2) . "*\n\n";
            $msg .= "*ملاحظة الضمان الذهبي:*\n";
            $msg .= "أنا مسجل للحصول على عينة تستر 1 مل مجاناً مع كل زجاجة. سأقوم بتجربة التستر أولاً قبل فتح زجاجة العطر الأساسية.";
        } else {
            $msg = "* New Order from FRS Perfumes! *\n\n";
            $msg .= "*Order Details:*\n";
            $msg .= "- Order ID: `" . $order->order_number . "`\n";
            $msg .= "- Name: " . $order->customer_name . "\n";
            $msg .= "- Phone: " . $order->phone . "\n";
            $msg .= "- WhatsApp: " . $order->whatsapp . "\n";
            $msg .= "- Address: " . $order->city . ", " . $order->area . ", " . $order->full_address . "\n";
            if ($order->notes) {
                $msg .= "- Notes: " . $order->notes . "\n";
            }
            $msg .= "\n*Items Ordered:*\n";
            foreach ($order->items as $item) {
                $msg .= "- " . $item->brand_name . " - " . $item->perfume_name . " (" . $item->size_ml . "ml) x " . $item->quantity . " - $" . number_format($item->price, 2) . "\n";
            }
            $msg .= "\n*Pricing Details:*\n";
            $msg .= "- Subtotal: $" . number_format($order->total_price - $this->shipping, 2) . "\n";
            $msg .= "- Shipping Fee: $" . number_format($this->shipping, 2) . "\n";
            $msg .= "- *Total Amount: $" . number_format($order->total_price, 2) . "*\n\n";
            $msg .= "*Golden Guarantee Note:*\n";
            $msg .= "I will receive a 1ml tester vial. I understand I should test it first and keep the full-size bottle sealed if I wish to return it.";
        }

        return $msg;
    }

    public function render()
    {
        return view('livewire.cart-checkout');
    }
}
