<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    // Show inventory list + search
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

    // Add items to inventory
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.unit' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        foreach ($validated['items'] as $data) {
            $item = Item::firstOrCreate(
                ['name' => $data['name'], 'unit' => $data['unit']],
                ['quantity' => 0]
            );

            $item->increment('quantity', $data['quantity']);

            InventoryTransaction::create([
                'item_id' => $item->id,
                'type' => 'add',
                'quantity' => $data['quantity'],
            ]);
        }

        return redirect()->back();
    }

    // Deduct items from inventory
    public function deduct(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        foreach ($validated['items'] as $data) {
            $item = Item::findOrFail($data['id']);

            if ($item->quantity < $data['quantity']) {
                abort(400, 'Insufficient stock');
            }

            $item->decrement('quantity', $data['quantity']);

            InventoryTransaction::create([
                'item_id' => $item->id,
                'type' => 'deduct',
                'quantity' => $data['quantity'],
            ]);
        }

        return redirect()->back();
    }

    // View item history
    public function history(Item $item)
    {
        return Inertia::render('Inventory/History', [
            'item' => $item,
            'transactions' => $item->transactions()->latest()->get(),
        ]);
    }
}
