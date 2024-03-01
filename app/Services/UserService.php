<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function store(UserRequest $request)
    {
        DB::beginTransaction();
        $response = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
        ]);
        session()->flash('status', 'success');
        session()->flash('message', 'User registered successfully');
        DB::commit();
        return $response;
    }
    public static function update(UserRequest $request, User $user){
        DB::beginTransaction();
        
        $response = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
        ]);
        session()->flash('status', 'success');
        session()->flash('message', 'User updated successfully');
        DB::commit();
        return $response;
    }
    public static function destroy(User $user){
        DB::beginTransaction();
        $user_id = $user->id;
        $response = $user->delete($user_id);
        session()->flash('status', 'success');
        session()->flash('message', 'User record deleted successfully');
        DB::commit();
        return;
    }
}
