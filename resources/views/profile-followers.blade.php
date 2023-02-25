<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @forelse ($followers as $follower)
        <a href="/profile/{{ $follower->userDoingTheFollowing->username }}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{ $follower->userDoingTheFollowing->avatar }}" />
            {{ $follower->userDoingTheFollowing->username }}
        </a>
        @empty
        <p>You Don't have any followers!!!</p>
        @endforelse
    </div>
</x-profile>