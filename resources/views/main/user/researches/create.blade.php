@extends('main.layouts.master')
@section('title', $pageTitle)
{{-- @section('js')
<script>
      jQuery(document).ready(function(){
                    jQuery('#ajaxSubmit').click(function(e){
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    });
                    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
                });
function submitOrder(event){
    event.preventDefault()

    
    let title = document.querySelector('input[name="title"]').value;
    let keywords = document.querySelector('textarea[name="keywords"]').value;
    let abstract = document.querySelector('textarea[name="abstract"]').value;
    let type = document.querySelector('select[name="type"]').value;
    let journal = document.querySelector('select[name="journal"]').value;

    let file = document.querySelector('input[name="file"]').files[0];

    let formData = new FormData();

    formData.append('title', title)
    formData.append('keywords', keywords)
    formData.append('abstract', abstract)
    formData.append('journal', journal)
    formData.append('type', type)
    if(file){
        formData.append('file',file)
    }
    event.target.disabled = true
    event.target.innerHTML+='<div class="spinner-border spinner-border-sm submit-spinner mr-1" role="status"></div>'

    jQuery.ajax({
        url: "{{ userUrl('researches/store')}}",
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(result){
            console.log('result: ', result);
            toastr.success(result.message)
            end =Date.now();
            inSeconds = end - start;
            console.log('inSeconds: ', inSeconds);

        },
        fail: function(xhr, textStatus, errorThrown){
          alert('request failed');
        }
    });
}
</script>

@endsection --}}
@section('content')
<style>
    .chip {
    display: inline-block;

    border-radius: 19px;
    background-color: #f1f1f1;
    }
    .chip i,.chip .svg-inline--fa{
        cursor: pointer ;
    }
</style>
    <section id="section" class="py-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
                </div>

                <!-- Include Aside -->
                @include('main.user.aside')



                <div class="col-lg-9">

                    


                    <div class="row">

                       


                        @if (getAuth('user', 'email_verified_at') == null)
                            <div class="col-12">
                                <div class="box-white py-5 text-center">
                                    <h5 class=" text-center mb-3">قبل ارسال الطلبات يجب تاكيد بريدك الالكتروني</h5>
                                    <form class="d-inline-block" action="{{ userUrl('email-verification') }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn-main">تأكيد حسابي</button>
                                    </form>
                                </div>
                            </div>
                        @else

                        <div class="col-12 mb-3">
                            <h5 class=" float-right">بحث جديد</h5>
                            <a href="{{ userUrl('researches/all') }}" class="btn-main float-left">ابحاثي</a>
                        </div>


                            <div class="col-lg-12">

                                <div class="box-white p-3">

                                    <div class="result"></div><!-- Result Box-->

                                    @if (session()->has('successMsg'))
                                        <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                                        </div>
                                    @endif

                                    <form class="form" id="form-create-users-researches" action="{{ userUrl('researches/store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="required">عنوان البحث</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div><!-- title -->


                                        <div class="form-group"">
                                            <label class="required" id="keywords-notice">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط على زر Enter )</label>
                                            <textarea name="keywords" class="form-control" cols="30" rows="3"  id="keywords-input"></textarea>
                                            <div class="mt-2" id="keywords-list">
                                                
                                            </div>
                                        </div><!-- keywords -->
                                        <input type="hidden" name="keywords_final" id="keywords_final">


                                        <div class="form-group">
                                            <label class="required">ملخص البحث</label>
                                            <textarea name="abstract" class="form-control" cols="30" rows="10" required></textarea>
                                        </div><!-- abstract -->


                                        <div class="form-group">
                                            <label class="required">نوع البحث</label>
                                            <select name="type" class="form-control" required>
                                                <option selected disabled>اختر</option>
                                                <option value="1">مقيد الوصول</option>
                                                <option value="0">مفتوح المصدر</option>
                                            </select>
                                        </div><!-- type -->


                                        <div class="form-group">
                                            <label class=" required">اختر مجلة للنشر</label>
                                            <select name="journal" class="form-control" required>
                                                <option selected disabled>اختر</option>
                                                @foreach ($journals as $jour)
                                                    <option value="{{ $jour->id }}">{{ $jour->name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- journal -->


                                        <div class="form-group mb-4">
                                            <label class="required">ملف البحث</label>
                                            <input type="file" name="file" accept=".doc,.docx" class="form-control" required>
                                            <small class="d-block text-left text-muted">انواع الملفات (doc/docx) فقط هي التي يتم قبولها</small>
                                        </div><!-- file -->


                                        <div class="form-group mb-2">
                                            {{-- <button  onclick="submitOrder(event)" class="btn-main btn-block">ارسال</button> --}}
                                            <button  type="submit" class="btn-main btn-block" onclick="setKeywordsVal()" onmouseover="validateKeywords(event)">ارسال</button>
                                        </div>

                                    </form>
                                </div>
                            </div><!-- End Content -->

                        @endif
                    </div>



                </div>






            </div>
        </div>
    </section>
@endsection
@section('js')
<script>
 var keywords =[]
 var keywords_final = document.querySelector('#keywords_final') 
 var keywordslist  = document.querySelector('#keywords-list')
    $('#keywords-input').keydown(function(e) {
        $(':input[type="submit"]').prop('disabled', false);
         document.querySelector('#keywords-input').style.border="1px solid #ced4da";
        if (e.keyCode === 13) {
  
          
            let value = event.target.value
            if(value.length){
                keywords.push(value);
            
            keywordslist.innerHTML+=`<div class="chip mx-1 p-1 px-2 mt-1 keyword-element" >
                ${value}
                <span class=" mx-1 ml-2 font-weight-bold" style="    font-size: 15px;
                     cursor: pointer;">X</span>
                </div>`
             keywords_final.value =keywords.join(',')
            }
            $(this).val('').focus()
           

            return false;
        }        
    });
    // document.querySelectorAll('.keyword-element .svg-inline--fa ').forEach(item =>{
    //     console.log('ite',item);
    // })
    document.querySelectorAll('.keyword-element span').forEach(key =>{
  
     key.addEventListener('click', function (event) {
        console.log('yes');
        // keywords = keywords.filter(item => item != content.toString().trim())
        // keywords_final.value =keywords.join(',')
        // event.target.parentNode.parentNode.removeChild(event.target.parentNode)

    }, false);
})
$(document).on('click','.keyword-element span',function(event){
    let content = event.target.parentNode.innerText

    keywords = keywords.filter(item => item != content.replace(' X','').toString().trim())
        keywords_final.value =keywords.join(',')
        event.target.parentNode.parentNode.removeChild(event.target.parentNode)
})
function setKeywordsVal(){
    keywordslist.innerHTML=''
}
function validateKeywords(event){
    if(keywords_final.value ==''){
        event.target.disabled =true
        document.querySelector('#keywords-input').style.border="1px solid red";
        
    }else{
        event.target.disabled = false
         document.querySelector('#keywords-input').style.border="1px solid #ced4da";
    }
}
//if small media or mobile app
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  document.querySelector('#keywords-notice').innerText=">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط مرتين على زر Enter )"
}
</script>

@endsection