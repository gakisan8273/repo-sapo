<template>
  <div class="header">

  <div class="header-img_container">
    <div class="header-logo">
      <a href="/make"><img src="/assets/images/repo-sapo_logo.png" alt="れぽさぽ"></a>
      <!-- <a href="/make"><img :src="this.logo" alt="れぽさぽ"></a> -->
    </div>
    <div class="header-icon">
        <img :src="this.icon" alt="れぽさぽ" class="header-icon-img" v-if="this.icon">
        <img src="/assets/images/default_icon.png" alt="れぽさぽ" class="header-icon-img" v-else>
    </div>
  </div>

  <nav class="header-nav">
    <ul class="header-nav-menu">
      <li class="header-nav-menu-item">
        <a href="/make" class="header-nav-menu-item-link" :class="{ active: activeMake}">報告ツイート生成</a>
      </li>
      <li class="header-nav-menu-item">
        <a href="/format" class="header-nav-menu-item-link" :class="{ active: activeFormat}">フォーマット登録/変更</a>
      </li>
      <li class="header-nav-menu-item">
        <a href="/calcday" class="header-nav-menu-item-link" :class="{ active: activeCalcday}">日数計算方法変更</a>
      </li>
      <li class="header-nav-menu-item">
        <a href="/readme" class="header-nav-menu-item-link" :class="{ active: activeReadme}">Readme</a>
      </li>
      <li class="header-nav-menu-item">
        <a href="/login" class="header-nav-menu-item-link" :class="{ active: activeLogin}">新規登録/ログイン/ログアウト</a>
      </li>
    </ul>
  </nav>

  <nav class="header-menu-trigger" :class="{ active: menu }" @click="activateMenu">
    <span></span>
    <span></span>
    <span></span>
  </nav>
  <nav class="header-nav-sm" :class="{ active: menu }">
    <ul class="header-nav-sm-menu">
      <li class="header-nav-sm-menu-item">
        <a href="/make" class="header-nav-sm-menu-item-link" :class="{ active: activeMake}" >報告ツイート生成</a>
      </li>
      <li class="header-nav-sm-menu-item">
        <a href="/format" class="header-nav-sm-menu-item-link" :class="{ active: activeFormat}">フォーマット登録/変更</a>
      </li>
      <li class="header-nav-sm-menu-item">
        <a href="/calcday" class="header-nav-sm-menu-item-link" :class="{ active: activeCalcday}">日数計算方法変更</a>
      </li>
      <li class="header-nav-sm-menu-item">
        <a href="/readme" class="header-nav-sm-menu-item-link" :class="{ active: activeReadme}">Readme</a>
      </li>
      <li class="header-nav-sm-menu-item">
        <a href="/login" class="header-nav-sm-menu-item-link" :class="{ active: activeLogin}">新規登録/ログイン/ログアウト</a>
      </li>
    </ul>
  </nav>
</div>
</template>

<script>
export default {
  data : function(){
    return {
      menu : false,
      activeMake : false,
      activeFormat : false,
      activeCalcday : false,
      activeReadme : false,
      activeLogin : false,
    }
  },
  props : ['icon','logo'],
  mounted(){
    this.getPath();
  },
  methods : {
    activateMenu : function(){
      // スマホのハンバーガーメニューをクリックすると、activeクラスを付与する
      // activeになってるときはactiveを外す
      console.log("activateMenu");
      this.menu = !this.menu;
      console.log(this.menu);
    },
    getPath : function(){
      let path = location.pathname;
      console.log('getPath');
      console.log({path});
      switch (path) {
        case "/make":
          this.activeMake = true;
          break;
        case "/format":
          this.activeFormat = true;
          break;
        case "/calcday":
          this.activeCalcday = true;
          break;
        case "/readme":
          this.activeReadme = true;
          break;
        case "/login":
          this.activeLogin = true;
          break;
        case "/":
          this.activeMake = true;
          break;
        default:
          break;
      }
    },
  }
}
</script>