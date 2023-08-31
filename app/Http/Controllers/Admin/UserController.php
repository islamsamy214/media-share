<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;

use App\Models\UserSkill;
use App\Traits\FileTrait;
use App\Traits\ImageTrait;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;

class UserController extends Controller
{
    use ImageTrait, FileTrait;

    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only(['store', 'verify']);
        $this->middleware(['permission:update_users'])->only('update');
        $this->middleware(['permission:delete_users'])->only('destroy');
    } //end of construct


    public function index(Request $request)
    {
        if ($request->search) {
            $users = $this->searchUser($request);
        } else {
            $users = $this->getUsers();
        }
        return response()->json($users, 200);
    } //end of index


    public function searchUser($request)
    {
        return User::where('id', '!=', 1)
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('title', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%')
            ->withCount('works')
            ->withCount('blogs')
            ->latest()->paginate(10);
    } //end of searchUser


    public function getUsers()
    {
        return User::where('id', '!=', 1)
            ->withCount('works')
            ->withCount('blogs')
            ->latest()->paginate(10);
    } //end of getUsers


    public function store(StoreUserRequest $request)
    {
        $form_data = $this->storeUserForm($request);
        $user = User::create($form_data);
        $this->storeUserRelations($request, $user);
        return response()->json('user added successfully', 200);
    } //end of store


    private function storeUserForm($request)
    {
        //prepare the form
        $form_data = $request->except(['password', 'password_confirmation', 'image', 'cv', 'languages', 'skills', 'permissions']);
        //generate password and slug
        $form_data['password'] = bcrypt($request->password);
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        //upload image
        if ($request->image) {
            $form_data['image'] = $this->uploadImage($request->image, 'images/users');
        }
        //upload cv
        if ($request->cv) {
            $form_data['cv'] = $this->uploadFile($request->cv, 'files/cvs');
        }
        return $form_data;
    } //end of getUserForm


    private function storeUserRelations($request, $user)
    {
        //attaching langs, skills and permissions
        $languages = json_decode($request->languages);
        $skills = json_decode($request->skills);
        $permissions = json_decode($request->permissions);
        foreach ($languages as $language) {
            UserLanguage::create(['language' => $language, 'user_id' => $user->id]);
        }
        foreach ($skills as $skill) {
            UserSkill::create(['skill' => $skill, 'user_id' => $user->id]);
        }
        $user->attachRole('admin');
        $user->attachPermissions($permissions);
    } //end of storeUserRelations


    public function verify(User $user)
    {
        $user->update([
            'email_verified_at' => now(),
        ]);
        return response()->json('user verified successfully', 200);
    } //end of verify


    public function edit(User $user)
    {
        $user = $this->getUser($user);
        return response()->json($user);
    } //end of edit


    private function getUser($user)
    {
        $user_permissions = $user->allPermissions();
        $user_languages = $user->languages;
        $user_skills = $user->skills;
        $user['permissions'] = $user_permissions;
        $user['languages'] = $user_languages;
        $user['skills'] = $user_skills;
        return $user;
    } //end of getUser


    public function update(UpdateUserRequest $request, User $user)
    {
        $form_data = $this->updateUserForm($request, $user);
        $user->update($form_data);
        $this->updateUserRelations($request, $user);
        return response()->json('user updated successfully', 200);
    } //end of update


    private function updateUserForm($request, $user)
    {
        $form_data = $request->except(['image', 'cv', 'languages', 'skills', 'permissions']);
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        if ($request->image) {
            if ($user->image != 'default.jpg') {
                $this->deleteImage($user->image, 'users/');
            }
            $form_data['image'] = $this->uploadImage($request->image, 'images/users');
        }
        if ($request->cv) {
            if ($user->cv) {
                $this->deleteFile($user->cv, 'cvs/');
            }
            $form_data['cv'] = $this->uploadFile($request->cv, 'files/cvs');
        }
        return $form_data;
    } //end of getUserForm


    private function updateUserRelations($request, $user)
    {
        $languages = json_decode($request->languages);
        $skills = json_decode($request->skills);
        $permissions = json_decode($request->permissions);
        $user->languages()->delete();
        foreach ($languages as $language) {
            UserLanguage::create(['language' => $language, 'user_id' => $user->id]);
        }
        $user->skills()->delete();
        foreach ($skills as $skill) {
            UserSkill::create(['skill' => $skill, 'user_id' => $user->id]);
        }
        $user->syncPermissions($permissions);
    } //end of storeUserRelations


    public function updateProfile(UpdateUserProfileRequest $request, User $user)
    {
        $form_data = $this->updateUserProfileForm($request, $user);
        $user->update($form_data);
        $this->updateUserProfileRelations($request, $user);
        return response()->json('user updated successfully', 200);
    } //end of updateProfile


    private function updateUserProfileForm($request, $user)
    {
        $form_data = $request->except(['password', 'password_confirmation', 'image', 'cv', 'languages', 'skills']);
        $form_data['password'] = bcrypt($request->password);
        $form_data['slug'] = str_replace(' ', '-', $request->name);
        if ($request->image) {
            if ($user->image != 'default.jpg') {
                $this->deleteImage($user->image, 'users/');
            }
            $form_data['image'] = $this->uploadImage($request->image, 'images/users');
        }
        if ($request->cv) {
            if ($user->cv) {
                $this->deleteFile($user->cv, 'cvs/');
            }
            $form_data['cv'] = $this->uploadFile($request->cv, 'files/cvs');
        }
        return $form_data;
    } //end of updateUserProfileForm


    private function updateUserProfileRelations($request, $user)
    {
        $languages = json_decode($request->languages);
        $skills = json_decode($request->skills);
        $user->languages()->delete();
        foreach ($languages as $language) {
            UserLanguage::create(['language' => $language, 'user_id' => $user->id]);
        }
        $user->skills()->delete();
        foreach ($skills as $skill) {
            UserSkill::create(['skill' => $skill, 'user_id' => $user->id]);
        }
    } //end of updateUserProfileRelations


    public function destroy(User $user)
    {
        $this->destroyUserFiles($user);
        $this->destroyUserRelations($user);
        $user->delete();
        return response()->json('user deleted successfully', 200);
    } //end of destroy


    private function destroyUserFiles($user)
    {
        if ($user->image != 'default.jpg') {
            $this->deleteImage($user->image, 'users/');
        }
        if ($user->cv) {
            $this->deleteFile($user->cv, 'cvs/');
        }
    } //end of destroyUserFiles


    private function destroyUserRelations($user)
    {
        $user->languages()->delete();
        $user->skills()->delete();
        $user->detachPermissions($user->allPermissions());
        $user->detachRole('admin');
    } //end of destroyUserRelations
}
