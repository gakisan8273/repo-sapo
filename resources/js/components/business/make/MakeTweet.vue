<template>
  <div class="container">

    <table v-show="!user" class="edit_table">
        <a href="/login" style="color:#007bff;">こちら</a>からユーザ登録もしくはログインをして下さい
        <p><br>このアプリでできること</p>
        <ul>
          <li>・自分の #業務日記 を自動取得</li>
          <li>・#業務日記 用の日数を自動計算</li>
          <li>・↑が含まれた #業務日記 ツイートの雛形自動生成</li>
        </ul>
    </table>

    <!-- フォーム送信はLaravelかな？ -->
    <form class="today tweet" action="https://twitter.com/compose/tweet" method="get">
        <label for="" class="today-label label">生成されるツイート</label>

        <textarea name="text" id="" cols="30" rows="10" class="tweet-show today-tweet-show"
        v-model="madeFormat">
        </textarea>

        <p class="tweet-tips">ctrl+cmd+space で絵文字が入力できます</p>
        <div class="form-check">
          <input class="form-check-input js-addurl" @change="addUrl" value="addUrl" type="checkbox" id="check1a" v-model="checkBoxes">
          <label for="check1a" class="form-check-label">作成者を応援する<small>（本文にURLを表記）</small><br>
            <small><a href="https://ofuse.me/users/13507" target="_blank"><br>もっと応援してくれる人はこちら<br>（外部サイトに移動します）</a></small>
          </label>
        </div>
        <div class="form-check today-form-check">
          <input class="form-check-input js-addurl" value="closeTab" type="checkbox" id="check2a" v-model="checkBoxes">
          <label for="check2a" class="form-check-label">ツイート生成後タブを閉じる<small>（未実装）</small></label>
        </div>
        <button class="today-make_tweet main-btn" :disabled="!user">
          <i class="fab fa-twitter"></i>
          ツイート画面へ
        </button>
    </form>

    <div class="past tweet">
        <label for="" class="past-label label">前回のツイート<small class="past-time">{{ latestReportTweet_time }}</small></label>
        <textarea disabled name="" id="" cols="30" rows="10" class="tweet-show past-tweet-show edit_disabled" v-model="latestReportTweet_tweet"></textarea>

    </div>
  </div>
</template>

