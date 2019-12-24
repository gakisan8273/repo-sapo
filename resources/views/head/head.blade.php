<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  {{-- レスポンシブはこの行を追加する --}}
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  <title>れぽさぽ for twitter</title>
</head>
<body>
  {{-- ヘッダーを差し込む --}}
  @include('header.header')

  {{-- コンテンツを差し込む --}}
  @yield('content')

  {{-- フッターを差し込む --}}
  @include('footer.footer')
</body>
</html>