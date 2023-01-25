<div class="col-lg-4 mb-3">
    <a href="mailto:{{ $email }}" class=" text-dark">
        <div class="box-white py-4 text-center">
            <i class="fa-solid fa-envelope fa-2x"></i>
            <h5 class=" text-center mt-2 mv-0">{{ $email }}</h5>
        </div>
    </a>
</div><!-- Email -->

<div class="col-lg-4 mb-3">
    <a href="https://api.whatsapp.com/send?phone={{ Str::replace(' ', '', $phone) }}"
        class="text-dark">
        <div dir="ltr" class="box-white py-4 text-center">
            <i class="fa-brands fa-whatsapp fa-2x"></i>
            <h5 class=" text-center mt-2 mv-0">{{ $phone }}</h5>
        </div>
    </a>
</div><!-- whatsapp -->

<div class="col-lg-4 mb-3">
    <div class="box-white py-4 text-center">
        <i class="fa-solid fa-location-dot fa-2x"></i>
        <h5 class=" text-center mt-2 mv-0">{{ $address }}</h5>
    </div>
</div><!-- location -->