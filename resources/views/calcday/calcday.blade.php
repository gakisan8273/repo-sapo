@extends('head.head')

@section('content')

<main class="container">
  <div class="calcday">
    <div class="form-check">
      <input type="radio" class="form-check-input" name="calc_option" id="radio1a" value="1">
      <label for="radio1a" class="form-check-label">Option 1 (default)</label>
      <p class="calc-title">前回ツイート日からの経過日数計算</p>
      <p>前回の報告ツイート内にある日数を取得し、<br>そこから何日経過したかを計算します</p>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" name="calc_option" id="radio1b" value="2">
      <label for="radio1b" class="form-check-label">Option 2</label>
      <p class="calc-title">学習した日付のみの日数をカウント</p>
      <p>前回の報告ツイート内にある日数を取得し、<br>それに＋１します</p>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" name="calc_option" id="radio1c" value="3">
      <label for="radio1c" class="form-check-label">Option 3</label>
      <p class="calc-title">学習開始日からの経過日数を計算</p>
      <p>学習開始日を設定し、<br>そこから何日経過したかを計算します</p>
    </div>
    <div class="input-group">
      <div class="input-group-text">学習開始日</div>
      <input type="text" class="form-control">
    </div>
  </div>
</main>

@endsection