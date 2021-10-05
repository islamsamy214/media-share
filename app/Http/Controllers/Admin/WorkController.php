<?php

namespace App\Http\Controllers\Admin;

use App\Models\Work;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use Illuminate\Database\Eloquent\Builder;

class WorkController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware(['permission:read_works'])->only('index');
        $this->middleware(['permission:create_works'])->only('store');
        $this->middleware(['permission:update_works'])->only('update');
        $this->middleware(['permission:delete_works'])->only('destroy');
    } //end of construct


    public function index(Request $request)
    {
        if ($request->search && $request->searchcategories) {
            $works = $this->searchAndSearchCategories($request);
        } else if ($request->searchcategories) {
            $works = $this->searchCategories($request);
        } else if ($request->search) {
            $works = $this->search($request);
        } else {
            $works = Work::latest()->paginate(8);
        }
        $work_categories = WorkCategoryController::getWorkCategories();
        return response()->json(['works' => $works, 'work_categories' => $work_categories], 200);
    } //end of index


    private function searchAndSearchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Work::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('work_categories.id', $categories);
        })->where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(8);
    } //end of searchAndSearchCategories


    private function searchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Work::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('work_categories.id', $categories);
        })->latest()->paginate(8);
    } //end of searchCategoies


    private function search($request)
    {
        return Work::where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(8);
    } //end of search


    public function store(StoreWorkRequest $request)
    {
        $form_data = $this->storeWorkForm($request);
        $work = Work::create($form_data);
        $this->storeWorkRelations($request, $work);
        return response()->json('work created successfully', 200);
    } //end of store


    private function storeWorkForm($request)
    {
        $form_data = $request->except(['image', 'categories']);
        $form_data['slug'] = str_replace(' ', '-', $request->title);
        if ($request->image) {
            $form_data['image'] = $this->uploadImage($request->image, 'images/works');
        }
        return $form_data;
    } //end of storeWorkForm


    private function storeWorkRelations($request, $work)
    {
        $work_categories = json_decode($request->categories);
        foreach ($work_categories as $category) {
            $work->categories()->attach($category->id);
        }
    } //end of storeWorkRelations


    public function show(Work $work)
    {
        $work['categories'] = $work->categories;
        $work['user'] = $work->user;
        return response()->json($work, 200);
    } //end of edit


    public function edit(Work $work)
    {
        $work_categories = WorkCategoryController::getWorkCategories();
        $work['categories'] = $work->categories;
        return response()->json(['work' => $work, 'workCategories' => $work_categories], 200);
    } //end of edit


    public function update(UpdateWorkRequest $request, Work $work)
    {
        $form_data = $this->updateWorkForm($request, $work);
        $work->update($form_data);
        $this->updateWorkRelations($request, $work);
        return response()->json('work updated successfully', 200);
    } //end of update


    private function updateWorkForm($request, $work)
    {
        $form_data = $request->except(['image', 'categories']);
        $form_data['slug'] = str_replace(' ', '-', $request->title);
        if ($request->image) {
            if ($work->image != 'default.jpg') {
                $this->deleteImage($work->image, 'works/');
            }
            $form_data['image'] = $this->uploadImage($request->image, 'images/works');
        }
        return $form_data;
    } //end of updateWorkForm


    private function updateWorkRelations($request, $work)
    {
        $work->categories()->detach();
        $work_categories = json_decode($request->categories);
        foreach ($work_categories as $category) {
            $work->categories()->attach($category->id);
        }
    } //end of updateWorkRelations


    public function destroy(Work $work)
    {
        if ($work->image != 'default.jpg') {
            $this->deleteImage($work->image, 'works/');
        }
        $work->categories()->detach();
        $work->delete();
        return response()->json('work deleted successfully', 200);
    } //end of destroy
}
