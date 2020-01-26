<template>
  <div>
    <div class="make_format-hash">
      <label for="" class="label">ハッシュタグ　(#業務日記 以外のタグを入力して下さい)</label>
      <!-- <textarea name="gyoumunikki" id="" cols="30" rows="1" class="tweet-show today-tweet-show edit_disabled" disabled
      >
        #業務日記 -->
      </textarea>
      <textarea name="business_hash_tags" id="" cols="30" rows="3" class="tweet-show today-tweet-show"
      :value="hash_tags"
      @input="$emit('input', $event.target.value)">
      </textarea>
    </div>
    <div class="input-group">
      <div class="input-group-text">業務開始日</div>
          <input type="text" class="form-control" name="business_start_date" placeholder="yyyy-mm-dd"
          :value="start_date"
          >
    </div>
    <div v-if="error" class="error">{{ error }}</div>
      <div class="form-check" style="margin-top:15px;">
        <input  v-if="calcday === '1'" type="radio" class="form-check-input" name="business_calc_option" id="radio1a" value="1" checked>
        <input  v-else type="radio" class="form-check-input" name="business_calc_option" id="radio1a" value="1">
        <label for="radio1a" class="calc-title">起算日からの経過日数を自動計算します<br>（x日目）</label>
      </div>
      <div class="form-check">
        <input type="radio" v-if="calcday === '2'" class="form-check-input" name="business_calc_option" id="radio1b" value="2" checked>
        <input type="radio" v-else class="form-check-input" name="business_calc_option" id="radio1b" value="2">
        <label for="radio1b" class="calc-title">起算日からの経過週と本日の曜日を数字で出力します<br>（x週目-n）</label>
      </div>
      <div class="form-check">
        <input type="radio" v-if="calcday === '3'" class="form-check-input" name="business_calc_option" id="radio1c" value="3" checked>
        <input type="radio" v-else class="form-check-input" name="business_calc_option" id="radio1c" value="3">
        <label for="radio1c" class="calc-title">起算日からの経過月と本日の週数・曜日を数字で出力します<br>（xヶ月目 第y週-n）</label>
      </div>
    <send-business-format :user="user"/>
  </div>
</template>

<script>
import sendFormat from './sendFormat.vue';

export default {
  data: function(){
    return {
      // receivedFormat: this.format,
      // modifiedFormat : this.format,
    }
  },
  props: ['format', 'hash_tags','start_date', 'calcday', 'user', 'error'],
  mounted(){

  },
  methods:{
  }
}
</script>