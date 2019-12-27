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
        return view('make.make');
    }

    public function login(){
        return view('login.login');
    }

    public function format(){
        $user = User::find(Auth::user()->id);
        // $user = json_encode($user);
        return view('format.format', compact('user'));
    }

    public function calcday(){
        return view('calcday.calcday');
    }

    public function editFormat(Request $request){
        $user = User::find(Auth::user()->id);
        $user->hash_tags = $request['hash_tags'];
        $user->format = $request['format'];
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
        $twitter_icon = $twitterUser->avatar; //アイコン画像のURL
        // var_dump($twitter_id);
        // var_dump($twitterUser);

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
                // iconはDB修正してから
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
        // Auth::logoutl
        return redirect('/');
    }


}
