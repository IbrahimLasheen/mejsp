<div class="box-white mb-3">

    <div class="mb-3">
        <span class="float-right text-secondary">نوع الشهادة</span>
        <span class="float-left">{{ $details['name'] }}</span>
        <div class="clearfix"></div>
    </div><!-- name -->

    <div class="mb-3">
        <span class="float-right text-secondary">سعر المؤتمر</span>
        <span class="float-left">${{ $details['price'] }}</span>
        <div class="clearfix"></div>
    </div><!-- price -->


    <div class="mb-3">
        <span class="float-right text-secondary">عنوان البحث</span>
        <span class="float-left">
            @if ($details['research_title'] == null)
                {{ 'لا يوجد' }}
            @else
                {{ $details['research_title'] }}
            @endif
        </span>
        <div class="clearfix"></div>
    </div><!-- ReSearch Title -->

    <div class="mb-3">
        <span class="float-right text-secondary">حالة الدفع</span>
        @if ($details['payment_response'] > 0)
            <span class="float-left text-success"> مدفوع </span>
        @else
            <span class="float-left">غير مدفوع</span>
        @endif

        <div class="clearfix"></div>
    </div><!-- ReSearch Title -->


    <div class="">
        <span class="float-right text-secondary">تاريخ الحجز</span>
        <span class="float-left">{{ parseTime($details['created_at']) }}</span>
        <div class="clearfix"></div>
    </div><!-- price -->

</div>
