<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118005303-4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-118005303-4');
  </script>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="twitter:card" content="summary" /> <!--①-->
  <meta name="twitter:site" content="@gakisan8273" /> <!--②-->
  <meta property="og:url" content="https://repo-sapo.gakisan8273.com/" /> <!--③-->
  <meta property="og:title" content="れぽさぽ for twitter" /> <!--④-->
  <meta property="og:description" content="学習時間ツイートを手間なく生成し、貴方の貴重な時間を節約します" /> <!--⑤-->
  <meta property="og:image" content="https://gakisan8273.com/img/repo-sapo_card.png" /> <!--⑥-->

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118005303-2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-118005303-2');
  </script>


  {{-- レスポンシブはこの行を追加する --}}
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="shortcut icon" href="/assets/images/favicon.ico">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  
  
  <title>れぽさぽ for twitter</title>
</head>
<body>
  {{-- ヘッダーを差し込む --}}
  @include('header.header',['user'=>$user])

  {{-- コンテンツを差し込む --}}
  @yield('content')

  {{-- フッターを差し込む --}}
  @include('footer.footer')

  <script src="{{ asset('js/app.js')}}"></script>
  <script>
    let ftr = document.getElementById('footer');
    //window高さを取得し、フッターの開始位置と比較する
    // jQueryでなく生JSで書く
    // ウィンドウ高さの方が高い→画面中央よりにフッターが表示されている　のであれば、フッター開始位置を最下部＋フッター高さにする
    let windowHeight = window.innerHeight;
    let ftrHeight = ftr.clientHeight;
    // let ftrPosition = ftr.offset().top;
    let rect = ftr.getBoundingClientRect();
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let ftrPosition = rect.top + scrollTop;
    let ftrPosition_bottom = rect.bottom + scrollTop;
    // console.log('ウィンドウ高さ' + windowHeight);
    // console.log('フッター自身の高さ' + ftrHeight);
    // console.log('フッターの初期位置' + ftrPosition);
    let set = (windowHeight - ftrHeight)  - ftrPosition;
    // console.log({windowHeight});
    // console.log({ftrHeight});
    // console.log({ftr});
    // console.log({ftrPosition});
    // console.log(rect.top);
    // console.log(rect.bottom);
    // console.log({scrollTop});
    if(windowHeight > ftrPosition + ftrHeight){
      // console.log('in if');
      // ftr.attr({'style': 'top:' + ( (windowHeight - ftrHeight)  - ftrPosition) + 'px'});
      ftr.style.top = set + 'px';
      // フッターの今のポシション＋α　にしたい
      // ウィンドウの最下部-フッター高さ　＝　フッター開始位置
      // 今のフッター高さ
      // フッター開始位置　ー　今のフッター高さ　をtopに指定し、relativeのままでいく
      console.log('フッター高さ変更');
    }else{
      console.log('フッター高さ変更なし');
    }  
  </script>
</body>
</html>