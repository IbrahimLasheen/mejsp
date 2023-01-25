<div class="box-white mb-3">
    <div class="mb-3">
        <span class="float-right text-secondary">حالة الدفع</span>
        <span class="float-left">
            @if ($details['status'] == 'APPROVED')
                <span class="text-success font-weight-bold">ناجحة</span>
            @else
                <span class="text-danger font-weight-bold">ألغيت</span>
            @endif
        </span>
        <div class="clearfix"></div>
    </div><!-- end -->


    <div class="mb-3">
        <span class="float-right text-secondary">قيمة المبلغ</span>
        <span class="float-left">${{ $details['amount'] }}</span>
        <div class="clearfix"></div>
    </div><!-- end -->

    <div class="mb-3">
        <span class="float-right text-secondary">العملة</span>
        <span class="float-left">{{ $details['currency'] }}</span>
        <div class="clearfix"></div>
    </div><!-- end -->

    <div class="mb-3">
        <span class="float-right text-secondary">المصدر</span>
        <span class="float-left">{{ $details['source'] }}</span>
        <div class="clearfix"></div>
    </div><!-- end -->

    <div class="mb-3">
        <span class="float-right text-secondary">رقم المعاملة</span>
        <span class="float-left">{{ $details['payment_id'] }}</span>
        <div class="clearfix"></div>
    </div><!-- end -->

    <div class="">
        <span class="float-right text-secondary">تاريخ الدفع</span>
        <span class="float-left">{{ parseTime($details['created_at']) }}</span>
        <div class="clearfix"></div>
    </div><!-- end -->

</div>
