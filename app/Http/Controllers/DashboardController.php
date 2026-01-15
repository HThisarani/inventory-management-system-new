<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\InventoryTransaction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'totalItems' => Item::count(),

            'stockIn' => InventoryTransaction::where('type', 'add')
                ->sum('quantity'),

            'stockOut' => InventoryTransaction::where('type', 'deduct')
                ->sum('quantity'),
        ]);
    }
}
