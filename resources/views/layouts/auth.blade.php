@extends('layouts.app')

@section('head')
  @parent
  <link rel="stylesheet" href="/css/bootstrap-social.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
@show

{{-- 左サイドバーは不要のため、空で上書き --}}
@section('leftSideBar')
@endsection

{{-- 右サイドバーは不要のため、空で上書き --}}
@section('rightSideBar')
@endsection
