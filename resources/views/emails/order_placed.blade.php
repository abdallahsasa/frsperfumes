<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Received - FRS Perfumes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e2e2e2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #1c1c1e;
            border: 1px solid #d4af37;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        .header {
            background-color: #0c0c0d;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #2c2c2e;
        }
        .header h1 {
            color: #d4af37;
            margin: 0;
            font-size: 24px;
            letter-spacing: 2px;
        }
        .content {
            padding: 30px;
        }
        .details-grid {
            margin-bottom: 25px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #2c2c2e;
            padding-bottom: 8px;
        }
        .details-label {
            color: #a7833f;
            font-weight: bold;
            font-size: 14px;
        }
        .details-value {
            color: #ffffff;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #2c2c2e;
        }
        th {
            background-color: #0c0c0d;
            color: #d4af37;
            font-weight: bold;
        }
        td {
            color: #ffffff;
        }
        .totals {
            margin-top: 25px;
            text-align: right;
        }
        .totals-row {
            font-size: 14px;
            margin-bottom: 8px;
        }
        .totals-total {
            font-size: 18px;
            font-weight: bold;
            color: #d4af37;
            margin-top: 15px;
            border-top: 1px solid #d4af37;
            padding-top: 10px;
        }
        .footer {
            background-color: #0c0c0d;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888888;
            border-top: 1px solid #2c2c2e;
        }
        .guarantee {
            margin-top: 20px;
            padding: 15px;
            border: 1px dashed #d4af37;
            background-color: rgba(212, 175, 55, 0.05);
            text-align: center;
            border-radius: 3px;
        }
        .guarantee-title {
            color: #d4af37;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .guarantee-text {
            font-size: 12px;
            color: #cccccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>FRS PERFUMES</h1>
            <p style="color: #888; margin: 5px 0 0 0; font-size: 12px; uppercase; letter-spacing: 1px;">New Order Details</p>
        </div>
        <div class="content">
            <h2 style="color: #ffffff; font-size: 18px; border-bottom: 1px solid #d4af37; padding-bottom: 8px; margin-top: 0;">Order Summary</h2>
            <div class="details-grid">
                <div class="details-row">
                    <span class="details-label">Order Number</span>
                    <span class="details-value">#{{ $order->order_number }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Customer Name</span>
                    <span class="details-value">{{ $order->customer_name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Phone</span>
                    <span class="details-value">{{ $order->phone }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">WhatsApp</span>
                    <span class="details-value">{{ $order->whatsapp }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Delivery Address</span>
                    <span class="details-value">{{ $order->city }}, {{ $order->area }}, {{ $order->full_address }}</span>
                </div>
                @if($order->notes)
                    <div class="details-row">
                        <span class="details-label">Customer Notes</span>
                        <span class="details-value">{{ $order->notes }}</span>
                    </div>
                @endif
                <div class="details-row">
                    <span class="details-label">Date Placed</span>
                    <span class="details-value">{{ $order->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>

            <h2 style="color: #ffffff; font-size: 18px; border-bottom: 1px solid #d4af37; padding-bottom: 8px; margin-top: 30px;">Items Ordered</h2>
            <table>
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->brand_name }}</td>
                            <td>{{ $item->perfume_name }}</td>
                            <td>{{ $item->size_ml }} ml</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals">
                <div class="totals-row" style="color: #aaa;">Subtotal: <strong style="color: #fff;">${{ number_format($order->total_price - 15, 2) }}</strong></div>
                <div class="totals-row" style="color: #aaa;">Shipping: <strong style="color: #fff;">$15.00</strong></div>
                <div class="totals-total">Total Price: ${{ number_format($order->total_price, 2) }}</div>
            </div>

            <div class="guarantee">
                <div class="guarantee-title">🛡️ Golden Guarantee Included</div>
                <div class="guarantee-text">
                    This order includes a 1ml tester. The customer is authorized to open the tester first. If not satisfied, they can return the full size bottle unopened.
                </div>
            </div>
        </div>
        <div class="footer">
            <p>FRS Perfumes Luxury Brand &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
