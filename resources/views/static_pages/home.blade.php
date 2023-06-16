@extends('layouts.default')

@section('content')


@if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="microblog_textarea">
          @include('parts._microblog_textarea')
        </section>

        <h4>微博列表</h4>
        <hr>
        @include('parts._microblog_feed')
      </div>

      <aside class="col-md-4">
        <section class="user_info">
          @include('parts._user_info', ['user' => Auth::user()])
        </section>
      </aside>
    </div>

@else

  <div class="bg-light p-3 p-sm-5 rounded">
    <h1>Hello Laravel</h1>
    <p class="lead">
      你现在所看到的是 <a href="https://learnku.com/courses/laravel-essential-training">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p>
  </div>

@endif

@stop