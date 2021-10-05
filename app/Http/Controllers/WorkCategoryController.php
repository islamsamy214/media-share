<?php

namespace App\Http\Controllers;

use App\Models\WorkCategory;
use Illuminate\Http\Request;

class WorkCategoryController extends Controller
{
    public static function getWorkCategories()
    {
        return WorkCategory::get();
    } //getWorkCategories
}
