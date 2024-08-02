<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    // View product
    public function viewProduct()
    {
        // Ensure the user has a business
        if (Auth::user()->business) {
            // Retrieve the products of the user's business
            $products = Auth::user()->products;
        } else {
            // Handle the case where the user does not have a business
            $products = collect(); // Empty collection
        }

        $data = [
            'products' => $products,
        ];

        return view('dashboard.seller.product.product', $data);
    }

    // View product detail
    public function productDetail(Product $product)
    {
        $data = [
            'product' => $product
        ];

        return view('dashboard.seller.product.product-detail', $data);
    }

    // Add product stock
    public function addStock(Product $product, Request $request)
    {
        $request->validate([
            'numberOfProducts' => ['required', 'min:1', 'integer']
        ]);

        // Update stock
        $product->stock += (int) $request->numberOfProducts; 
        $product->save();

        return redirect()->back()->with('success', 'Stock successfully added!');
    }

    // Set product dicount
    public function setDiscount(Product $product, Request $request)
    {
        $request->validate([
            'discount' => ['required', 'min:0', 'integer', 'max:99']
        ]);

        // Update stock
        $product->discount = (int) $request->discount; 
        $product->save();

        return redirect()->back()->with('success', 'Discount successfully updated!');        
    }

    // Add product form
    public function addProductForm()
    {
        $data = [
            'categories' => Category::all()
        ];

        return view('dashboard.seller.product.new-product-form', $data);
    }

    // Store product
    public function storeProduct(Request $request)
    {
        // Get seller business id
        $business = Auth::user()->business;

        // Create new image manager
        $manager = new ImageManager(new Driver());

        // validate user input
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'brand' => ['required', 'string', 'min:1', 'max:255'],
            'price' => ['required', 'numeric', 'min:500'],
            'category_id' => ['required'],
            'product_image' => ['image', 'mimes:jpeg,png', 'max:1024']
        ]);

        $validatedData['business_id'] = $business->id;

        // Process and save image
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $file_name = $business->slug . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/product/' . $file_name); 

            // Save new profile picture
            $manager->read($image->getPathname())->resize(300, 300)->save($path);
    
            // Update profile picture
            $validatedData['image'] = $file_name; 
        }

        Product::create($validatedData);

        return redirect()->route('view-product')->with('success', 'Product Added');
    }
}
