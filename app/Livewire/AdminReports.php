<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Carbon\Carbon;

class AdminReports extends Component
{
    public $fromDate;
    public $toDate;

    public function mount()
    {
        $this->fromDate = Carbon::now()->subWeek()->format('Y-m-d');
        $this->toDate = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $from = $this->fromDate ? Carbon::parse($this->fromDate)->startOfDay() : Carbon::now()->subWeek()->startOfDay();
        $to = $this->toDate ? Carbon::parse($this->toDate)->endOfDay() : Carbon::now()->endOfDay();

        $orders = Order::with('table')
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();
        $statusCounts = $orders->groupBy('status')->map->count();

        return view('livewire.admin-reports', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'statusCounts' => $statusCounts,
        ]);
    }
}
