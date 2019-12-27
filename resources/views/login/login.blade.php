@extends('head.head')

@section('content')

  <main class="container container-login">
    <div class="login">
      <p class="login-sentence">新規登録・ログイン</p>
      <button class="main-btn login-btn" onclick="location.href='/auth/twitter'">
          <i class="fab fa-twitter"></i>
          Twitterアカウント認証
      </button>
    </div>
  </main>

@endsection