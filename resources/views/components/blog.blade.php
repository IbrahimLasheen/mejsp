<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-4">احدث المقالات</h4>
    </div>
    @foreach ($articles as $art)
        <div class="col-12 mb-2" @if(strlen($art->title) == strlen(utf8_decode($art->title))) style="direction:ltr;text-align:left !important" @endif>
            <a class="list-hover" href="@if ($art->version == 'old') {{ url('blog-single.php?lang=ar&id='.$art->id.'&name='.$art->title) }}@else{{ url("article/$art->slug") }} @endif">
                <div class=" rounded bg-white px-3 py-3">
                    <span class="text-center text-secondary" @if(strlen($art->title) == strlen(utf8_decode($art->title))) style="text-align:left !important" @endif>{{ $art->title }}</span>
                </div>
            </a>
        </div>
    @endforeach
</div><!-- End Row -->
