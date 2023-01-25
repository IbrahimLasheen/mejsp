<div id="carousel-sections" class="mt-0 py-0 mb-4">
    <h2 class="section-title mb-3 mt-0"><a href="{{ url('journals') }}">مجلات علمية</a></h2>
    <div class="box-white p-2">
        <div class="journals-slider-owl-carousel owl-carousel owl-theme">
            @foreach ($details as $jour)
                <div class="item" @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) style="direction:ltr;text-align:left !important" @endif>
                    <a href="{{ url('journal/' . $jour->slug) }}">
                        @if (checkFile('assets/uploads/journals/' . $jour->cover))
                            <img class=" h-auto " src="{{ asset('assets/uploads/journals/' . $jour->cover) }}"
                                alt="{{ $jour->name }}" title="{{ $jour->name }}">
                        @else
                            <img class="h-auto" src="{{ asset('assets/images/notfound.png') }}" alt="{{ $jour->name }}"
                                title="{{ $jour->name }}">
                        @endif
                        <div class=" mt-2  " @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) style="text-align:left !important" @endif>
                            <h6 class=" text-dark">{{ $jour->name, 40 }}</h6>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>
