<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public static function getBlogCategories()
    {
        return BlogCategory::get();
    }
}
