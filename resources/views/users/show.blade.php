@extends('layouts.default')
@section('title', $user->name)

@section('content')
<div class="row">
  <div class="offset-md-2 col-md-8">
    <div class="col-md-12">
      <div class="offset-md-2 col-md-8">
        <section class="user_info">
          @include('parts._user_info', ['user' => $user])
        </section>


        @if (Auth::check())
          @include('parts._follow_unfollow_button')
        @endif


        <!-- 前面那段是显示用户资料；上面3行小段是如果用户本人登录，则可以显示关注/取消关注按钮；下间这段是显示粉丝数；再下面那段是显示微博列表并分页 -->
        <section class="stats mt-2">
          @include('parts._fans_stats', ['user' => $user])
        </section>

        <section class="microblog">
            @if ($microblogs->count() > 0)
              <ul class="list-unstyled">
                @foreach ($microblogs as $microblog)
                  @include('parts._microblog')
                @endforeach
              </ul>

              <div class="mt-5">
                {!! $microblogs->render() !!}
              </div>

            @else
              <p>没有数据！</p>
            @endif
        </section>

      </div>
    </div>
  </div>
</div>
@stop
