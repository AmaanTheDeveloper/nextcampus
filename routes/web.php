<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// GOOGLE SOCIALITE LOGIN ROUTES
Route::get("/auth/google",function(){

return Socialite::driver('google')->redirect();
})->name('googlelogin');

Route::get("/auth/google/callback",function(){
    try{
$googleuser = Socialite::driver('google')->stateless()->user();

$user=\App\Models\User::FirstOrCreate([
'email'=>$googleuser->email,
],
[
 'name'=>$googleuser->name,
 'password'=>bcrypt(Str::random(16)),
]);

Auth::login($user);

return redirect()->route('dashboard');
}
catch (\Exception $e) {
        // Agar Google login mein koi error aaye toh wapis bhej dein
        return redirect('/')->with('error', 'Google login nakam raha.');
    }

});