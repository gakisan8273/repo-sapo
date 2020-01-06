<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //S3用

class TwitterController extends Controller
{

    public function index(){
			// $path = Storage::disk('s3')->url('repo-sapo_logo.png');
			if (Auth::user()){
        $user = User::find(Auth::user()->id);
        // $myTweets = User::getMyTweets();
				$latestReportTweet = User::getReportTweet();
				return view('make.make', 
				['user'=>$user,'latestReportTweet_tweet'=>$latestReportTweet['tweet'],
				'latestReportTweet_time'=>$latestReportTweet['created_at'],
				'latestReportTweet_time_for_js' =>$latestReportTweet["created_at_forJS"]],
				);
				// return view('make.make', 
				// ['user'=>$user,'latestReportTweet_tweet'=>$latestReportTweet['tweet'],
				// 'latestReportTweet_time'=>$latestReportTweet['created_at'],
				// 'latestReportTweet_time_for_js' =>$latestReportTweet["created_at_forJS"],
				// 'logo'=>$path]);
			} else {
				return view('make.make',['user'=>""]);
				// return view('make.make',['user'=>"",'logo'=>$path]);
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
		public function readme(){
			if (Auth::user()){
				$user = User::find(Auth::user()->id);
				return view('readme.readme', compact('user'));
			} else {
        return view('readme.readme',['user'=>""]);
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

        return redirect('/');
    }
    public function editCalcday(Request $request){
        $user = User::find(Auth::user()->id);
				$user->calcday = $request['calc_option'];
				// calcdayが３なら、学習開始日をDBに保存
				if ($request['calc_option'] === "3"){
					// dd($request['start_date']);
					$user->start_date = $request['start_date'];
				}

				// バリデーション validateを使って書く フォームリクエストはあとで書く
				// TODO フォームリクエストでバリデーション書き直す
				// ラジオボタンのいずれかがあるか・日付がyyyy-mm-ddか

				$validate_rule = [
					'calc_option' => 'required',
					'start_date' => 'date_format:Y-m-d'
				];
				$validate_message = [
					'calc_option.required' => "ラジオボタンのいずれかにチェックを入れて下さい",
					'start_date.date_format:Y-m-d' => "yyyy-mm-dd 形式で入力してください"
				];

				$request->validate($validate_rule);

				$user->save();
				

        return redirect('/');
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
        return redirect('/');
    }

		public function upload(Request $request)
{
    $file = $request->file('file');
    // 第一引数はディレクトリの指定
    // 第二引数はファイル
    // 第三引数はpublickを指定することで、URLによるアクセスが可能となる
    // $path = Storage::disk('s3')->putFile('/', $file, 'public');
    $path = Storage::disk('s3')->putFileAs('/', $file, 'repo-sapo_logo.png', 'public');
    // hogeディレクトリにアップロード
    // $path = Storage::disk('s3')->putFile('/hoge', $file, 'public');
    // ファイル名を指定する場合はputFileAsを利用する
    // $path = Storage::disk('s3')->putFileAs('/', $file, 'hoge.jpg', 'public');
    return redirect('/');
}
}
