<li class="d-flex mt-4 mb-4">
  <a class="flex-shrink-0" href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="me-1 gravatar"/>
  </a>
  <div class="flex-grow-1 ms-3">
    <h5 class="mt-0 mb-1">{{ $user->name }} <small> 发表于 {{ $microblog->created_at->diffForHumans() }}</small></h5>
    {{ $microblog->content }}
  </div>


  @can('destroy', $microblog)
    <form action="{{ route('microblogs.destroy', $microblog->id) }}" method="POST" onsubmit="return confirm('您确定要删除本条微博吗？');">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger microblog-delete-btn">删除</button>
    </form>
  @endcan
</li>