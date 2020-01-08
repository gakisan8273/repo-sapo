<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

//Authファサード
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'twitter_id', 'twitter_name', 'hash_tags', 'format', 'calcday', 'start_date', 'twitter_icon'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getMyTweets(){
        // タイムラインを取得する関数

        //User::getTweet()->tweet, created_at とかで取得するためにはどうクラスを作ればいい？

        // require('token.php');
        $bearerToken = env("TWITTER_BEARER_TOKEN"); // 公開しないものは.envから読み込む
        // エンドポイント
        // https://developer.twitter.com/en/docs/tweets/timelines/api-reference/get-statuses-user_timeline から
        $requestUrl ='https://api.twitter.com/1.1/statuses/user_timeline.json';

        //リクエストURLにパラメータを追加
        $count = 100;
        
        // 自分のstaticなメソッドを呼ぶときは$thisでなくself::
        $screen_name = self::find(Auth::user()->id)->twitter_id;

        $params = array(
            'screen_name' => $screen_name,
            'count' => $count ,
            // 'trim_user' => true,
            'include_rts' => false,
            'exclude_replies' => true,
            'tweet_mode' => 'extended',//ツイート全文が表示されるようにする　jsonがtextでなくfull_textになることに注意
        );
        // クエリ形式に変換
        if($params){
                $Qparams = http_build_query($params);
                $requestUrl .= '?'.$Qparams;
        }

        // リクエスト用のコンテキスト
        $context = array(
            'http' => array(
                'method' => 'GET' , // リクエストメソッド
                'header' => array(			  // ヘッダー
                    'Authorization: Bearer '. $bearerToken,
                ) ,
            ) ,
        ) ;

        // //ストリームコンテキストを作成 file_get_contentsのオプションとして使う時に必要　詳しくは知らん
        $Scontext = stream_context_create($context);
        // debug('コンテキスト',$Scontext);
        $json = file_get_contents($requestUrl, false, $Scontext);//ただの文字列（JSON？）なので、あとで連想配列に変換する
        // これがタイムラインのツイート１００個 full_textがツイート内容 created_atがツイート日時
        $myTweets = json_decode($json, true); //jsonを連想配列に変換 falseだとオブジェクトに変換

        return $myTweets;
    }
    public static function getFromMyTweets(){
				// 自分のタイムラインのツイートから本文のみを返す
				
        foreach (self::getMyTweets() as $key) {
            $myTweets_full_text[] = $key['full_text'];
        }
        return $myTweets_full_text;
    }

    public static function makeSearchWordsForReportTweet(){
        // 報告ツイートを検索するワードを生成する関数

        // フォーマットから[+*+] {+*+} *---* 以外のワードを抜き出し、それらを検索ワードとする
        // フォーマットは上記の変換がすでにされている

        // DBからログインユーザのusersテーブル->format を取得
        $format = self::find(Auth::user()->id)->format;

        // [+*+] and {*+*} and *---* and 全角スペースでフォーマットを分割
        $pattern = '/(\[\*\+\*\])|(\{\*\+\*\})|(\*---\*)|(\\r\\n)|　+/';
        //これが検索ワードの配列
        $searchWordsArray = preg_split($pattern, $format);

        return $searchWordsArray;
    }

    public static function getReportTweet(){
        // 自分のタイムラインのツイートから、検索ワードを含む最新のものを取得する

        // 検索ワード 配列
        $searchWordsArray = self::makeSearchWordsForReportTweet();
				// dd($searchWordsArray);
        // タイムラインのツイート 配列
        // $myTweets_full_text = self::getFromMyTweets();
        $myTweets = self::getMyTweets();
        // dd($myTweets_full_text);
        
        foreach ($myTweets as $tweet) {
					
					$flg = 1; // 検索ワード一致判定フラグ

					// 検索ワードがツイートに含まれるかどうか判定
					// dd($tweet);
					foreach ($searchWordsArray as $searchWord){
						// $searchWord がカラ文字だとsrtposでエラーになるので、弾いておく
						if ($searchWord){
							if ( strpos($tweet['full_text'], $searchWord) === false){
								// 一致しないものがあればflgを０にする
								$flg = 0;
								// dd('test');
							} else {
								// 一致したら
								// dd('一致', $tweet, $searchWord, $flg);
							}
						}
						// dd('test');
						// dd($searchWord,$tweet,strpos($tweet, $searchWord), $flg );
					}
					
					if ($flg) {
						// 検索ワードが全て一致（flg=1)なら、変数を格納
						// $latestReportTweet = $tweet;
						$created_at = date('Y-m-d H:i', strtotime($tweet['created_at']) );
						$latestReportTweet = array(
							"tweet" => $tweet['full_text'],
							"created_at" => $created_at,
							"created_at_forJS" => $tweet['created_at'],
							"found" => true,
						);
						// foreachを抜けたい
						// dd('test');
						break;
					} else {
						// $latestReportTweet = "過去100件のツイートに報告ツイートが見つかりませんでした";
						$latestReportTweet = array(
							"tweet" => "過去100件のツイートに報告ツイートが見つかりませんでした",
							"created_at" => "",
							"created_at_forJS" => "",
							"found" => false,
						);
					}
				}
				//最新の報告ツイートを返す
				// dd($latestReportTweet);
				return $latestReportTweet;
    }
}
