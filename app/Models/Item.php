<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'name',
        'unit',
        'quantity',
    ];

    // Relationship: Item has many inventory transactions
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}
