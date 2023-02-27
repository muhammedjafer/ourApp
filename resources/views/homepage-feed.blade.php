<x-layout>
  <div class="container py-md-5 container--narrow">

    @unless ($posts->isEmpty())
        <h2 class="text-center mb-4">The latest from those you follow</h2>

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

      <div class="mt-4">
        {{ $posts->links() }}
      </div>

    @else
      <div class="text-center">
        <h2>Hello <strong>{{auth()->user()->username}}</strong>, your feed is empty.</  h2>
        <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
      </div>

    @endunless

    </div>
</x-layout>