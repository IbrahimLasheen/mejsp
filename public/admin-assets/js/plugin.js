$(document).ready(function () {

    // Toastr
    toastr.options.timeOut = 2000;
    toastr.options.progressBar = true;

    $(function () {
        $('.lazy').lazy();
    });

    // Bootstrap
    $('.toast-title').tooltip()


    // Summernote Editor
    let editor = $(".editor");
    if (editor.length > 0) {
        $('.editor').summernote();

    }





    let libraryImages = $(".images");
    if (libraryImages.length > 0) {

        for (let i = 0; i <= libraryImages.length; i++) {
            new ClipboardJS(libraryImages[i]);
            $(libraryImages[i]).click(function (e) {
                toastr.success('تم نسخ رابط الصورة بنجاح')
            });
        }

    }


});