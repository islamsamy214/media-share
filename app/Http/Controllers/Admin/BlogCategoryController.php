<?php

namespace App\Http\Controllers\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;

class BlogCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_blog_categories'])->only('index');
        $this->middleware(['permission:create_blog_categories'])->only('store');
        $this->middleware(['permission:update_blog_categories'])->only('update');
        $this->middleware(['permission:delete_blog_categories'])->only('destroy');
    } //end of construct

    public function index(Request $request)
    {
        if ($request->search) {
            $blog_categories = $this->searchBlogCategories($request);
        } else {
            $blog_categories = BlogCategory::withCount('blogs')->latest()->paginate(10);
        }

        return response()->json($blog_categories, 200);
    } //end of index


    private function searchBlogCategories($request)
    {
        return BlogCategory::where('name', 'like', '%' . $request->search . '%')
            ->withCount('blogs')->latest()->paginate(10);
    } //end of searchBlogCategories


    public static function getBlogCategories()
    {
        return BlogCategory::get();
    } //end of getCategories


    public function store(StoreBlogCategoryRequest $request)
    {
        $form_data = $request->all();
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        BlogCategory::create($form_data);
    } //end of store


    public function edit(BlogCategory $blogcategory)
    {
        return response()->json($blogcategory, 200);
    } //end of edit


    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogcategory)
    {
        $form_data = $request->all();
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        $blogcategory->update($form_data);
    } //end of update


    public function destroy(BlogCategory $blogcategory)
    {
        $blogcategory->blogs()->detach();
        $blogcategory->delete();
    } //end of destroy
}
