@extends('layouts.default')
@section('title', '所有用户')

@section('content')
<div class="offset-md-2 col-md-8">
  <h2 class="mb-4 text-center">所有用户</h2>
  <div class="list-group list-group-flush">
    @foreach ($users as $user)


      <div class="list-group-item">
        <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
        <a href="{{ route('users.show', $user) }}">
          {{ $user->name }}
        </a>
      
        <!-- 教材8.5节还把↑↓这块（就是foreach中间的）单独拿了出去，我看了下之前做的，其实没有必要 -->


        @can('destroy', $user)
            <form action="{{ route('users.destroy', $user->id) }}" method="post" class="float-end">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
            </form>
        @endcan
        <!-- 教材8.6节删除用户：先做数据表字段设置admin，再做UserPolicy配置删除策略，然后到这里视图delete按钮做好，最后去users控制器做destroy方法 -->

      </div>


    @endforeach
  </div>


  <div class="mt-3">
    {!! $users->render() !!}
  </div>
</div>
@stop