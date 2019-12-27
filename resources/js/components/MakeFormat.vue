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
    <textarea name="format" id="format" cols="30" rows="5" class="tweet-show today-tweet-show" v-model="format"></textarea>
  </div>
</template>

<script>
export default {
  props: ['format'],
  methods:{
    // []と{}の中身を*+*に置換する
    replace
  }
}
</script>