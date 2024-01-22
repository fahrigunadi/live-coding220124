<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct() {
        $this->middleware('can:role,"admin"', ['except' => ['index']]);
    }

    public function index(Request $request)
    {
        $items = Item::all();


        return view('items.index', ['items' => $items]);
    }

    public function create(Request $request)
    {
        $categories = Category::all();

        return view('items.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        Item::create($validated);

        session()->flash('berhasil', "{$request->name} created successfully!");

        return to_route('items.index');
    }

    public function edit(Request $request, Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function show(Request $request, Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $item->update($validated);

        session()->flash('berhasil', "{$request->name} updated successfully!");

        return to_route('items.index');
    }

    public function destroy(Request $request, Item $item)
    {
        $item->delete();

        return to_route('items.index')->with('berhasil', "{$item->name} deleted successfully!");
    }
}
