<?php
// namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
// use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Socialite;
use App\User;

class AuthController extends Controller
{
    public function redirectToProvider()
    {   
        $url = Socialite::driver('twitter')->redirect()->getTargetUrl();
        return response()->json(['redirect_url' => $url]);
    }
    public function handleTwwiterCallback(){
        $data  = Socialite::driver('twitter')->user();
        $twitter_id=$data->getId();
        //if where getId() get accesstoken
        $socialAccount = User::firstOrNew([
            'twitter_id' => $twitter_id,
        ]);
        if ($socialAccount->exists) {
            //user already account
            $user = User::TwitterId($socialAccount->twitter_id)->first();
        }else{
            //user not account
            $user = User::create([
                'name' => $data->getNickname(),
                'twitter_id' => $data->getId(),
                'img_path' => $data->getAvatar()
            ]);
        }

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken(null, ['*'])->accessToken,
        ]);
    }
    
    public function user(Request $request){
        return $request->user();
    }
}