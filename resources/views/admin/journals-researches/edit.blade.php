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
        <a>{{ $pageTitle }}</a>
    </div><!-- End Bar Links -->

    <div class="result"></div><!-- Result Box -->


    <section id="journals-create">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-white">
                    <form id="form-edit-journal-reseaches" class="form"
                        action="{{ adminUrl('researches/update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $row->id }}">
                        <div class="form-group">
                            <label class="required">اختر المجلة</label>
                            <select id="select-journal" name="journal" class="form-control" required>
                                @foreach ($journals as $jour)
                                    <option @if ($jour->id == $row->journal_id)  {{ 'selected' }} @endif value="{{ $jour->id }}">
                                        {{ $jour->name }}</option>
                                @endforeach
                            </select>
                        </div><!-- journal -->

                        <div class="form-group">
                            <label class="required">اختر الاصدار</label>
                            <select id="select-version" name="version" class="form-control" required>
                                @foreach ($versions as $ver)
                                    <option @if ($row->version_id == $ver->id) {{ 'selected' }} @endif
                                        value="{{ $ver->id }}">
                                        @if ($ver->old_version != null)
                                            {{ $ver->old_version }}
                                        @else
                                            الإصدار
                                            {{ $ver->version }} : {{ $ver->year }}
                                            {{ $ver->month }}
                                            {{ $ver->day }}
                                        @endif
                                    </option>
                                @endforeach

                            </select>
                        </div><!-- version -->

                        <div class="form-group">
                            <label class="float-right">الملف ( PDF )</label>

                            <small class=" float-left">
                                @if (checkFile('assets/uploads/journals-researches/' . $row->file))
                                    <a target="__blank"
                                        href="{{ asset('assets/uploads/journals-researches/' . $row->file) }}"><i
                                            class="fa-solid fa-arrow-up-right-from-square"></i> عرض
                                        الملف الحالي</a>
                                @else
                                    <small class=" font-weight-bold text-danger">لا يوجد ملف</small>
                                @endif
                            </small>
                            <div class="clearfix"></div>
                            <input type="file" name="file" accept=".pdf" class="form-control" />
                        </div><!-- file -->

                        <div class="form-group">
                            <label class="required">اسم المؤلف</label>
                            <input type="text" name="author_name" class="form-control" value="{{ $row->author_name }}"
                                required />
                        </div><!-- author_name -->

                        <div class="form-group">
                            <label class="required">عنوان البحث</label>
                            <input type="text" name="title" class="form-control" value="{{ $row->title }}" required />
                        </div><!-- title -->


                        <div class="form-group">
                            <label class="required">نبذة مختصرة</label>
                            <textarea name="abstract" id="" cols="30" class="form-control editor" rows="15" required>{{  $row->abstract }}</textarea>
                        </div><!-- abstract -->


                        <div class="form-group">
                            <label>سعر البحث ( بالدولار )</label>
                            <input type="number" step="any" name="price" class="form-control"
                                value="{{ $row->price }}" />
                            <small class=" text-muted">اذا كان البحث مجاني اترك حقل السعر فارغ</small>
                        </div><!-- price -->
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

                        <button type="submit" class=" btn-main">تحديث البحث</button>

                    </form>
                </div>
            </div>
        </div>
    </section>




@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
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
