<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Show inventory list with search
     */
    public function index(Request $request)
    {
        $items = Item::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->get();

        return Inertia::render('Inventory/Index', [
            'items' => $items,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Add items to inventory (one or many)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.unit' => 'required|string|max:50',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        foreach ($validated['items'] as $data) {
            // Create item if not exists
            $item = Item::firstOrCreate(
                [
                    'name' => $data['name'],
                    'unit' => $data['unit'],
                ],
                [
                    'quantity' => 0,
                ]
            );

            // Increase quantity
            $item->increment('quantity', $data['quantity']);

            // Record transaction
            InventoryTransaction::create([
                'item_id' => $item->id,
                'type' => 'add',
                'quantity' => $data['quantity'],
            ]);
        }

        return redirect()->back()
            ->with('success', 'Inventory items added successfully.');
    }

    /**
     * Show deduct form page
     */
    public function showDeductForm(Request $request)
    {
        $items = Item::all();

        return Inertia::render('Inventory/Deduct', [
            'items' => $items,
            'selectedItemId' => $request->query('item'), // Pass the pre-selected item ID
        ]);
    }

    /**
     * Deduct items from inventory (one or many)
     */
    public function deduct(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        foreach ($validated['items'] as $data) {
            $item = Item::findOrFail($data['id']);

            // Prevent over-deduction
            if ($item->quantity < $data['quantity']) {
                return redirect()->back()
                    ->with('error', 'Insufficient stock for item: ' . $item->name);
            }

            // Deduct quantity
            $item->decrement('quantity', $data['quantity']);

            // Record transaction
            InventoryTransaction::create([
                'item_id' => $item->id,
                'type' => 'deduct',
                'quantity' => $data['quantity'],
            ]);
        }

        return redirect()->back()
            ->with('success', 'Inventory deducted successfully.');
    }

    /**
     * View transaction history of an item
     */
    public function history(Item $item)
    {
        return Inertia::render('Inventory/History', [
            'item' => $item,
            'transactions' => $item->transactions()
                ->latest()
                ->get(),
        ]);
    }
}
