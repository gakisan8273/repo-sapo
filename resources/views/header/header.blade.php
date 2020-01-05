<div id="app2">
  @if ($user)
    <header-vue icon="{{ $user->twitter_icon }}" />
    {{-- <header-vue icon="{{ $user->twitter_icon }}" logo="{{ $logo }}" /> --}}
  @else
    <header-vue />
  @endif
</div>