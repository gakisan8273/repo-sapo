@extends('head.head')

@section('content')

<main class="container container-column readme" >
  {{-- Laravel x S3 練習用 --}}
  {{-- <form action="/upload" method="post" enctype="multipart/form-data"> --}}
    {{-- {{ csrf_field() }} --}}
    {{-- <input type="file" name="file"> --}}
    {{-- <button type="submit">保存</button> --}}
  {{-- </form> --}}
{{-- Laravel x S3 練習用 --}}

  <h3>作った人</h3>
<p><a href="https://twitter.com/gakisan8273">がき@gakisan8273</a></p>

<h3>このwebアプリの目的</h3>
<p>以下のような学習進捗ツイートをしやすくすし、学習者の負担を少しでも下げることを目的としています</p>
<p>すぐに使いたい方は、<a href="/">こちら</a>で報告フォーマットの登録をお願いします</p>


<blockquote class="twitter-tweet"><p lang="ja" dir="ltr">Day: 83<br>today:6h<br>total: 234h<br>自作ツール(進捗報告支援)開発<br><br>ロジックが整理できた（と思う）<br><br>次やること<br>・残り機能を実装する<br>・こんな風に言語を使い分ける<br>　ーPHPはサーバからデータを引っ張ってくる、渡す<br>　ーJSはそのデータを加工する<br><br>頭が冴えてる日中にやりたい😂<a href="https://twitter.com/hashtag/%E3%82%A6%E3%82%A7%E3%83%96%E3%82%AB%E3%83%84?src=hash&amp;ref_src=twsrc%5Etfw">#ウェブカツ</a></p>&mdash; がき@地方で強く生きていく (@gakisan8273) <a href="https://twitter.com/gakisan8273/status/1166398906520883200?ref_src=twsrc%5Etfw">August 27, 2019</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

<p>このツイートをするには、通常このようなステップを踏みます</p>
<ol>
  <li>自分のプロフィールのタイムラインから、直近の報告ツイートを探す</li>
  <li>1 を開き、内容をコピーする</li>
  <li>ツイート画面で貼り付け、日数と学習時間を手で更新する</li>
  <li>余分な文を消去する</li>
  <li>本文を入力する</li>
  <li>ツイートする</li>
</ol>

<p>このwebアプリにより、このように改善されます</p>
<ol>
  <li>このwebアプリを開く</li>
  <li>専用フォームに学習時間を入力する（日数は自動更新）</li>
  <li>本文を入力する</li>
  <li>ツイートする</li>
</ol>
<p>詳細は<a style="display:inline-block" href="https://gakisan8273.com/blog/xhack-report-api/">この記事</a>に記載されています</p>

<h3>使い方</h3>
<p>Twitterログインを採用しています。</p>
<p>ログイン後、初回のみ<a href="resister.php">報告フォーマットを登録</a>してください</p>
<p>これだけで新規報告ツイートの作成準備は整います</p>
<p>一度フォーマットを登録すれば、次回以降は登録し直す必要はありません</p>
<p>ブックマークは、<a href="/">新規報告ツイート画面</a>をお勧めします</p>

<h3>お問い合わせ</h3>
<p>できるだけ説明なしに使えるように配慮したつもりです</p>
<p>不明点・疑問点・苦情・応援・意見などあれば<a href="https://twitter.com/gakisan8273">僕のTwitterアカウント</a>まで連絡ください</p>

</main>

@endsection