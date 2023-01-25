<div id="carousel-sections" class="pt-0">
    <h2 class="section-title mb-3 mt-0">الخدمات</h2>
    <a class=" text-dark" href="https://search-academy.com/order" target="_blank">
        <div class="services-slider-owl-carousel owl-carousel owl-theme">
            @foreach ($details as $serv)
                <div class="item" >
                    <div class="service-items mb-4">

                        {!! $serv->icon !!}

                    </div>
                    <h6 class="text-center">{{ $serv->name }}</h6>
                </div>
            @endforeach
        </div>
    </a>
</div>
