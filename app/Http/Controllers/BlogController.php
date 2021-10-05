<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class BlogController extends Controller
{
    public function getBlogs(Request $request)
    {
        if ($request->search && $request->searchcategories) {
            $blogs = $this->searchAndSearchCategories($request);
        } else if ($request->searchcategories) {
            $blogs = $this->searchCategories($request);
        } else if ($request->search) {
            $blogs = $this->search($request);
        } else {
            $blogs = Blog::latest()->paginate(6);
        }
        $blog_categories = BlogCategoryController::getBlogCategories();
        return response()->json(['blogs' => $blogs, 'blog_categories' => $blog_categories], 200);
    } //end of getBlogs

    private function searchAndSearchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Blog::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('blog_categories.id', $categories);
        })->where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(6);
    } //end of searchAndSearchCategories

    private function searchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Blog::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('blog_categories.id', $categories);
        })->latest()->paginate(6);
    } //end of searchCategoies

    private function search($request)
    {
        return Blog::where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(6);
    } //end of search

    public function getBlog(Blog $blog)
    {
        $blog['categories'] = $blog->categories;
        return response()->json($blog, 200);
    } //end of getBlogs
}
