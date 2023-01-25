$(document).ready(function () {
    // In Script
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function filesUploads(form) {
        let submitButton = $(form + ' button[type=submit]');

        $(form).ajaxForm({

            url: $(this).attr("action"),
            type: 'POST',

            beforeSend: function () {
                $(submitButton).attr('disabled', '');
                $(submitButton).append('<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>');

            },

            complete: function (resText) {
                // IF Result Null Not Print This 

                $(".result").html(resText.responseText);
                $(".spinner-border").remove();
                $(submitButton).removeAttr('disabled');

            },
            resetForm: true,
        });// End AjaxForm

    }// End ajaxRequest Function
    filesUploads('#form-add-media-library')

    function post(form, resultBox = '.result') {
        let submitButton = $(form + ' button[type=submit]');
        
        $(form).ajaxForm({

            url: $(this).attr("action"),
            dataType: 'json',
            type: 'POST',

            beforeSend: function () {
               
                $(submitButton).attr('disabled', '');
                $(submitButton).append('<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>');
            },

            success: function (data) {

                $(resultBox).empty();

                if (data.status == true) {


                    toastr.success(data.message, function () {

                        if (data.reload == true) {
                            setTimeout(function () {
                                location.reload();
                            }, 2800);
                        }

                        if (data.redirect == true) {

                            setTimeout(function () {
                                $(form).trigger("reset");
                                window.location.href = data.to;
                            }, 2800);

                        }

                    });

                    if (data.form == 'reset') {
                        $(form).trigger("reset");
                    }



                } else if (data.status == 'notfound') {

                    toastr.warning(data.message, function () {

                        setTimeout(function () {
                            location.reload();
                        }, 2800);

                    });

                } else if (data.status == 'forbidden') {

                    toastr.warning('هذه العملية غير مصرح بها , لا تقم بتكرار ذلك للحفاظ علي عدم فقدان النظام', function () {

                        setTimeout(function () {
                            location.reload();
                        }, 2800);

                    });

                } else if (data.status == 'alert') {

                    toastr.warning(data.message);

                    setTimeout(function () {
                        location.reload();
                    }, 2800);

                } else {

                    toastr.error("يوجد خطأ ما في تحديث ذلك البيانات");
                }


            },

            error: function (dataErrors, exception) {

                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
                
                if (exception == 'error') {

                    let error_list = '';

                    $.each(dataErrors.responseJSON.errors, function (key, value) {
                        error_list += `<div class='box-error'>${value}</div>`;
                    });

                    $(resultBox).html(error_list);
                }
                console.clear();

            },// Error
            complete: function () {
                $(submitButton).removeAttr('disabled');
                $(".spinner-border").remove();
            },


        });// End AjaxForm
    }
    // Delete 
    function deleteRequest(form, message = "سوف يتم الحذف بمجرد الضغط علي موافق") {

        let submitButton = $(form + ' button[type=submit]')
        $(submitButton).click(function (e) {
            e.preventDefault();
            // Remove All Class This IF Isset
            $(submitButton).removeClass("delete-this-item");
            $(form).removeClass("form-this-item");
            // And Add For This Clicked Target
            $(this).addClass("delete-this-item");
            $(this).parents(form).addClass("form-this-item");

            swal({
                title: "هل انت متاكد ؟",
                text: message,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            type: "POST",
                            url: $('.form-this-item').attr("action"),
                            data: $('.form-this-item').serialize(),
                            success: function () {
                                swal("تم الحذف بنجاح", "", "success", {
                                    button: "موافق",
                                });
                                $('.delete-this-item').parents('.category-tr').remove();
                            }
                        });

                    }
                });


        });
    }

    // GLOBAL FORM CLASS
    post(".form", '.result');// Add
    post(".ajax", '.result');// Add


    // Article
    post('#form-add-article', '.result');
    post('#form-edit-article', '.result');

    // Conference Categories
    post('#form-add-catrgory');
    post('#form-add-catrgory');











    // // Admin 
    // post("#form-add-admin", '.result', true);// Add
    // post("#form-edit-admin", '.result');// Edit
    // post("#form-edit-profile", '.result');// Update Profile Admin
    // // Categories
    // post('#form-add-catrgory', '.result', true);
    // post('#form-edit-catrgory', '.result', true);
    // deleteRequest('.form-delete-category', 'هل انت متاكد من الحذف ؟ سوف تفقد المقالات المرتبطة بذلك التصنيف الفئة الخاص بها');

    // // Team
    // post('#form-add-team', '.result');
    // post('#form-edit-team', '.result');
    // // serv
    // post('#form-add-service', '.result');
    // post('#form-edit-service', '.result');
    // // Library category
    // post('#form-add-library-category', '.result');
    // post('#form-edit-library-category', '.result');
    // // Library
    // post('#form-add-library', '.result');
    // post('#form-edit-library', '.result');
    // // Orders
    // post('#form-add-order-pages', '.result-pages');






});