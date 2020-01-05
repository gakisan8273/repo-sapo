@extends('head.head')

@section('content')

 <main class="container container-column" >
   <form class="container container-column" method="post" action="/post-calcday">
    @csrf
    <div class="calcday">
      {{-- DBのcalcdayとラジオボタンのデフォルトを連動させる --}}
      <div class="form-check">
        @if (!empty($user) && $user->calcday === 1)
          <input type="radio" class="form-check-input" name="calc_option" id="radio1a" value="1" checked>
        @else
          <input type="radio" class="form-check-input" name="calc_option" id="radio1a" value="1">
        @endif
        {{-- <label for="radio1a" class="form-check-label">Option 1 (default)</label> --}}
        <label for="radio1a" class="calc-title">前回ツイート日からの経過日数計算</label>
        <p>前回の報告ツイート内にある日数を取得し、<br>そこから何日経過したかを計算します</p>
      </div>
      <div class="form-check">
        @if (!empty($user) && $user->calcday === 2)
          <input type="radio" class="form-check-input" name="calc_option" id="radio1b" value="2" checked>
        @else
          <input type="radio" class="form-check-input" name="calc_option" id="radio1b" value="2">
        @endif
        {{-- <label for="radio1b" class="form-check-label">Option 2</label> --}}
        <label for="radio1b" class="calc-title">学習した日付のみの日数をカウント</label>
        <p>前回の報告ツイート内にある日数を取得し、<br>それに＋１します</p>
      </div>
      <div class="form-check">
        @if (!empty($user) && $user->calcday === 3)
          <input type="radio" class="form-check-input" name="calc_option" id="radio1c" value="3" checked>
        @else
          <input type="radio" class="form-check-input" name="calc_option" id="radio1c" value="3">
        @endif
        {{-- <label for="radio1c" class="form-check-label">Option 3</label> --}}
        <label for="radio1c" class="calc-title">学習開始日からの経過日数を計算</label>
        <p>学習開始日を設定し、<br>そこから何日経過したかを計算します</p>
        <p>(yyyy-mm-dd形式で入力してください)</p>
        <div class="input-group">
          <div class="input-group-text">学習開始日 
          </div>
          {{-- 現在日付までで入力制限する --}}
        @if ($user)
          {{-- <input type="text" class="form-control" name="start_date" placeholder="yyyy-mm-dd"> --}}
          <input type="text" class="form-control" name="start_date" placeholder="yyyy-mm-dd"
          @if(count($errors)>0)
            value="{{ old('start_date') }}"
          @endif
            value="{{ $user->start_date }}">
        @else
          <input type="text" class="form-control" name="start_date" placeholder="yyyy-mm-dd" value="">
        @endif
        </div>

        @if (count($errors) > 0 )
          <div class="error">
            @foreach ($errors->all() as $error)
              {{ $error }}              
            @endforeach
          </div>
        @endif

        @if ($user)
        <button class="main-btn">
          日数計算方法変更
        </button>
        @else
        <button class="main-btn" disabled>
          日数計算方法変更
        </button>
        @endif
      </div>
    </div>
  </form>

</main>

@endsection