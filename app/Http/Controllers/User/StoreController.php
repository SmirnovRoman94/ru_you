<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $data['email'])->first();
        if($user) return response(['mess' => 1]);

        $user = User::create($data);
        $token = auth()->tokenById($user -> id);
        return response(['mess' => 2, 'access_token' => $token]);
    }

    public function index()
    {
        $items =  auth()->user()->friends()->pluck('id');

        $users = User::whereNotIn('id', $items)
            ->where('id', '!=', auth()->id())
            ->get();
        return UserResource::collection($users)->resolve();

    }
    public function add(\App\Http\Requests\Friend\StoreRequest $request)
    {
       $data = $request->validated();
       auth()->user()->friends()->sync($data['user'], false);
       return response(['mess' => 1]);
    }

    public function friendsItems()
    {
        $items =  auth()->user()->friends()->get();
        return UserResource::collection($items)->resolve();
    }
}
