@extends('head.head')

@section('content')

  <main class="container">
    <form class="make_format" method="post" action="/make">

      @csrf

      <div class="make_format-id">
        <label for="" class="label">Twitter ID</label>
        <input type="text" disabled class="edit_disabled make_format-id-input" placeholder="{{ $user->twitter_id }}">
      </div>
      <div class="make_format-hash">
        <label for="" class="label">ハッシュタグ</label>
        <textarea name="hash_tags" id="" cols="30" rows="3" class="tweet-show today-tweet-show">{{ $user->hash_tags }}</textarea>
      </div>

      <div id="app">
        {{-- @php
          var_dump($user->format);
          var_dump(json_decode(json_encode($user->format)));
        @endphp --}}
        {{-- prposで渡す時、データに半角スペース・改行が含まれると渡せない --}}
        {{-- DB登録時、半角スペースと改行を別の文字に変換して登録、propsで渡してから半角スペースと改行に戻す？ --}}
        {{-- make-format -ここに全角スペースが入っていたことが原因だった- format --}}
        <make-format format="{{ $user->format }}">
        </make-format>
        
      </div>

      <button class="today-make_tweet main-btn">
          {{-- <i class="fab fa-twitter"></i> --}}
          フォーマット登録/変更
      </button>
    </form>

    <div class="ex_format">

          <div class="ex_format-hash">
            <label for="" class="label">ハッシュタグ例</label>
            <textarea disabled name="" id="" cols="30" rows="3" class="tweet-show today-tweet-show edit_disabled">
#今日の積み上げ
#駆け出しエンジニアと繋がりたい
            </textarea>
          </div>

          <div class="ex_format-format">
              <label for="" class="label">フォーマット例</label>
              <textarea name="" id="" cols="30" rows="5" class="tweet-show today-tweet-show edit_disabled" disabled>
Day : [85]　　　　　　　　　　
Today : {5.5}h / 補足 {2}h　　　
Total : {50時間30分} / 補足 {75h}  
*—*
              </textarea>
          </div>

          <div class="ex_format-format">
              <label for="" class="label">フォーマット登録規則</label>
              <textarea name="" id="" cols="30" rows="5" class="tweet-show today-tweet-show edit_disabled" disabled>
・日数は[ ]で囲う
・毎回更新したい数字を{ } で囲う
（単位も囲うことができる）
・前回ツイートからコピペしたい行は *—* を入力
・ハッシュタグはここに記入するか、上の入力欄に記入する
              </textarea>
          </div>

      </div>
  </main>

@endsection