<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public static function generateOTP(LoginRequest $request)
    {
        $pass =  Hash::make($request->password);
        $user = User::where('email', $request->email)->where('password', $pass)->first();
        if ($user) {
            throw new Exception('Invalid username or password', 1);
        }
        DB::beginTransaction();
        $user = User::where('email', $request->email)->first();
        $verificationCode = VerificationCode::where('user_id', $user->id)->first();
        $now = Carbon::now();
        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            $user->otp = $verificationCode->otp;
            $user->expire_at = $verificationCode->expire_at;
            $response = ['status' => 'success', 'message' => 'Otp already sent.', 'user_id' => $user->id];
        } else {
            $verificationCode = VerificationCode::create([
                'user_id' => $user->id,
                'expire_at' => Carbon::now()->addMinutes(60),
                'otp' => rand(100000, 999999),
            ]);
            $user->otp = $verificationCode->otp;
            $user->expire_at = $verificationCode->expire_at;
            Mail::to($user->email)->send(new SendOtpMail($user));
            $response = ['status' => 'success', 'message' => 'Otp sent Successfully.', 'user_id' => $user->id];
        }
        DB::commit();

        session()->flash('status', $response['status']);
        session()->flash('message', $response['message']);
        return $response;
    }
    public static function verifyOTP(VerifyOtpRequest $request)
    {
        DB::beginTransaction();
        $verificationCode = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();
        $now = Carbon::now();
        if ($verificationCode && $now->isAfter($verificationCode['expire_at'])) {
            $response = ['status' => 'error', 'message' => 'Otp is expired.', 'user' => $request->user_id];
        } else {
            if ($verificationCode) {
                $user = User::where('id', $request->user_id)->first();
                if ($user) {
                    $response = ['status' => 'success', 'message' => 'User logged in'];
                    $request->session()->regenerate();
                    // VerificationCode::where('user_id', $request->user_id)->delete();
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Incorrect OTP'];
            }
        }
        DB::commit();
        session()->flash('status', $response['status']);
        session()->flash('message', $response['message']);
        return $response;
    }
}
