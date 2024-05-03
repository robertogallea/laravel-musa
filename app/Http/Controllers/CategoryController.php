<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // eager loading
        $category->load(['posts', 'posts.user']);
        // in contrasto al lazy loading


        return view('category.show')
            ->with('category', $category);
    }
}
