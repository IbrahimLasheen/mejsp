$(document).ready(function () {

    jQuery.extend(jQuery.validator.messages, {
        required: "هذا الحقل مطلوب",
        remote: "الرجاء تصحيح هذا المجال",
        email: "رجاء قم بإدخال بريد الكتروني صحيح.",
        url: "أدخل رابط صحيح من فضلك.",
        date: "ارجوك ادخل تاريخ صحيح.",
        dateISO: "الرجاء إدخال تاريخ صالح",
        number: "من فضلك أدخل رقما صالحا.",
        digits: "الرجاء إدخال أرقام فقط.",
        creditcard: "الرجاء إدخال رقم بطاقة ائتمان صالحة.",
        equalTo: "من فظلك ادخل نفس القيمة مرة أخرى.",
        accept: "الرجاء إدخال قيمة بامتداد صالح.",
        maxlength: jQuery.validator.format("الرجاء ادخل ما لا يزيد عن {0} احرف"),
        minlength: jQuery.validator.format("الرجاء ادخل ما لا يقل عن {0} احرف"),
        rangelength: jQuery.validator.format("الرجاء إدخال قيمة يتراوح طولها بين {0} و {1} حرفًا."),
        range: jQuery.validator.format("الرجاء إدخال قيمة بين {0} و {1}."),
        max: jQuery.validator.format("الرجاء إدخال قيمة أقل من أو تساوي {0}."),
        min: jQuery.validator.format("الرجاء إدخال قيمة أكبر من أو تساوي {0}.")
    });
    
});