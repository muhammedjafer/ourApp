<a href="/post/{{ $post->id }}" class="list-group-item list-group-item-action">
    <img class="avatar-tiny" src="{{ $post->user->avatar }}" />
    <strong>{{ $post->title }}</strong>
    <span class="text-muted small">
        @if (!isset($hideAuther))
        by {{ $post->user->username }}
        @else
        on {{ $post->created_at->format('Y-m-d') }}
        @endif
    </span> 
</a>