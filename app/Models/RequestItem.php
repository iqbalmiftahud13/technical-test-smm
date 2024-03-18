<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'department',
        'date_request',
    ];

    public function requestItemDetails()
    {
        return $this->hasMany(RequestItemDetail::class);
    }
}
