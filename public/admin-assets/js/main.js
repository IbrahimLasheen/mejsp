$(document).ready(function () {

   // Varibles
   const date = new Date();
   let oldYear = date.getFullYear();
   let baseUrl = window.location.origin + '/'; // Base Url
   let apiUrl = baseUrl + 'api/';




   $(".sk-folding-cube").fadeOut(750, function () {
      $(this).parent().fadeOut(750, function () {
         $(this).remove();
      });
   });

   function confirmDelete(form, message = "سوف يتم الحذف بمجرد الضغط علي موافق") {

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
                  $('.form-this-item').submit();
               }
            });


      });
   }




   // For Set / In All Page Links
   let linksItems = $(".links-bar a");
   for (let i = 0; i <= linksItems.length; i++) {
      $(linksItems[i]).append("<span class='links-bar-item-slash'>/</span>");
   }

   // Set For All Lable [*] IF Have Class [required]
   let labelRequired = $(".required");
   for (let i = 0; i <= labelRequired.length; i++) {

      $(labelRequired[i]).append("<b class='text-danger font-weight-bold'> * </b>");

   }

   //Get the button
   let mybutton = document.getElementById("backToTopButton");
   // When the user scrolls down 20px from the top of the document, show the button
   window.onscroll = function () { scrollFunction() };
   function scrollFunction() {
      if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
         mybutton.style.display = "block";
      } else {
         mybutton.style.display = "none";
      }
   }
   // When the user clicks on the button, scroll to the top of the document
   $(mybutton).click(function (e) {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
   });





   /**************************** Categories ********************************* */
   // Edit Category Get Data And Set In Model
   let btnEditCategory = $(".edit-category");
   let categoryId = $(".c_id");
   let categoryName = $(".c_name");
   let categoryPrice = $(".c_price");

   for (let i = 0; i <= btnEditCategory.length; i++) {
      $(btnEditCategory[i]).click(function (e) {

         // Get Values
         let categoriesRow = $(this).attr("data-without_research");
         let cId = $(categoryId[i]).text();
         let cName = $(categoryName[i]).text();
         let cPrice = $(categoryPrice[i]).text();

         //// Set Values
         $("#form-edit-catrgory #id").val(cId);
         $("#form-edit-catrgory #name").val(cName);
         $("#form-edit-catrgory #price").val(cPrice);

         if (categoriesRow == 1) {

            $("#form-edit-catrgory #update_without_research").attr('checked', 'checked');

         } else {
            $("#form-edit-catrgory #update_without_research").removeAttr('checked');

         }

      });

   }

   ////////////////////////////////////// Deletes
   confirmDelete('.delete'); // Global Delete Name Class Form
   confirmDelete('.form-delete-service');





   ////////////////////////////////////////////////////////////////////////// Journals Researches

   /**
    * Get Version From Api After Choose Journal
    */
   let selectVersion = "#select-version";
   $("#select-journal").change(function (e) {
      e.preventDefault();
      $(selectVersion).empty();// Empty Select Box  Before Request
      $.post(apiUrl + 'versions/' + $(this).val(),
         function (data, textStatus) {
            if (textStatus == 'success') {
               $.each(data, function (index, row) {
                  // Append Versions
                  if (row.old_version == null || row.old_version == '') {
                     $(selectVersion).append(`<option value="${row.id}">الاصدار ${row.version} : ${row.day} ${row.month} ${row.year}</option>`);
                  } else {
                     $(selectVersion).append(`<option value="${row.id}">${row.old_version}</option>`);
                  }
               });
            } else {
               toastr.error('يوجد خطأ غير متوقع اثناء اختيارك اصدار المجلة الرجاء حاول مرة اخري');
            }
         },
         "json"
      );
   });







   ////////////////////////////////////////////////////////////////////////// International Publishing
   /**
    * International Publishing
    * Get Types And Specialty From Api After Choose Journal 
   */
   let selectSpecialty = "#select-specialty",
      selectType = "#select-type";
   $(selectType).change(function (e) {
      e.preventDefault();
      $.post(apiUrl + 'specialties/' + $(this).val(),
         function (data, textStatus) {
            $(selectSpecialty).empty();// Empty Select Box Before Append
            if (textStatus == 'success') {
               $.each(data, function (index, row) {
                  // Append 
                  $(selectSpecialty).append(`<option value="${row.id}">${row.specialty}</option>`);
               });
            } else {
               toastr.error('يوجد خطأ غير متوقع اثناء اختيارك نوع النشر الدولي الرجاء حاول مرة اخري');
            }
         },
         "json"
      );
   });









   ////////////////////////////////////////////////////////////////////////// Inovices

   let btnAddItem = "#btn-add-item",
      itemsRow = "#items-row",
      item = '.item',
      btnRemoveItem = ".btn-remove-item";

   $(btnAddItem).click(function (e) {
      e.preventDefault();
      $(itemsRow).append(`<div class="col-12 item"> <div class="row"> <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12"> <div class="form-group"> <input type="text" name="service_name[]" class="form-control" placeholder="اسم الخدمة" required/> </div></div><div class="col-xl-4 col-lg-3 col-md-4 col-sm-4 col-8"> <div class="form-group"> <input type="number" step="any" name="price[]" class="form-control" placeholder="سعر الفاتورة ( بالدولار )" required/> </div></div><div class="col-xl-1 col-lg-2  col-sm-2 col-4  pr-md-0 mb-3"> <button type="button" class="btn-sm btn btn-outline-danger mt-1 btn-block text-center btn-remove-item"><i class="fa-solid fa-trash-can"></i></button> </div></div></div>`);
      removeBox();
   });



   /**
    * Remove Box IF Not Need Yeet
    */

   function removeBox() {
      $(btnRemoveItem).click(function (e) {

         if (window.location.pathname.split("/")[2] == 'invoices' && window.location.pathname.split("/")[3] == 'edit') {
            let data = {
               id: $(this).attr("data-id")
            };
            $.post(baseUrl + $("#prefix").val() + '/invoices/item/destory', data,
               function (data, textStatus, jqXHR) {
               },
               "json"
            );
         }
         e.preventDefault();
         $(this).parents(item).remove();
      });
   }
   removeBox();










});