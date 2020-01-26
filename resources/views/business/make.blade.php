@extends('head.head')

@section('content')

<main id="app">
  @if ($user)
    <make-business-tweet
    user="{{ $user->twitter_id }}"
    calcday="{{ $user->business_calcday }}"
    hash_tags="{{ $user->business_hash_tags }}"
    start_date="{{ $user->business_start_date }}"
    latest-report-tweet_tweet = "{{ $latestReportTweet_tweet }}"
    latest-report-tweet_time = "{{ $latestReportTweet_time }}"
    found = "{{ $foundFlg }}"
    />
  @else
  <make-business-tweet
  user=""
  format=""
  calcday=""
  hash_tags=""
  start_date=""
  latest-report-tweet_tweet = ""
  latest-report-tweet_time = ""
  found = "{{ $foundFlg }}"
  />
  @endif
</main>

@endsection