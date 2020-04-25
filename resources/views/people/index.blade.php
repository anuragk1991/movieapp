@extends("layouts/main")

@section('content')
	<div class="container mx-auto px-4 pt-16">
        <div class="popular-actors">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular People</h2>
            <div id="people_div" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                @foreach($popularPeople as $person)
                    <div class="actor mt-8">
                        <a href="{{ route('people.show', $person['id']) }}">
                            <img src="{{ $person['full_image'] }}" alt="profile image" class="hover:opacity-75 transition ease-in-out duration-150">
                        </a>
                        <div class="mt-2">
                            <a href="{{ route('people.show', $person['id']) }}" class="text-lg hover:text-gray-300">{{ $person['name'] }}</a>
                            <div class="text-sm truncate text-gray-400">{{ $person['known_for_str'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="page-load-status my-8">
            <div class="flex justify-center">
                <div class="infinite-scroll-request spinner my-8 text-4xl">&nbsp;</div>
            </div>
            <div class="flex justify-center">
                <p class="infinite-scroll-last">End of content</p>
            </div>
            <p class="infinite-scroll-error">Error</p>
        </div>

    </div>


@endsection

@section('scripts')
<script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
      var elem = document.getElementById('people_div');
        console.log("element goes here")
        console.log(elem)
        var infScroll = new InfiniteScroll( elem, {
          path: '/people/page/@{{#}}',
          append: '.actor',
          status: '.page-load-status',
          // history: false,
        });
    });
    
</script>