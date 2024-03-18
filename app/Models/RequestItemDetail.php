<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_item_id',
        'id_barang',
        'barang',
        'lokasi',
        'stok',
        'satuan',
        'qty',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }
}
