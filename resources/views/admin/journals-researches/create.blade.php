@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
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
@endsection
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('researches') }}">الابحاث</a>
        <a  href="{{ admin_url('researches/create') }}">{{ $pageTitle }}</a>
    </div><!-- End Bar Links -->

    <div class="result"></div><!-- Result Box -->

 
    <section id="journals-create">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-white">
                    <form id="form-add-journal-reseaches" class="form"
                        action="{{ adminUrl('researches/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="required">اختر المجلة</label>
                            <select id="select-journal" name="journal" class="form-control" required>
                                <option selected disabled></option>
                                @foreach ($journals as $jour)
                                    <option value="{{ $jour->id }}">{{ $jour->name }}</option>
                                @endforeach
                            </select>
                        </div><!-- journal -->

                        <div class="form-group">
                            <label class="required">اختر الاصدار</label>
                            <select id="select-version" name="version" class="form-control" required>
                                <option selected disabled></option>
                            </select>
                        </div><!-- version -->

                        <div class="form-group">
                            <label class="">الملف ( PDF )</label>
                            <input type="file" name="file"  class="form-control"  />
                        </div><!-- file -->

                        <div class="form-group">
                            <label class="required">اسم المؤلف</label>
                            <input type="text" name="author_name" class="form-control" required />
                        </div><!-- author_name -->

                        <div class="form-group">
                            <label class="required">عنوان البحث</label>
                            <input type="text" name="title" class="form-control" required />
                        </div><!-- title -->


                        <div class="form-group">
                            <label class="required">نبذة مختصرة</label>
                            <textarea name="abstract" id="" cols="30" class="form-control editor" rows="10" required></textarea>
                        </div><!-- abstract -->


                        <div class="form-group">
                            <label>سعر البحث ( بالدولار )</label>
                            <input type="number" step="any" name="price" class="form-control" />
                            <small class=" text-muted">اذا كان البحث مجاني اترك حقل السعر فارغ</small>
                        </div><!-- price -->
                        <div class="form-group"">
                            <label class="required" id="keywords-notice">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط على زر Enter )</label>
                            <textarea name="keywords" class="form-control" cols="30" rows="3"  id="keywords-input"></textarea>
                            <div class="mt-2" id="keywords-list">
                                
                            </div>
                        </div><!-- keywords -->
                        <input type="hidden" name="keywords_final" id="keywords_final">

                        <button type="submit" class=" btn-main">اضافة البحث</button>

                    </form>
                </div>
            </div>
        </div>
    </section>




@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
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
