<template>
  <div class="make_format-format">
    <label for="" class="label">フォーマット</label>
    <div class="make_format-format-insert">
        <small class="make_format-format-insert-btn">
            <p>挿入ボタン</p>
            <p>: Day</p><button class="main-btn small-btn" disabled="disabled">[]</button>
            <p>Time</p><button class="main-btn small-btn" disabled="disabled">{}</button>
            <p>コピペ行</p><button class="main-btn small-btn" disabled="disabled">*---*</button>
        </small>
    </div>
    <textarea name="format" id="format" cols="30" rows="5" class="tweet-show today-tweet-show"
     :value="format"
     @input="$emit('input', $event.target.value)">
     </textarea>
  </div>
</template>

<script>
export default {
  props: ['format'],
  computed:{
    copyFormat: function(){
      console.log(this.format);
      return this.format;
    },
    // []と{}の中身を*+*に置換する
    modifyFormat: function(){
      if(this.format){
        //フォーマットの中の数字を置換して一般化する
        // let replacePattern = '/\{[^}]*\}+/u';
        // \{ : \を付けると特殊文字をエスケープする, [^}] : }以外にマッチする , * : 0回以上の繰り返し , \} : \を付けると特殊文字をエスケープする, 'g' : 
        let replacePattern1 = /\{[^}]*\}/g;
        let replaceObj1 = new RegExp(replacePattern1);
        let replacement1 = '{*+*}';
        let modifiedFormat = this.format.replace(replaceObj1, replacement1);
        // [^~~~~] 内で{ はエスケープいらないが、]は必要だった…
        let replacePattern2 = /\[[^\]]*\]/g;
        let replaceObj2 = new RegExp(replacePattern2);
        let replacement2 = '[*+*]';
        modifiedFormat = modifiedFormat.replace(replaceObj2, replacement2);
        console.log(modifiedFormat);
        return modifiedFormat;
      } else {

      }
    }
  }
}
</script>