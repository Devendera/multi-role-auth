<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{SuperAdmin, Management, Principal, Teacher, StaffMember};

class MultiRoleLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $roles = [
            'super_admin' => SuperAdmin::class,
            'management' => Management::class,
            'principal' => Principal::class,
            'teacher' => Teacher::class,
            'staff' => StaffMember::class
        ];

        foreach ($roles as $guard => $model) {
            $user = $model::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if (!$user->is_active) {
                    return back()->withErrors(['email' => 'Your account is inactive.']);
                }

                Auth::guard($guard)->login($user);

                return redirect()->route("{$guard}.dashboard");
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials. Please try again.']);
    }

    public function logout(Request $request)
    {
        foreach (['super_admin', 'management', 'principal', 'teacher', 'staff'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

