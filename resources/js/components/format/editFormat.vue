<template>
  <div>
    <div class="make_format-hash">
      <label for="" class="label">ハッシュタグ</label>
      <textarea name="hash_tags" id="" cols="30" rows="3" class="tweet-show today-tweet-show"
      :value="hash_tags"
      @input="$emit('input', $event.target.value)">
      </textarea>
    </div>
    <div class="make_format-format">
      <label for="" class="label">フォーマット</label>
      <div class="make_format-format-insert">
        <insert-button
        @child-event1="insertPattern_day"
        @child-event2="insertPattern_time"
        @child-event3="insertPattern_copypaste"
        />
      </div>
      <textarea ref="insert" name="format_original" id="format_original" cols="30" rows="5" class="tweet-show today-tweet-show"
      v-model="receivedFormat"
      @keyup="modifyFormat"
      >
      <!-- @input="$emit('input', $event.target.value)" -->
      </textarea>
      <textarea style="display: none;" name="format" id="format" cols="30" rows="5" class="tweet-show today-tweet-show"
      :value="modifiedFormat">
      </textarea>
    </div>
    <send-format :user="user"/>
    <!-- <send-format @childs-event="modifyFormat" /> -->
  </div>
</template>

<script>
import insertButton from './insertButton.vue';
import sendFormat from './sendFormat.vue';

export default {
  data: function(){
    return {
      receivedFormat: this.format,
      modifiedFormat : this.format,
    }
  },
  props: ['format', 'hash_tags','user'],
  mounted(){

  },
  methods:{
    // []と{}の中身を*+*に置換する
    modifyFormat: function(){
      // event.preventDefault()
      //フォーマットの中の数字を置換して一般化する
      // let replacePattern = '/\{[^}]*\}+/u';
      // \{ : \を付けると特殊文字をエスケープする, [^}] : }以外にマッチする , * : 0回以上の繰り返し , \} : \を付けると特殊文字をエスケープする, 'g' : 
      let replacePattern1 = /\{[^}]*\}/g;
      let replaceObj1 = new RegExp(replacePattern1);
      let replacement1 = '{*+*}';
      this.modifiedFormat = this.receivedFormat.replace(replaceObj1, replacement1);
      // [^~~~~] 内で{ はエスケープいらないが、]は必要だった…
      let replacePattern2 = /\[[^\]]*\]/g;
      let replaceObj2 = new RegExp(replacePattern2);
      let replacement2 = '[*+*]';
      this.modifiedFormat = this.modifiedFormat.replace(replaceObj2, replacement2);
      console.log(this.modifiedFormat);
    },
    insertPattern_day : function(){
      console.log("insertPattern_day");
      // フォーマット入力欄に[]を挿入する

      // dataにあるrecievedFormatを操作する
      // 選択カーソルの最初と最後を取得する
      // カーソル最初まででsliceする
      // カーソル最後からsliceする
      // 真ん中のものの前後に[]を付与する
      // 文字列を結合する 改行はどうなる？
      // console.log(this.$refs.insert.focus());
      // let textarea = document.getElementsByClassName('js-format')[0];
      let pos_start = this.$refs.insert.selectionStart;
      let pos_end = this.$refs.insert.selectionEnd;
      let val = this.receivedFormat;
      let range = val.slice(pos_start, pos_end);
      let beforeNode = val.slice(0, pos_start);
      let afterNode = val.slice(pos_end);
      let insertNode = "[" + range + "]";
      this.receivedFormat = beforeNode + insertNode + afterNode;
      this.modifyFormat();
      // console.log({beforeNode});
      // console.log({insertNode});
      // console.log({afterNode});
      // console.log(this.receivedFormat);
    },
    insertPattern_time : function(){
      console.log("insertPattern_time");
      // フォーマット入力欄に[]を挿入する

      // dataにあるrecievedFormatを操作する
      // 選択カーソルの最初と最後を取得する
      // カーソル最初まででsliceする
      // カーソル最後からsliceする
      // 真ん中のものの前後に[]を付与する
      // 文字列を結合する 改行はどうなる？
      // console.log(this.$refs.insert.focus());
      // let textarea = document.getElementsByClassName('js-format')[0];
      let pos_start = this.$refs.insert.selectionStart;
      let pos_end = this.$refs.insert.selectionEnd;
      let val = this.receivedFormat;
      let range = val.slice(pos_start, pos_end);
      let beforeNode = val.slice(0, pos_start);
      let afterNode = val.slice(pos_end);
      let insertNode = "{" + range + "}";
      this.receivedFormat = beforeNode + insertNode + afterNode;
      this.modifyFormat();
      // console.log({beforeNode});
      // console.log({insertNode});
      // console.log({afterNode});
      // console.log(this.receivedFormat);
    },
    insertPattern_copypaste : function(){
      console.log("insertPattern_copypaste");
      // フォーマット入力欄に[]を挿入する

      // dataにあるrecievedFormatを操作する
      // 選択カーソルの最初と最後を取得する
      // カーソル最初まででsliceする
      // カーソル最後からsliceする
      // 真ん中のものの前後に[]を付与する
      // 文字列を結合する 改行はどうなる？
      // console.log(this.$refs.insert.focus());
      // let textarea = document.getElementsByClassName('js-format')[0];
      let pos_start = this.$refs.insert.selectionStart;
      let pos_end = this.$refs.insert.selectionEnd;
      let val = this.receivedFormat;
      let range = val.slice(pos_start, pos_end);
      let beforeNode = val.slice(0, pos_start);
      let afterNode = val.slice(pos_end);
      let insertNode = "*---*";
      this.receivedFormat = beforeNode + insertNode + afterNode;
      this.modifyFormat();
      // console.log({beforeNode});
      // console.log({insertNode});
      // console.log({afterNode});
      // console.log(this.receivedFormat);
    },
  }
}
</script>