<template>
  <button class="today-make_tweet main-btn" :class="{ active: activeFormat}" :disabled="!user">
    フォーマット登録/変更
  </button>
</template>

<script>
export default {
  props:['user'],
  methods: {
  }
}
</script>