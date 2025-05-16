<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        //without create and store middleware
        $this->middleware(['auth:sanctum', 'admin'])->except(['store']);
    }

    public function index()
    {
        $users = User::all();
        return view('admin.user_dashboard', compact('users'));
    }

    public function create()
    {
        
    }

    public function edit()
    {

    }

    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return view('email.verify');
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::findOrFail($id);
        $user->update($data);

        return back()->with('message', 'User updated successfully');
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('message', 'User deleted successfully');
    }
}
