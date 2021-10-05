<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        if ($request->search) {
            $users = $this->searchUser($request);
        } else {
            $users = $this->getUser();
        }
        return response()->json($users, 200);
    } //end of getUsers

    private function searchUser($request)
    {
        return User::where('id', '!=', 1)
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('title', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->with('languages')
            ->with('skills')
            ->withCount('works')
            ->withCount('blogs')
            ->orderBy('works_count', 'DESC')
            ->latest()->paginate(3);
    } //end of searchUser

    private function getUser()
    {
        return User::where('id', '!=', 1)
            ->with('languages')
            ->with('skills')
            ->withCount('works')
            ->withCount('blogs')
            ->orderBy('works_count', 'DESC')
            ->latest()->paginate(3);
    } //end of getUser
}
