@extends('head.head')

@section('content')

<main class="container">
  <table class="edit_table">
    <tr>
      <td></td>
      <td>本日の値</td>
      <td>前回の値</td>
    </tr>
    <tr>
      <td>Day</td>
      <td><input type="text" value="190"></td>
      <td><input type="text" value="189" class="edit_disabled" disabled></td>
    </tr>
    <tr>
      <td>Time-1</td>
      <td><input type="text" value="2"></td>
      <td><input type="text" value="3.5" class="edit_disabled" disabled></td>
    </tr>
    <tr>
      <td>Time-2</td>
      <td><input type="text" value="400"></td>
      <td><input type="text" value="398" class="edit_disabled" disabled></td>
    </tr>
  </table>

  <div class="today tweet">
      <label for="" class="today-label label">生成されるツイート</label>
      <textarea name="" id="" cols="30" rows="10" class="tweet-show today-tweet-show"></textarea>
      <p class="tweet-tips">ctrl+cmd+space で絵文字が入力できます</p>
      <div class="form-check">
        <input class="form-check-input js-addurl" value="1" type="checkbox" id="check1a">
        <label for="check1a" class="form-check-label">作成者を応援する<small>（本文にURLを表記）</small><br>
          <small><a href="">もっと応援してくれる人はこちら（お布施）</a></small>
        </label>
      </div>
      <div class="form-check today-form-check">
        <input class="form-check-input js-addurl" value="2" type="checkbox" id="check2a">
        <label for="check2a" class="form-check-label">ツイート生成後タブを閉じる</label>
      </div>
      <button class="today-make_tweet main-btn">
        <i class="fab fa-twitter"></i>
        ツイート画面へ
      </button>
  </div>

  <div class="past tweet">
      <label for="" class="past-label label">前回のツイート<small class="past-time">2019-12-23 18:00</small></label>
      <textarea disabled name="" id="" cols="30" rows="10" class="tweet-show past-tweet-show edit_disabled"></textarea>
  </div>

</main>

@endsection