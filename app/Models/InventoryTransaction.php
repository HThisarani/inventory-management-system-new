<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'item_id',
        'type',     // add or deduct
        'quantity',
    ];

    // Relationship: Transaction belongs to an item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
