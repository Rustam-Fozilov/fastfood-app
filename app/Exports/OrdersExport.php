<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'User id',
            'Email',
            'Product name',
            'Quantity',
            'Price',
            'Total price',
            'Date',
        ];
    }
}
