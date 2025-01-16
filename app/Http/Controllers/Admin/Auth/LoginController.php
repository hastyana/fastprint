<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->redirectTo = route('admin.dashboard');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('cms.admin.content.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Validasi role, pastikan role adalah string dan harus 'admin'
            if ($user->role !== 'admin') {
                return redirect()->route('admin.login')->with([
                    'status' => 'error',
                    'message' => 'Tidak bisa masuk, karena anda bukan admin'
                ]);
            }

            // Validasi apakah user aktif
            if ($user->is_active) {
                if ($this->attemptLogin($request)) {
                    // Logout dari perangkat lain jika diaktifkan
                    // \Auth::logoutOtherDevices($request->password);

                    return $this->sendLoginResponse($request);
                }

                // Jika login gagal, tambahkan percobaan login
                $this->incrementLoginAttempts($request);
            } else {
                $this->incrementLoginAttempts($request);

                return redirect()->route('admin.login')->with([
                    'status' => 'error',
                    'message' => 'Tidak bisa masuk, karena akun anda tidak aktif'
                ]);
            }

            // Jika validasi lainnya gagal, tambahkan percobaan login
            $this->incrementLoginAttempts($request);
        }

        // Jika semua upaya login gagal, kirim respons gagal login
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect()->route('admin.login');
    }

    /**
     * Get the needed authorization credentials from the request
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password')
        ];
    }

    /**
     * Determine if the request field is email or username
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function field(Request $request)
    {
        $email = $this->username();
        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    /**
     * Get the login username to be used by controller
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}