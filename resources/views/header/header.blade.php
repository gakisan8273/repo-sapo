<div id="app2">
  @if ($user)
    <header-vue icon="{{ $user->twitter_icon }}"/>
  @else
    <header-vue />
  @endif
</div>