@extends('head.head')

@section('content')

  <main class="container container-login container-column">
    <div class="login">
      <p class="login-sentence">新規登録・ログイン</p>
      <button class="main-btn login-btn" onclick="location.href='/auth/twitter'">
          <i class="fab fa-twitter"></i>
          Twitterアカウント認証
      </button>
    </div>

    <div class="login">
      <p class="login-sentence">ログアウト</p>
      <button class="sub-btn" onclick="location.href='/auth/twitter/logout'">
          ログアウト
      </button>
    </div>


  </main>

@endsection