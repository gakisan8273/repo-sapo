@extends('head.head')

@section('content')

  <main class="container">
    <form class="make_format" method="post" action="/post-business-format">

      @csrf

      <div class="make_format-id">
        <label for="" class="label">Twitter ID</label>
        @if ($user)
          <input type="text" disabled class="edit_disabled make_format-id-input" placeholder="{{ $user->twitter_id }}">
        @else
          <input type="text" disabled class="edit_disabled make_format-id-input" placeholder="（ログインしていません）">
        @endif
      </div>
      <div id="app">
        {{-- prposで渡す時、データに半角スペース・改行が含まれると渡せない --}}
        {{-- DB登録時、半角スペースと改行を別の文字に変換して登録、propsで渡してから半角スペースと改行に戻す？ --}}
        {{-- make-format -ここに全角スペースが入っていたことが原因だった- format --}}
        @if ($user)
          <edit-business-format hash_tags="{{ $user->business_hash_tags }}"
            start_date="{{ $user->business_start_date }}"
            calcday="{{ $user->business_calcday }}"
            user="{{ $user->twitter_id }}"
            @if ( count($errors) > 0)
             error = "yyyy-mm-dd形式で入力して下さい"
              {{-- @foreach ($errors->all() as $error)
                error = "{{ $error }}"
              @endforeach --}}
            @else
             error = ""
            @endif
            ></edit-business-format>
        @else
          <edit-business-format hash_tags="" start_date="" calcday="1" user=""></edit-business-format>
        @endif
      </div>
      
    </form>

    <div class="ex_format">

          <div class="ex_format-hash">
            <label for="" class="label">ハッシュタグ例</label>
            <textarea disabled name="" id="" cols="30" rows="3" class="tweet-show today-tweet-show edit_disabled">
#今日の積み上げ
#駆け出しエンジニアと繋がりたい
#プログラミング 
            </textarea>
          </div>

          <div class="ex_format-format">
              <label for="" class="label">こんな風に出力されます</label>
              <textarea name="" id="" cols="30" rows="5" class="tweet-show today-tweet-show edit_disabled" disabled>
#業務日記
20日目 (もしくは 3週目-1)

#今日の積み上げ
#駆け出しエンジニアと繋がりたい
#プログラミング
              </textarea>
          </div>

          {{-- <div class="ex_format-format">
              <label for="" class="label">フォーマット登録規則</label>
              <textarea name="" id="" cols="30" rows="5" class="tweet-show today-tweet-show edit_disabled" disabled>
・日数は[ ]で囲う
・毎回更新したい数字を{ } で囲う
（単位も囲うことができる）
・前回ツイートからコピペしたい行は *—* を入力
・ハッシュタグはここに記入するか、上の入力欄に記入する
              </textarea>
          </div> --}}

      </div>
  </main>

@endsection