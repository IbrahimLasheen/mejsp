@extends('main.layouts.master')
@section('title', $pageTitle)
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
                            <h5 class=" float-right">تعديل بحثي</h5>
                            <a href="{{ userUrl('researches/all') }}" class="btn-main float-left">ابحاثي</a>
                        </div>


                            <div class="col-lg-12">

                                <div class="box-white p-3">

                                    <div class="result"></div><!-- Result Box-->

                                    @if (session()->has('successMsg'))
                                        <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                                        </div>
                                    @endif

                                    <form class="form" id="form-edit-users-researches" action="{{ userUrl('researches/update') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="required">عنوان البحث</label>
                                            <input type="text" name="title" class="form-control" value="{{ $row->title }}" required>
                                        </div><!-- title -->

                                        <div class="form-group"">
                                            <label class="">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط على زر Enter )</label>
                                            <textarea name="keywords" class="form-control" cols="30" rows="3"  id="keywords-input" ></textarea>
                                            <div class="mt-2" id="keywords-list">
                                                
                                                @if($row->keywords)
                                                  @foreach (explode(',',$row->keywords) as $k)
                                                    <div class="chip mx-1 p-1 px-2 mt-1 keyword-element" >
                                                        {{$k}}
                                                        <span class=" mx-1 ml-2 font-weight-bold" style="    font-size: 15px;
                                                                 cursor: pointer;">X</span>
                                                            
                                                    </div>
                                                  @endforeach
                                                @endif
                                            </div>
                                        </div><!-- keywords -->
                                        <input type="hidden" name="keywords_final" id="keywords_final" value="{{$row->keywords}}">

                                        <input type="hidden" value="{{ $row->id }}" name="id">

                                        <div class="form-group">
                                            <label class="required">ملخص البحث</label>
                                            <textarea name="abstract" class="form-control" cols="30" rows="10" required>{{ $row->abstract }}</textarea>
                                        </div><!-- abstract -->


                                        <div class="form-group">
                                            <label class="required">نوع البحث</label>
                                            <select name="type" class="form-control" required>
                                                <option selected disabled>اختر</option>
                                                <option @selected($row->type == 1) value="1">مقيد الوصول</option>
                                                <option @selected($row->type == 0) value="0">مفتوح المصدر</option>
                                            </select>
                                        </div><!-- type -->


                                        <div class="form-group">
                                            <label class=" required">اختر مجلة للنشر</label>
                                            <select name="journal" class="form-control" required>
                                                <option selected disabled>اختر</option>
                                                @foreach ($journals as $jour)
                                                    <option @selected($row->journal_id == $jour->id) value="{{ $jour->id }}">{{ $jour->name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- journal -->


                                        <div class="form-group mb-4">
                                            <label>رفع ملف بحث جديد</label>
                                            <input type="file" name="file" accept=".doc,.docx" class="form-control">
                                            <small class="d-block text-left text-muted">انواع الملفات (doc/docx) فقط هي التي يتم قبولها</small>
                                        </div><!-- file -->


                                        <div class="form-group mb-2">
                                            <button type="submit" class="btn-main btn-block" onclick="setKeywordsVal()">ارسال</button>
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
    var keywords_final = document.querySelector('#keywords_final')
 var keywords = keywords_final.value.split(',')
 console.log('keywords: ', keywords);
    // 
    $('#keywords-input').keydown(function(e) {
        keywords_final = document.querySelector('#keywords_final')
        if (e.keyCode === 13) {
          
            let value = event.target.value
            if(value.length){
                keywords.push(value);
                let keywordslist  = document.querySelector('#keywords-list')
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
    document.querySelectorAll('.keyword-element .svg-inline--fa ').forEach(item =>{
        console.log('ite',item);
    })
    // document.addEventListener('click', function (event) {
	// if (!event.target.closest('.keyword-element')) return;
    //     let content = event.target.parentNode.innerText;
    
    //     keywords = keywords.filter((item) => item != content)
    //     keywords_final.value =keywords.join(',')
    //     event.target.parentNode.parentNode.removeChild(event.target.parentNode)

    // }, false);
    $(document).on('click','.keyword-element span',function(event){
    let content = event.target.parentNode.innerText

    keywords = keywords.filter(item => item != content.replace(' X','').toString().trim())
        keywords_final.value =keywords.join(',')
        event.target.parentNode.parentNode.removeChild(event.target.parentNode)
})
function setKeywordsVal(){
    $('#keywords-input').val(keywords.join(','))
}
//if small media or mobile app
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  document.querySelector('#keywords-notice').innerText=">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط مرتين على زر Enter )"
}
</script>

@endsection