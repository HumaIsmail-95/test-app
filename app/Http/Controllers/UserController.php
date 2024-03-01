<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){
        $response = User::paginate(10);
        return view('user.index',compact('response'));
    }

    public function create(){
        return view('user.create');
    }

    public function store(UserRequest $request){
        try {
            $response = UserService::store($request);
            return redirect(route('users.index'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }
    public function show(User $user){
        try {
            return view('user.edit',compact('user'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }
    }

    public function update(UserRequest $request, User $user){
        try {
            $respponse = UserService::update($request,$user);
            return redirect(route('users.index'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            //throw $th;
        }
    }
    public function destroy(User $user){
        try {
            $response = UserService::destroy( $user);
            return back();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            //throw $th;
        }
    }
}
