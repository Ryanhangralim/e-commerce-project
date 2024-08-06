<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // View Categories
    public function viewCategory()
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];

        return view('dashboard.admin.category', $data);
    }

    // add new category
    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['Required', 'min:3', 'max:25', 'unique:categories']
        ]);

        $validatedData['name'] = ucwords(strtolower($validatedData['name']));

        // Insert data
        Category::create($validatedData);

        return redirect()->route('dashboard.view-category')->with('success', 'Category added');
    }

    // update category
    public function updateCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['Required', 'min:3', 'max:25', 'unique:categories']
        ]);

        $validatedData['name'] = ucwords(strtolower($validatedData['name']));

        // Update Category
        Category::where('id', $request['categoryId'])->update(['name' => $validatedData['name']]);

        return redirect()->route('dashboard.view-category')->with('success', 'Category Updated');
    }
}
