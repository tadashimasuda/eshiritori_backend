<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Resources\User as UserResourse;
use App\Http\Resources\UserShow as UserShowResourse;

use Socialite;
use App\User;
use Abraham\TwitterOAuth\TwitterOAuth;


class AuthController extends Controller
{
    public function redirectToProvider()
    {   
        $url = Socialite::driver('twitter')->redirect()->getTargetUrl();
        return response()->json(['redirect_url' => $url]);
    }
    public function handleTwitterCallback(){
        $data  = Socialite::driver('twitter')->user();
        $social_id = $data->getId();
        //if where getId() get accesstoken
        $socialAccount = User::firstOrNew([
            'social_id' => $social_id,
        ]);
        if ($socialAccount->exists) {
            //user already account
            $user = User::TwitterId($socialAccount->social_id)->first();
        }else{
            //user not account
            $user = User::create([
                'social_id'=> $data->getId(),
                'name' => $data->getName(),
                'twitter_id' => $data->getNickname(),
                'img_path' => $data->getAvatar()
            ]);
        }
        return response()->json([
            'user' => $user,
            'access_token' => $user -> createToken('access_token') ->accessToken,
        ]);
    }
    
    public function user(Request $request){
        $user = $request->user();
        return response()->json(['user' => $user]);
    }

    public function update(UpdateUserRequest $request){
        $id =$request->user()->id;
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'profile' => $request->profile
        ]); 
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken(null, ['*'])->accessToken,
        ]);
    }
    
    public function index(User $user)
    {
        $user= User::latestFirst()->paginate(10);
        return UserResourse::collection($user);
    }

    public function show(Request $request)
    {
        $user = User::find($request->id);
        return new UserShowResourse($user);
    }
    public function followers(Request $request)
    {
        $consumer_key = config('twitter.twitter-api'); 
        $consumer_secret = config('twitter.twitter-api-secret'); 
        $access_token = config('twitter.twitter-token'); 
        $access_token_secret = config('twitter.twitter-token-secret'); 
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret); 
        $options = [
            "user_id" => $request->user()->social_id,
        ];
        $followers = $connection->get('followers/list', $options); 
        $followers_list = [];
        foreach($followers->users as $follower){
            $arange = array(
                'name' =>$follower->name,
                'screeen_name' =>$follower->screen_name,
            );
            array_push($followers_list,$arange);
        }
        return response()->json(['followers'=>$followers_list,'next_cursor'=>$followers->next_cursor], 200);
    }
}