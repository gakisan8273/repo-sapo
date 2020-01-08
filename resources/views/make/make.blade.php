@extends('head.head')

@section('content')

<main id="app">
  @if ($user)
    <make-tweet
    user="{{ $user->twitter_id }}"
    format="{{ $user->format }}"
    calcday="{{ $user->calcday }}"
    hash_tags="{{ $user->hash_tags }}"
    start_date="{{ $user->start_date }}"
    latest-report-tweet_tweet = "{{ $latestReportTweet_tweet }}"
    latest-report-tweet_time = "{{ $latestReportTweet_time }}"
    latest-report-tweet_time_for_js = "{{ $latestReportTweet_time_for_js }}"
    found = "{{ $foundFlg }}"
    />
  @else
  <make-tweet
  user=""
  format=""
  calcday=""
  hash_tags=""
  start_date=""
  latest-report-tweet_tweet = ""
  latest-report-tweet_time = ""
  latest-report-tweet_time_for_js = ""
  found = "{{ $foundFlg }}"
  />
  @endif
</main>

@endsection