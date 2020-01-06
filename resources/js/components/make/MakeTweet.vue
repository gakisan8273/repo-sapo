<template>
  <div class="container">

    <!-- <input-numbers :count="countDOM()['count']" :input-data-time="inputData_time"/> -->

      <table class="edit_table">

      <tr>
        <td></td>
        <td>本日の値</td>
        <td>前回の値</td>
      </tr>

      <tr>
        <td>Day</td>
        <!-- <td><input type="text" v-model="inputData_day" @input="replaceFormat_day"></td> -->
        <td><input type="text" v-model="diffDays" @input="replaceFormat_day"></td>
        <td><input type="text" class="edit_disabled" disabled :value="getDaysFromLatestTweet"></td>
      </tr>

      <tr v-for="item in countDOM()['count']" :item='item' :key='item'>
        <td>time-{{ item }}</td>
        <td><input type="text" v-model="inputData_time[item-1]" @input="replaceFormat(item)"></td>
        <td><input type="text" class="edit_disabled" disabled :value="getTimesFromLatestTweet[item-1]"></td>
        <!-- <td><input type="text" class="edit_disabled" disabled></td> -->
      </tr>

    </table>

    <!-- フォーム送信はLaravelかな？ -->
    <form class="today tweet" action="https://twitter.com/compose/tweet" method="get">
        <label for="" class="today-label label">生成されるツイート</label>

        <textarea name="" id="" cols="30" rows="10" class="tweet-show today-tweet-show"
        v-model="replacedFormat">
        </textarea>
        <!-- Twitter用に{}とかを無くす -->
        <textarea style="display:none;" name="text" id="" cols="30" rows="10" class="tweet-show today-tweet-show"
        v-model="sentText">
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
export default {
  data : function(){
    return {
      receivedFormat: this.format,
      replacedFormat: this.format,
      inputData_day : "",
      inputData_time : Array(this.countDOM()['count']), //count個の空配列
      checkBoxes : [],
      diffDays : 0,
    };
  },
  props : ['user', 'format','calcday','hash_tags', 'start_date','latestReportTweet_tweet', 'latestReportTweet_time','latestReportTweet_time_for_js'],
  mounted() {
    this.replaceFormat_copypaste();
    this.recommendDays();
    this.replaceFormat_day();
    console.log("mounted");
  },
  computed : {
    dividedIndex(){
      console.log("dividedIndex");
      // {が何個あるか探す (count - 1 ) +1 = count 個ある
      let count = 0;
      let dividedIndex = []; // { がある位置
      // let format = this.replacedFormat;
      dividedIndex[count] = this.replacedFormat.indexOf('{'); // indexOfは一致しなければ−1を返す
      while ( dividedIndex[count]  > 0 ) {
      count++;
      dividedIndex[count] = this.replacedFormat.indexOf('{', dividedIndex[count-1] + 1);
      }
      // console.log({dividedIndex});
      // console.log({count});
      let result = {
        count:count,
        dividedIndex: dividedIndex,
        };
      return dividedIndex;
    },
    dividedIndex_day : function(){
      console.log("dividedIndex_day");
      // {が何個あるか探す (count - 1 ) +1 = count 個ある
      let count = 0;
      let dividedIndex = []; // { がある位置
      // let format = this.replacedFormat;
      dividedIndex[count] = this.replacedFormat.indexOf('['); // indexOfは一致しなければ−1を返す
      while ( dividedIndex[count]  > 0 ) {
      count++;
      dividedIndex[count] = this.replacedFormat.indexOf('[', dividedIndex[count-1] + 1);
      }
      // console.log({dividedIndex});
      // console.log({count});
      let result = {
        count:count,
        dividedIndex: dividedIndex,
        };
      return dividedIndex;
    },
    getTimesFromLatestTweet : function(){
      console.log('getTimesFromLatestTweet');
      // 過去ツイートから学習時間を取得する

      // フォーマットに{}が含まれている行に対して数字とかの検索〜取得を実行する
        // フォーマットを行ごとに分割する
      let splitFormat = this.format.split(/\r\r|\n/);
        // {}を含むか判定する ついでに[]もやっとくか
      let pattern  = "{"; // 判定パターン
      let findIndex = []; // { があるインデックスにフラグを立てる

      // 行ごとに分割したフォーマットの各行に{があれば配列に１を格納ー＞１は{がある行
      for (let i = 0; i < splitFormat.length; i++) {
        if(splitFormat[i].indexOf(pattern) >= 0){
          findIndex[i] = 1;
        } else {
          findIndex[i] = 0;
        }
      }
      // 過去ツイートを上から数字などで検索して取得する ヒットした順に、インデックスをつける（各インプットボックスと対応させる）
      let splitLatestReportTweet = this.latestReportTweet_tweet.split(/\r\r|\n/);
      let tmp =[];
      let latestReportTweet_times = []; // 過去ツイートの時間を格納する配列
      pattern = /[0-9０-９]+[..．:：0-9０-９hoursmin分時間\s]*[0-9０-９hoursmin分時間]*/g;
      for (let i = 0; i < findIndex.length; i++){
        if (findIndex[i] === 1){
          // 数字などを検索する 正規表現で ヒットしたらそれを取得し、配列に格納
          tmp = splitLatestReportTweet[i].match(pattern);
          console.log({tmp});
          latestReportTweet_times = latestReportTweet_times.concat(tmp);
          console.log(latestReportTweet_times);
        } else {
          // 何もしない
        }
      }
      return latestReportTweet_times;
    },
    getDaysFromLatestTweet : function(){
      console.log('getDaysFromLatestTweet');
      // 過去ツイートから日数を取得する

      // フォーマットに[]が含まれている行に対して数字とかの検索〜取得を実行する
        // フォーマットを行ごとに分割する
      let splitFormat = this.format.split(/\r\r|\n/);
        // []を含むか判定する
      let pattern  = "["; // 判定パターン
      let findIndex = []; // { があるインデックスにフラグを立てる

      // 行ごとに分割したフォーマットの各行に[があれば配列に１を格納ー＞１は{がある行
      for (let i = 0; i < splitFormat.length; i++) {
        if(splitFormat[i].indexOf(pattern) >= 0){
          findIndex[i] = 1;
          break; // 日数は一つのみとするので、１個見つかったらループを抜ける
        } else {
          findIndex[i] = 0;
        }
      }
      // 過去ツイートを上から数字などで検索して取得する
      let splitLatestReportTweet = this.latestReportTweet_tweet.split(/\r\r|\n/);
      let tmp =[];
      let latestReportTweet_days = []; // 過去ツイートの時間を格納する配列
      pattern = /[0-9０-９]+[..．:：0-9０-９hoursmin分時間\-\s]*[0-9０-９hoursmin分時間]*/g;
      for (let i = 0; i < findIndex.length; i++){
        if (findIndex[i] === 1){
          // 数字などを検索する 正規表現で ヒットしたらそれを取得し、配列に格納
          tmp = splitLatestReportTweet[i].match(pattern);
          console.log({tmp});
          latestReportTweet_days = latestReportTweet_days.concat(tmp);
          console.log(latestReportTweet_days);
        } else {
          // 何もしない
        }
      }
      return latestReportTweet_days;
    },

    sentText : function(){
    //[]と{}を削除したものをツイート用に
    let sentText = this.replacedFormat.replace(/[\{\}\[\]]/g,'');
    console.log({sentText});
    return sentText;
    }
  },
  methods : {
    countDOM : function(){
      console.log("countDOM()");
      // {が何個あるか探す (count - 1 ) +1 = count 個ある
      let count = 0;
      let dividedIndex = []; // { がある位置
      // let format = this.replacedFormat;
      dividedIndex[count] = this.format.indexOf('{'); // indexOfは一致しなければ−1を返す
      while ( dividedIndex[count]  > 0 ) {
      count++;
      dividedIndex[count] = this.format.indexOf('{', dividedIndex[count-1] + 1);
      }
      // console.log({dividedIndex});
      // console.log({count});
      let result = {
        count:count,
        dividedIndex: dividedIndex,
        };
      return result; // { の個数を返す この数だけtimeのDOMを生成する
    },
    replaceFormat : function(item){
      // inputboxに入力すると、対応した[]{}が入力された数字に置換される
      // フォーマットを{任意文字列}で検索（{}が何番目かは、入力したinputboxの引数から読み取る）し、それを{入力文字列}に置換する
      // index、入力文字列は子のInputNumbers.vueから受け取る
      console.log('replaceFormat');
      console.log({item});

      // { がある位置
      let dividedIndex = this.dividedIndex[item-1]; //computedから
      let dividedFormat = [];
      console.log({dividedIndex});

      // 検索の開始位置をずらす-> {}の位置の前後で文字列を分割し、後ろの文字列から検索する
      dividedFormat[0] = this.replacedFormat.slice(0, dividedIndex); //最初から { まで
      dividedFormat[1] = this.replacedFormat.slice(dividedIndex); // { から終わりまで
      console.log(dividedFormat[0]);
      console.log(dividedFormat[1]);
      // { の前と、置換した{ 以降のものを結合する
      this.replacedFormat = dividedFormat[0] + dividedFormat[1].replace(/\{[^}]*\}+/u,'{'+ this.inputData_time[item-1] + '}');
    },
    replaceFormat_day : function(){
      console.log('replaceFormat_day'); //日付欄用

      // [ がある位置
      let dividedIndex = this.dividedIndex_day; //computedから
      let dividedFormat = [];
      console.log({dividedIndex});

      // 検索の開始位置をずらす-> {}の位置の前後で文字列を分割し、後ろの文字列から検索する
      dividedFormat[0] = this.replacedFormat.slice(0, dividedIndex); //最初から { まで
      dividedFormat[1] = this.replacedFormat.slice(dividedIndex); // { から終わりまで
      console.log(dividedFormat[0]);
      console.log(dividedFormat[1]);
      // { の前と、置換した{ 以降のものを結合する
      this.replacedFormat = dividedFormat[0] + dividedFormat[1].replace(/\[[^\]]*\]+/u,'['+ this.diffDays + ']');
    },
    replaceFormat_copypaste : function(){
      // フォーマットを\nで検索し、そこで分割する 分割前に*---*があるか？あれば１行目をコピペすればいい
      // 次の\nまでにあるか？ あれば２行目をコピペすればいい
      console.log("replaceFormat_copypasete");

      // 何行目をコピペすればいいか、フォーマットから取得
      let splitFormat = this.format.split(/\r\r|\n/);
      console.log({splitFormat});
      let pattern  = "*---*"; // コピペする行を示すパターン
      let row = "";

      let findIndex = "" // 何行目に*---*があるか ０→１行目
      
      for (let i = 0; i < splitFormat.length; i++) {
        if(splitFormat[i].indexOf(pattern) >= 0){
          findIndex = i;
          break;
        }
      }
      console.log({findIndex});

      // 前回ツイートからコピーする作業
      // 前回ツイートを分割する
      let splitLatestReportTweet = this.latestReportTweet_tweet.split(/\r\r|\n/);
      // findIndex行目を取得する
      let copiedText = splitLatestReportTweet[findIndex];

      // 生成するツイートのfindIndex行目をcopiedTextに置き換える
      splitFormat[findIndex] = copiedText;

      // 生成するツイートを再結合する
      let format = "";
      for (let i = 0; i < splitFormat.length; i++){
        format += splitFormat[i];
        format += "\n";
      }
      console.log(this.replacedFormat);
      // 最後にハッシュタグを足しとく
        this.replacedFormat = format + "\n" + this.hash_tags;
    },
    addUrl : function(){
      // 末尾にURLが追加される チェックボックスがONになっていれば、Twitter画面に遷移するときに付与する
      // POSTの前にこのメソッドを実行してthis.replacedFormatを書き換える
      // チェックボックスの状態をDataにもたせておく
      console.log("addUrl");
      let word = 'Posted by:'
      let url = 'https://gakisan8273.com/reportsupporter/'
      let pattern = word + url;
      if (this.checkBoxes.find(item => item === "addUrl") ){
        this.replacedFormat += "\n" + pattern;
        console.log("added");
      } else {
        this.replacedFormat = this.replacedFormat.replace(pattern, "");
        console.log("deleted");
      }
    },
    recommendDays: function(){
      console.log('diffDays');

      // 前回ツイートの日付と日数計算オプション設定値から、日付の提案の値を産出する

      // 1 前回ツイート日からの経過日数計算
      // 前回の報告ツイート内にある日数を取得し、
      // そこから何日経過したかを計算します

      //2 学習した日付のみの日数をカウント
      // 前回の報告ツイート内にある日数を取得し、
      // それに＋１します

      // Option 3
      // 学習開始日からの経過日数を計算
      // 学習開始日を設定し、
      // そこから何日経過したかを計算します

      // １８時〜２４時のツイートは、当日扱いとする
      // ０時〜１８時のツイートは、前日扱いとする （日を跨いで前日の報告ツイートをすることを想定）
      const hour = 18; // この時間を境目に前日扱いにする
      let latestDate = new Date(this.latestReportTweet_time_for_js); // 前回ツイートの日付 Dateオブジェクト
      let latestDate_hour = latestDate.getHours(); // 時間を取得
      let latestDate_time = latestDate.getTime(); // ミリ秒単位の経過時間
      let nowDate = new Date();
      let nowDate_hour = nowDate.getHours();
      let nowDate_time = nowDate.getTime();
      let diffDays = 0;

      switch (this.calcday) {
        case "1":
          diffDays = Number(this.getDaysFromLatestTweet) + parseInt( ( nowDate_time - latestDate_time ) / ( 1000 * 60 * 60 * 24), 10 ); // 小数点以下切り捨て 
          console.log(this.calcday);
          console.log(typeof(Number(this.getDaysFromLatestTweet)));
          console.log({nowDate_time});
          console.log({latestDate_time});
          console.log( (nowDate_time - latestDate_time) / (1000*60*60*24) );
          console.log({diffDays}); // 1になってる ここから修正
          // calcday１〜2共通の処理
          if (latestDate_hour < hour) {
            // 前回ツイート時間が18時以前だったら、前回ツイート日より1日前のツイートの意味
            // 普通に経過日時を計算すると1日足りなくなるので、diffDaysを＋１する
            console.log("前回ツイートが１８時以前");
            diffDays++;
            console.log({diffDays});
          }
          break;
        case "2":
          diffDays = Number(this.getDaysFromLatestTweet) + 1; // 前回ツイートの日数＋１
          console.log(this.calcday);
          console.log({diffDays});
          // calcday１〜2共通の処理
          if (latestDate_hour < hour) {
            // 前回ツイート時間が18時以前だったら、前回ツイート日より1日前のツイートの意味
            // 普通に経過日時を計算すると1日足りなくなるので、diffDaysを＋１する
            console.log("前回ツイートが１８時以前");
            diffDays++;
            console.log({diffDays});
          }
          break;
        case "3":
          // calcday3のときのみ
          let start_date_year = this.start_date.slice(0,4); //"yyyy"-mm-dd
          let start_date_month = this.start_date.slice(5,7); //yyyy-"mm"-dd
          let start_date_day = this.start_date.slice(8,10); //yyyy-mm-"dd"
          latestDate_time = new Date(start_date_year, start_date_month - 1, start_date_day);
          console.log(this.calcday);
          console.log({latestDate_time});
          console.log({nowDate_time});
          diffDays = 1 + parseInt( ( nowDate_time - latestDate_time ) / ( 1000 * 60 * 60 * 24), 10 ); // 小数点以下切り捨て start_date（yyyy-mm-dd） と 今の日付の差
          // 初日を1日目とするため１を足す
          // https://keisan.casio.jp/exec/system/1177658154 日数計算サイト これと一致した 前のreportsupporterは間違っていた・・・
          break;
        default:
          console.log("no switch");
          break;
      }
      //calcday1~3共通の処理
      if (nowDate_hour < hour) {
        // 今回のツイート時間が１８時以前だったら、昨日のツイートの意味
        // 普通に経過時間を計算すると1日多くなるので、diffDaysを−１する
        console.log("今回ツイートが１８時以前");
        diffDays--;
        console.log({diffDays});
      }
      console.log("出力される日数は↓");
      console.log({diffDays});
      // return diffDays;
      this.diffDays = diffDays;
    },
  },
}
</script>