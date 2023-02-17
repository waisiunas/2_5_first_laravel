<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345'),
        ];

        $is_user_created = User::create($data);

        if($is_user_created) {
            return redirect()->back()->with(['success' => 'Magic has been spelled']);
        } else {
            return redirect()->back()->with(['error' => 'Magic has failed to spell']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,'. $user->id . ',id'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        $is_user_updated = User::find($user->id)->update($data);

        if($is_user_updated) {
            return redirect()->back()->with(['success' => 'Magic has been spelled']);
        } else {
            return redirect()->back()->with(['error' => 'Magic has failed to spell']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $is_user_deleted = User::find($user->id)->delete();

        if($is_user_deleted) {
            return redirect()->back()->with(['success' => 'Magic has been spelled']);
        } else {
            return redirect()->back()->with(['error' => 'Magic has failed to spell']);
        }
    }
}
