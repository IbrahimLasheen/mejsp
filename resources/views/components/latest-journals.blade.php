<div id="latest-journlas" class="box-white p-3 px-4">
    <div class="row">
        @foreach ($details as $jour)
            <div class="col-lg-4 col-md-6 col-12 my-2" @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) style="direction:ltr;text-align:left !important" @endif>
                <div class="journal-image">
                    @if (checkFile('assets/uploads/journals/' . $jour->cover))
                        <img  src="{{ asset('assets/uploads/journals/' . $jour->cover) }}" alt="{{ $jour->name }}"
                            title="{{ $jour->name }}">
                    @else
                        <img src="{{ asset('assets/images/notfound.png') }}" alt="{{ $jour->name }}"
                            title="{{ $jour->name }}">
                    @endif
                    <a href="{{ url('journal/' . $jour->slug) }}">
                        <h5 class=" font-weight-bold mt-3 mb-4 mb-md-0 text-center">{{ $jour->name, 40 }}</h5>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
