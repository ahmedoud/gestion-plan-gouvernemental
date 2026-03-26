<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [];

        if (!$this->checkEmailExists($request->email)) {
            $errors['email'] = "L'adresse e-mail saisie est incorrecte.";
        } elseif (!$this->checkPasswordMatches($request->email, $request->password)) {
            $errors['password'] = "Le mot de passe saisi est incorrect.";
        } else {
            $errors['email'] = "Identifiants incorrects.";
        }

        throw \Illuminate\Validation\ValidationException::withMessages($errors);
    }

    private function checkEmailExists($email)
    {
        return User::where('email', $email)->exists();
    }

    private function checkPasswordMatches($email, $password)
    {
        $user = User::where('email', $email)->first();
        return $user && Hash::check($password, $user->password);
    }

    public function logout(Request $request)
{
    Auth::logout();
    return redirect('/login');
}

}
