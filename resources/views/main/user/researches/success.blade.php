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

                        


                            <div class="col-lg-12">

                                <div class="box-white p-3">

                                    <div class="result"></div><!-- Result Box-->

                                    @if (session()->has('successMsg'))
                                        <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                                        </div>
                                    @endif
                                    <div class="text-center py-4">
                                        <h4 class="text-center mb-4">تلقينا طلب نشر دراستك، وسوف نبلغك باي مستجدات   </h4>
                                        <h6 class="text-center ">
                                            احرص على الدخول لحسابك دورياً لتفقد حالة الطلب
                                        </h6> 
                                        <div class="col-12 my-3 py-2 text-center">
                                            <a href="{{route('current_user_researches',['id'=>$id])}}" class="">عرض حالة الطلب</a>
                                        </div>
                                        <div class="d-flex justify-content-center   flex-wrap">
                                            <div class="m-2 m-md-3">
                                                <a href="{{ userUrl('researches') }}" class="btn-main py-1"><i class="fa fa-plus ml-1"></i> تقديم دراسة أخرى</a>
                                            </div>
                                            <div class="m-2 mt-3 m-md-3">
                                                <a href="{{ userUrl('dashboard') }}" class="btn-main bg-danger py-1"><i class="fa fa-arrow-right ml-1"></i> العودة للصفحة الشخصية</a>
                                            </div>
                                        </div>
                                    </div>
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
//if small media or mobile app
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  document.querySelector('#keywords-notice').innerText=">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط مرتين على زر Enter )"
}
</script>

@endsection