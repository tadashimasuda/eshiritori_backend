<?php
// namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
// use Laravel\Socialite\Facades\Socialite;
use Socialite;

class AuthController extends Controller
{
    public function redirectToProvider()
    {   
        $url = Socialite::driver('twitter')->redirect()->getTargetUrl();
        return response()->json(['redirect_url' => $url]);
    }
    public function handleTwwiterCallback(){
        $data  = Socialite::driver('twitter')->user();
        $name = $data->getNickName();
        return $name;
    }
    
}