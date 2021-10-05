<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Database\Eloquent\Builder;

class BlogController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware(['permission:read_blogs'])->only('index');
        $this->middleware(['permission:create_blogs'])->only('store');
        $this->middleware(['permission:update_blogs'])->only('update');
        $this->middleware(['permission:delete_blogs'])->only('destroy');
    } //end of construct


    public function index(Request $request)
    {
        if ($request->search && $request->searchcategories) {
            $blogs = $this->searchAndSearchCategories($request);
        } else if ($request->searchcategories) {
            $blogs = $this->searchCategories($request);
        } else if ($request->search) {
            $blogs = $this->search($request);
        } else {
            $blogs = Blog::latest()->paginate(8);
        }
        $blog_categories = BlogCategoryController::getBlogCategories();
        return response()->json(['blogs' => $blogs, 'blog_categories' => $blog_categories], 200);
    } //end of index


    private function searchAndSearchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Blog::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('blog_categories.id', $categories);
        })->where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(8);
    } //end of searchAndSearchCategories


    private function searchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Blog::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('blog_categories.id', $categories);
        })->latest()->paginate(8);
    } //end of searchCategoies


    private function search($request)
    {
        return Blog::where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(8);
    } //end of search


    public function store(StoreBlogRequest $request)
    {
        $form_data = $this->storeBlogForm($request);
        $blog = Blog::create($form_data);
        $this->storeBlogRelations($request, $blog);
        return response()->json('blog created successfully', 200);
    } //end of store


    private function storeBlogForm($request)
    {
        $form_data = $request->except(['image', 'categories']);
        $form_data['slug'] = str_replace(' ', '-', $request->title);
        if ($request->image) {
            $form_data['image'] = $this->uploadImage($request->image, 'images/blogs');
        }
        return $form_data;
    } //end of storeBlogForm


    private function storeBlogRelations($request, $blog)
    {
        $blog_categories = json_decode($request->categories);
        foreach ($blog_categories as $category) {
            $blog->categories()->attach($category->id);
        }
    } //end of storeBlogRelations


    public function show(Blog $blog)
    {
        $blog['categories'] = $blog->categories->toArray();
        return response()->json($blog, 200);
    } //end of edit


    public function edit(Blog $blog)
    {
        $blog_categories = BlogCategoryController::getBlogCategories();
        $blog['categories'] = $blog->categories;
        return response()->json(['blog' => $blog, 'blogCategories' => $blog_categories], 200);
    } //end of edit


    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $form_data = $this->updateBlogForm($request, $blog);
        $blog->update($form_data);
        $this->updateBlogRelations($request, $blog);
        return response()->json('blog updated successfully', 200);
    } //end of update


    private function updateBlogForm($request, $blog)
    {
        $form_data = $request->except(['image', 'categories']);
        $form_data['slug'] = str_replace(' ', '-', $request->title);
        if ($request->image) {
            if ($blog->image != 'default.jpg') {
                $this->deleteImage($blog->image, 'blogs/');
            }
            $form_data['image'] = $this->uploadImage($request->image, 'images/blogs');
        }
        return $form_data;
    } //end of updateBlogForm


    private function updateBlogRelations($request, $blog)
    {
        $blog->categories()->detach();
        $blog_categories = json_decode($request->categories);
        foreach ($blog_categories as $category) {
            $blog->categories()->attach($category->id);
        }
    } //end of updateBlogRelations


    public function destroy(Blog $blog)
    {
        if ($blog->image != 'default.jpg') {
            $this->deleteImage($blog->image, 'blogs/');
        }
        $blog->categories()->detach();
        $blog->delete();
        return response()->json('blog deleted successfully', 200);
    } //end of destroy
}
