<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @forelse ($posts as $post)
        <a href="/post/{{ $post->id }}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{ $post->user->avatar }}" />
            <strong>{{ $post->title }}</strong> {{ $post->created_at->format('Y-m-d') }}
        </a>
        @empty
        <p>You Don't have any posts yet!!!</p>
        @endforelse
    </div>
</x-profile>