<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    public function index () {
        $users = User::all();
        return response()->json($users);
    }

    public function store (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('email')),
        ]);

        return response()->json(['message' => 'user created'], Response::HTTP_CREATED);
    }
    public function show ($id) {
        $user = User::find($id);
        return ($user) ? response()->json($user) : response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }

    public function update (Request $request, $id) {
        $user = User::find($id);
        if($user) {
        $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required|min:3',
        ]);

        User::where('id','=',$id)->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('email')),
        ]);
        return response()->json(['message' => 'user id: '.$id.' name && password updated'], Response::HTTP_ACCEPTED);
    } else {
        return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }
    }

    public function destroy ($id) {
        User::where('id','=',$id)->delete();
        return response()->json(['message' => 'user id: '.$id. ' is deleted']);
    }
}
