<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class WorkController extends Controller
{
    public function getWorks(Request $request)
    {
        if ($request->search && $request->searchcategories) {
            $works = $this->searchAndSearchCategories($request);
        } else if ($request->searchcategories) {
            $works = $this->searchCategories($request);
        } else if ($request->search) {
            $works = $this->search($request);
        } else {
            $works = Work::latest()->paginate(6);
        }
        $work_categories = WorkCategoryController::getWorkCategories();
        return response()->json(['works' => $works, 'work_categories' => $work_categories], 200);
    } //end of getWorks

    private function searchAndSearchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Work::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('work_categories.id', $categories);
        })->where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(6);
    } //end of searchAndSearchCategories

    private function searchCategories($request)
    {
        $categories = explode(',', $request->searchcategories);

        return Work::whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('work_categories.id', $categories);
        })->latest()->paginate(6);
    } //end of searchCategoies

    private function search($request)
    {
        return Work::where('title', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->latest()->paginate(6);
    } //end of search

    public function getWork(Work $work)
    {
        $work['categories'] = $work->categories;
        $work['user'] = $work->user;
        return response()->json($work, 200);
    } //end of getWork
}
