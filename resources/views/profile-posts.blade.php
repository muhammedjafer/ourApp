<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username'] }}'s Profile">
    <div class="list-group">
        @forelse ($posts as $post)
        <x-post :post="$post" hideAuther="true"/>
        @empty
        <p>You Don't have any posts yet!!!</p>
        @endforelse
    </div>
</x-profile>