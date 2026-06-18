<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Perfume;
use App\Models\Brand;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        // Calculate total revenue from confirmed and delivered orders
        $totalRevenue = Order::whereIn('status', ['confirmed', 'delivered'])->sum('total_price');

        $totalPerfumes = Perfume::where('is_active', true)->count();
        $totalBrands = Brand::where('is_active', true)->count();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('From confirmed & delivered orders')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('Total Orders', $totalOrders)
                ->description("Pending: {$pendingOrders} | Confirmed: {$confirmedOrders} | Delivered: {$deliveredOrders}")
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Active Perfumes', $totalPerfumes)
                ->description("Across {$totalBrands} featured brands")
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),
        ];
    }
}
