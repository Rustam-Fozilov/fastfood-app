<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Price',
            'Description',
            'Image',
            'Created_at',
            'Updated_at',
        ];
    }
}
