<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller
{
    public function index(){
			if (Auth::user()){
        $user = User::find(Auth::user()->id);
        // $myTweets = User::getMyTweets();
				$latestReportTweet = User::getReportTweet();
				return view('make.make', 
				['user'=>$user,'latestReportTweet_tweet'=>$latestReportTweet['tweet'],
				'latestReportTweet_time'=>$latestReportTweet['created_at'],
				'latestReportTweet_time_for_js' =>$latestReportTweet["created_at_forJS"] ]);
			} else {
				return view('make.make',['user'=>""]);
			}
    }

    public function login(){
			if (Auth::user()){
				$user = User::find(Auth::user()->id);
				return view('login.login', compact('user'));
			} else {
        return view('login.login',['user'=>""]);
			}
    }

    public function format(){
			if (Auth::user()){
        $user = User::find(Auth::user()->id);
        // $user = json_encode($user);
				return view('format.format', compact('user'));
			} else {
				return view('format.format', ['user'=>""]);
			}
    }

    public function calcday(){
			if (Auth::user()){
				$user = User::find(Auth::user()->id);
				return view('calcday.calcday', compact('user'));
			} else {
				return view('calcday.calcday', ['user'=>""]);
			}

    }

    public function editFormat(Request $request){
        $user = User::find(Auth::user()->id);
        $user->hash_tags = $request['hash_tags'];
        $user->format = $request['format'];
        $user->save();

        return redirect('/make');
    }
    public function editCalcday(Request $request){
        $user = User::find(Auth::user()->id);
				$user->calcday = $request['calc_option'];
				// calcdayが３なら、学習開始日をDBに保存
				if ($request['calc_option'] === "3"){
					// dd($request['start_date']);
					$user->start_date = $request['start_date'];
				}

				$user->save();
				

        return redirect('/make');
    }


    // login
    public function redirectToProvider(){
        return Socialite::driver('twitter')->redirect();
    }

    // callback
    public function handleProviderCallback(){

        $twitterUser = Socialite::driver('twitter')->user();
        $twitter_id = $twitterUser->nickname; //ツイッターID
        $twitter_name = $twitterUser->name; //表示名
				$twitter_icon = $twitterUser->avatar_original; //アイコン画像のURLを保存する
        // var_dump($twitter_id);
        // var_dump($twitterUser);
				// $path = $request->file->store('public');
				// dd($twitter_icon);
        // 各自ログイン処理 初回はDBに登録、2回目以降は認証のみ
        // 例

        // twitter_idがDBに登録されているかチェック
        // されていればログイン処理のみ、いなければDBに新規登録
        $user = User::where('twitter_id', $twitter_id)->first();
        if ($user) {

        }else{
            $user = User::create([
                'twitter_id' => $twitter_id,
                'twitter_name' => $twitter_name,
								'twitter_icon' => $twitter_icon,
          ]);
        }
        // こうすると $user（ユーザーインスタンス）でログイン中になるのかな？
        Auth::login($user);

        // formatビューに値を渡す $user（ログインユーザのuserテーブルの中身すべて）を渡す
        // return redirect( '/format');
        return redirect('/format');
    }

    // logout
    public function logout(Request $request){
        // ログアウト処理
        // ex
        Auth::logout();
        return redirect('/make');
    }


}
