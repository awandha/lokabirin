<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function export(Request $request)
    {
        $from = $request->input('fromDate')
            ? Carbon::parse($request->input('fromDate'))->startOfDay()
            : Carbon::now()->subWeek()->startOfDay();

        $to = $request->input('toDate')
            ? Carbon::parse($request->input('toDate'))->endOfDay()
            : Carbon::now()->endOfDay();

        $orders = Order::with('table')
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=sales_report.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Table', 'Status', 'Total Price', 'Created At'];

        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->table->name,
                    $order->status,
                    $order->total_price,
                    $order->created_at->format('Y-m-d H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
