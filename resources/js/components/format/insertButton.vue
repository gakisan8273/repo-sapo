<template>
  <small class="make_format-format-insert-btn">
    <p>挿入ボタン</p>
    <p>: Day</p><button class="small-btn" @click="handleClick1">[]</button>
    <p>Time</p><button class="small-btn" @click="handleClick2">{}</button>
    <p>コピペ行</p><button class="small-btn" @click="handleClick3">*---*</button>
  </small>
</template>

<script>
export default {
  methods : {
    handleClick1 : function(){
      // disabledがボタンについているとイベントが発火しない
      event.preventDefault()
      console.log('handleClick1');
      this.$emit('child-event1');
    },
    handleClick2 : function(){
      event.preventDefault()
      this.$emit('child-event2');
    },
    handleClick3 : function(){
      event.preventDefault()
      this.$emit('child-event3');
    },
  }
}
</script>