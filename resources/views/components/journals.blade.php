<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-4">مجلات علمية</h4>
    </div>
    @foreach ($journals as $jour)
        <div class="col-12 mb-2" @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) style="direction:ltr;text-align:left !important" @endif>
            <a class=" list-hover" href="{{ url("journal/".$jour->slug) }}" >
                <div class=" rounded bg-white px-3 py-3  @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) text-center @endif" >
                    <span class="text-secondary " >{{ $jour->name }}</span>
                </div>
            </a>
        </div>
    @endforeach
</div><!-- End Row -->