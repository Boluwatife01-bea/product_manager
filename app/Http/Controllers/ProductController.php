<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ✅ 1. Display all products
    public function index()
    {
        $products = Product::paginate(10); // Fetch products with pagination
        return view('products.index', compact('products'));
    }

    // ✅ 2. Show the "Create Product" form
    public function create()
    {
        return view('products.create');
    }

    // ✅ 3. Store new product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create product
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // ✅ 4. Show the "Edit Product" form
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // ✅ 5. Update product details in the database
    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Handle Image Update
    if ($request->hasFile('image')) {
        // Delete Old Image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Store New Image
        $newImagePath = $request->file('image')->store('products', 'public');
        $product->image = $newImagePath;
    }

    // Update product details
    $product->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $product->image, // Save new image or keep existing one
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


    // ✅ 6. Delete a product (Soft Delete)
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
