<x-profile :sharedData="$sharedData">
    <div class="list-group">
        @forelse ($following as $follow)
        <a href="/profile/{{ $follow->userBeingFollowed->username }}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{ $follow->userBeingFollowed->avatar }}" />
            {{ $follow->userBeingFollowed->username }}
        </a>
        @empty
        <p>You are not following anyone!!!</p>
        @endforelse
    </div>
</x-profile>