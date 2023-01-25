@if ($list == true)
    <div class="row mb-4" >
        <div class="col-12">
            <h4 class="mb-4">الخدمات</h4>
        </div>
        @foreach ($details as $serv)
            <div class="col-12 mb-2" >
                <a class=" text-dark list-hover" href="https://search-academy.com/order" target="_blank">
                    <div class=" rounded bg-white px-3 py-3">
                        <span class="ml-1">{!! $serv->icon !!}</span>
                        <span class="text-center text-secondary"  @if(strlen($serv->name) == strlen(utf8_decode($serv->name))) style="text-align:left !important" @endif>{{ $serv->name }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div><!-- End Row -->
@else
    <div class="row">
        @foreach ($details as $serv)
            <div class=" {{ $col }} mb-3"  >
                <a class=" text-dark" href="https://search-academy.com/order" target="_blank">
                    <div class="service-items mb-4">
                        {!! $serv->icon !!}
                    </div>
                    <h6 class="text-center">{{ $serv->name }}</h6>
                </a>
            </div>
        @endforeach
    </div><!-- End Row -->
@endif