<script>
import $ from 'jquery';
export default {
  data : function(){
    return {
      madeFormat : "#業務日記\n",
      inputData_day : "",
      checkBoxes : ["addUrl"],
      diffDays : 0,
      youbi : 0,
      keikaMonth : 0,
    };
  },
  props : ['user','calcday','hash_tags', 'start_date','latestReportTweet_tweet', 'latestReportTweet_time', 'found'],
  mounted() {
    console.log("mounted");
    this.recommendDays();
    this.makeFormat();
    this.addUrl();
  },
  computed : {
  },
  methods : {
    addUrl : function(){
      // 末尾にURLが追加される チェックボックスがONになっていれば、Twitter画面に遷移するときに付与する
      // POSTの前にこのメソッドを実行してthis.replacedFormatを書き換える
      // チェックボックスの状態をDataにもたせておく
      // console.log("addUrl");
      let word = 'Posted by:'
      let url = 'https://repo-sapo.gakisan8273.com/business'
      let pattern = word + url;
      if (this.checkBoxes.find(item => item === "addUrl") ){
        this.madeFormat += "\n" + pattern;
        // console.log("added");
      } else {
        this.madeFormat = this.madeFormat.replace(pattern, "");
        // console.log("deleted");
      }
    },
    recommendDays : function(){
      const hour = 17; // この時間を境目に前日扱いにする
      let nowDate = new Date();
      let nowDate_year = nowDate.getFullYear();
      let nowDate_month = nowDate.getMonth();
      let nowDate_date = nowDate.getDate();
      let nowDate_hour = nowDate.getHours();
      let nowDate_time = nowDate.getTime();
      let nowDate_Zero = new Date(nowDate_year, nowDate_month, nowDate_date);
      let start_date_year = this.start_date.slice(0,4); //"yyyy"-mm-dd
      let start_date_month = this.start_date.slice(5,7); //yyyy-"mm"-dd
      let start_date_day = this.start_date.slice(8,10); //yyyy-mm-"dd"
      let start_date_time = new Date(start_date_year, start_date_month - 1, start_date_day);
      let start_date_youbi = start_date_time.getDay(); //曜日
      let nowDate_day = nowDate.getDay(); 
      let diffDays = 0;
      let weekNo = 0;
      console.log(this.calcday);

      if(this.calcday === '1'){
        // x日目 の計算
        // 起算日から本日までの日数 （起算日＝1とする）
        // diffDays = 1 + Math.floor(nowDate_time / (1000*60*60*24))  - Math.floor(start_date_time / ( 1000 * 60 * 60 * 24)); // 小数点以下切り捨て start_date（yyyy-mm-dd） と 今の日付の差
        diffDays = 1 + (nowDate_Zero  - start_date_time) / ( 1000 * 60 * 60 * 24); // 小数点以下切り捨て start_date（yyyy-mm-dd） と 今の日付の差
          // 初日を1日目とするため１を足す
          // https://keisan.casio.jp/exec/system/1177658154 日数計算サイト これと一致した 前のreportsupporterは間違っていた
          console.log(this.calcday);
          if (nowDate_hour < hour) {
            // 今回のツイート時間が１7時以前だったら、昨日のツイートの意味
            // 普通に経過時間を計算すると1日多くなるので、diffDaysを−１する
            console.log("今回ツイートが１7時以前");
            diffDays--;
            console.log({diffDays});
          }
      } else if (this.calcday === "2") {
        // x週-n の計算
        // 起算日の週から本日の週までの週数（起算日の週＝1とする）
        // 本日の曜日 月曜＝1 とする 日曜は0でいい
        // 起算日の曜日を取得する 日曜0~土曜6 start_date_youbi
        // 起算日から曜日の数字を引く （その週の頭となる）
        // ↑の日と、今日の日を引く（週の頭からの経過日数）
        // ↑を7で割り１を足す（経過週数 起算日の週を1とする）
        console.log({nowDate_day});
        console.log({start_date_youbi});
        // let start_date_firstDay = Math.floor(start_date_time / ( 1000 * 60 * 60 * 24)) - start_date_youbi;
        let start_date_firstDay = start_date_day - start_date_youbi;
        // let keika = nowDate_date - start_date_firstDay;
        let start_date_firstWeek = new Date(start_date_year, start_date_month - 1, start_date_firstDay);
        let keika = (nowDate_Zero - start_date_firstWeek) / ( 1000 * 60 * 60 * 24);
        let keikaWeeks = Math.floor(keika / 7) + 1;
        console.log({start_date_firstWeek});
        console.log({start_date_time});
        console.log({keika});
        console.log({keikaWeeks});

        if (nowDate_hour < hour) {
            // 今回のツイート時間が１7時以前だったら、昨日のツイートの意味
            // 普通に経過時間を計算すると1日多くなるので、diffDaysを−１する
            console.log("今回ツイートが１7時以前");
            nowDate_day--;
            if (nowDate_day < 0) {
              nowDate_day = 6;
              keikaWeeks--;
            }
            console.log({diffDays});
        }
        diffDays = keikaWeeks;
        this.youbi = nowDate_day;
      } else {
        // xヶ月目 第ｘ週-n の計算
        // 起算日が含まれる月を1ヶ月目とする
        // 本日が月の何週目に当たるかをx週とする
        // 曜日を-nとする

        // 月の計算
        // 開始年月日から年と月を抜き出す
        // 今日の日付からも年と月を抜き出す
        // 月を整数にし、引き算して＋1する
        // 年を整数にし、引き算する ← ×12したものを足す
        console.log(nowDate.getMonth()); //開始日の月
        console.log(start_date_time.getMonth()); //ツイート日の月(1月＝0)
        let keikaMonth = nowDate.getMonth() - start_date_time.getMonth() + 1;
        keikaMonth += (nowDate.getFullYear() - start_date_time.getFullYear()) * 12;
        console.log({keikaMonth});
        diffDays = keikaMonth;

        // 週の計算
        // console.log($.datepicker.iso8601Week(nowDate));
        // その月の1日目が何曜日かを求める
        // 日曜→1-6日が1週目 月曜→2-7日が1週目
        // 

        let nowDate_firstDate = new Date(nowDate.getFullYear(), nowDate.getMonth(), 1); //今月の初日
        let nowDate_firstDay = nowDate_firstDate.getDay(); //今月初日の曜日 日曜＝0
        // 初日が水曜＝3で 本日26日だったら？ 5週目になるはず
        // 最初の週の終わりは4日 -> 日曜0なら7=0+7, 月曜1なら6=7-1, 火曜2なら5=7-2
        // 1: < 5,  2: < 5 + 7 * 1 = 12,   3: < 5 + 7 * 2 = 19,   4: < 5 + 7 * 3 = 26,   5: < 5 + 7 * 4 = 33
        let nowDate_firstWeekEndDay = 7 - nowDate_firstDay;
        let weekNo;
        if (nowDate.getDate() <= 7 * 1 - nowDate_firstDay) {
          // 1
          weekNo = 1;
        } else if (nowDate.getDate() <= 7 * 2 - nowDate_firstDay) {
          // 2
          weekNo = 2;
        } else if (nowDate.getDate() <= 7 * 3 - nowDate_firstDay) {
          // 3
          weekNo = 3;
        } else if (nowDate.getDate() <= 7 * 4 - nowDate_firstDay) {
          // 4
          weekNo = 4;
        } else if (nowDate.getDate() <= 7 * 5 - nowDate_firstDay) {
          // 5
          weekNo = 5;
        } else if (nowDate.getDate() <= 7 * 2 - nowDate_firstDay) {
          // 6
          weekNo = 6;
        }
        if (nowDate_hour < hour) {
            // 今回のツイート時間が１7時以前だったら、昨日のツイートの意味
            // 普通に経過時間を計算すると1日多くなるので、diffDaysを−１する
            console.log("今回ツイートが１7時以前");
            nowDate_day--;
            if (nowDate_day < 0) {
              nowDate_day = 6;
              weekNo--;
            }
        }
        this.youbi = nowDate_day;
        this.weekNo = weekNo;
      }
      
      console.log("出力される日数は↓");
      console.log({diffDays});
      // return diffDays;
      this.diffDays = diffDays;
    },
    makeFormat : function(){
      // calcday1のとき this.diffdays + "日目"
      if (this.calcday === '1') {
        this.madeFormat += this.diffDays + "日目\n";
      } else if (this.calcday === '2') {
        // calcday2のとき this.diffdays + "週目 - " + 曜日
        this.madeFormat += this.diffDays + "週目-" + this.youbi + "\n";
      } else {
        this.madeFormat += this.diffDays + "ヶ月目　第" + this.weekNo + "週-" + this.youbi + "\n";
      }

      this.madeFormat += "\n\n\n" + this.hash_tags;
      
    },
  },
}
</script>
