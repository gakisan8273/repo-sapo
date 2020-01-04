@extends('head.head')

@section('content')

<main id="app">
  @if ($user)
    <make-tweet
    user="{{ $user->twitter_id }}"
    format="{{ $user->format }}"
    calcday="{{ $user->calcday }}"
    start_date="{{ $user->start_date }}"
    latest-report-tweet_tweet = "{{ $latestReportTweet_tweet }}"
    latest-report-tweet_time = "{{ $latestReportTweet_time }}"
    latest-report-tweet_time_for_js = "{{ $latestReportTweet_time_for_js }}"
    />
  @else
  <make-tweet
  user=""
  format=""
  calcday=""
  start_date=""
  latest-report-tweet_tweet = ""
  latest-report-tweet_time = ""
  latest-report-tweet_time_for_js = ""
  />
  @endif
</main>

@endsection