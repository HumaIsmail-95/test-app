<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Providers\RouteServiceProvider;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            $response = AuthService::generateOTP($request);
            return redirect(route('verification', ['user_id' => $response['user_id']]));
        } catch (\Throwable $th) {
            return back()->with(['status' => 'error', 'message' => $th->getMessage()]);
            Log::error($th->getMessage());
            dd($th->getMessage());
        }
    }
    public function verification(Request $request)
    {
        return view('auth.otp-verification');
    }
    public function verifyUser(VerifyOtpRequest $request)
    {

        try {
            $response = AuthService::verifyOTP($request);

            if ($response['status'] == 'success') {
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                return back();
            }
            //code...
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            dd($th->getMessage());

            //throw $th;
        }
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
