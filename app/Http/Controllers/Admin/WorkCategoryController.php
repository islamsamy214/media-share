<?php

namespace App\Http\Controllers\Admin;

use App\Models\WorkCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkCategoryRequest;
use App\Http\Requests\UpdateWorkCategoryRequest;

class WorkCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_work_categories'])->only('index');
        $this->middleware(['permission:create_work_categories'])->only('store');
        $this->middleware(['permission:update_work_categories'])->only('update');
        $this->middleware(['permission:delete_work_categories'])->only('destroy');
    } //end of construct

    public function index(Request $request)
    {
        if ($request->search) {
            $work_categories = $this->searchWorkCategories($request);
        } else {
            $work_categories = WorkCategory::withCount('works')->latest()->paginate(10);
        }
        return response()->json($work_categories, 200);
    } //end of index


    private function searchWorkCategories($request)
    {
        return WorkCategory::where('name', 'like', '%' . $request->search . '%')
            ->withCount('works')->latest()->paginate(10);
    } //end of searchWorkCategories


    public static function getWorkCategories()
    {
        return WorkCategory::get();
    } //end of getCategories


    public function store(StoreWorkCategoryRequest $request)
    {
        $form_data = $request->all();
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        WorkCategory::create($form_data);
    } //end of store


    public function edit(WorkCategory $workcategory)
    {
        return response()->json($workcategory, 200);
    } //end of edit


    public function update(UpdateWorkCategoryRequest $request, WorkCategory $workcategory)
    {
        $form_data = $request->all();
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        $workcategory->update($form_data);
    } //end of update


    public function destroy(WorkCategory $workcategory)
    {
        $workcategory->works()->detach();
        $workcategory->delete();
    } //end of destroy
}
