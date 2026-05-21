<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockBarang extends Model
{
    protected $table = 'Stock_Barang';
    protected $primaryKey = 'id_stock';

    protected $fillable = [
        'nama_produk',
        'stock_produk',
    ];
}
