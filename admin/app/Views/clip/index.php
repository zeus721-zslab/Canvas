<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">요소 관리</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 요소 관리 </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <!-- search form -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label style="margin-right: 20px;">카테고리</label>
                                <select class="form-control" name="category" style="width: calc(100% - 100px);display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <option value="clip">클립</option>
                                    <option value="bg">배경</option>
                                    <option value="topper">토퍼</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <label style="margin-right: 20px;">키워드</label>
                                <select class="form-control" name="search_type" style="width: calc(100% - 72px);display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <option value="title">제목</option>
                                    <option value="keyword">키워드</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <div class="form-group">
                                <input type="search" name="search_text" value="" class="form-control" title="">
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-block btn-primary goSearch" style="">검색하기</button>
                                <button type="button" class="btn btn-success insertClip">요소 등록</button>
                                <button type="button" class="btn btn-danger delClip">선택삭제</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- result table-->
            <div class="card fs-7" id="list_table"></div>

        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->

<?=csrf_field()?>
<script type="text/javascript">

    var loc_page    = 1;
    var total_page  = <?=$tot_page?>;
    var start       = true;
    var pop_id      = 'upsertFormModal';
    var Toast       = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    let uniqId      = '<?=$uniqId?>';

    $(document).on('hidden.bs.modal','#'+pop_id, function () {//animation 후 처리
        $('#'+pop_id).remove();
    });

    function upsertForm(id = null){
        $.ajax({
            url: "/ClipManagement/upsertForm",
            data: { id : id , _csrf : $('input[name="_csrf"]').val() },
            method: "post",
            dataType: "html",
            success: function (result) {
                $('body').append(result);
                $modal = $('#'+pop_id);
                $modal.modal({backdrop : 'static'});
                $modal.modal('show');
            }
        });

    }

    function fn_UpsertForm(){

        var keyword_arr = [];
        $('.keywordList button').each(function(){
            keyword_arr.push($(this).data('val'));
        });
        var keyword_str = keyword_arr.join(',');
        $('#upsertForm input[name="keyword"]').val(keyword_str);

        if(confirm('저장하시겠습니까?') === false) return false;

        $('#upsertForm input').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm textarea').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm select').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm span.error.invalid-feedback').remove();
        $('#upsertForm span.success.valid-feedback').remove();

        $('#upsertForm').submit();

    }

    function proc_del(arr){

        if(arr.length < 1){
            alert('삭제하실 정보를 선택해주세요.');
            return false;
        }

        if(confirm("정보를 삭제하시겠습니까?\n삭제 후 복구는 불가능합니다.") === false) return false;

        $.ajax({
            url: "/ClipManagement/delete",
            data: { id_arr : arr , _csrf : $('input[name="_csrf"]').val()},
            method: "post",
            dataType: "json",
            success: function (result) {

                $('input[name="_csrf"]').val(result.csrf);

                if(result.success){
                    if(result.msg){
                        Toast.fire({
                            icon: 'success',
                            title: result.msg
                        });
                    }
                    getList(loc_page);
                }

            }
        });

    }



    $(document).on('click' , '.copy-clip', function (e){
        e.preventDefault();
        var clip_id = $(this).data('idx')

        if(confirm('선택하신 템플릿을 복사하시겠습니까?')){

            $.ajax({
                url: "/ClipManagement/copyClip",
                data: {clip_id:clip_id} ,
                method: "post",
                dataType: "json",
                success: function (result) {
                    if(result.msg) alert(result.msg)
                    if(result.success) getList(1);
                }

            });

        }



    });

    //키워드 관련
    $(document).on('keyup' , 'input[name="keyword_str"]', function (e){
        e.preventDefault();

        if (e.keyCode === 13){

            var kVal = $(this).val();
            if( kVal === '' ){
                alert('키워드 입력 후 엔터를 눌러주세요!');
                $(this).focus();
                return false;
            }

            var aVal = kVal.split(',');
            var temp_str = '';
            $.each(aVal , function(k , v){
                temp_str = '';
                temp_str = v.ltrim().rtrim();
                aVal[k] = temp_str;
            });

            var input_overlap = false;
            $.each(aVal , function(k , v){
                $.each(aVal , function(kk , vv){
                    if(v === vv && k !== kk) input_overlap = true;
                }); //입력키워드 내 중복검색
            });
            if(input_overlap){
                alert('입력한 키워드 내 중복된 키워드가 있습니다.');
                return false;
            }

            var overlap = false;
            $('.keywordList button').each(function(){
                var data_v = $(this).data('val');
                $.each(aVal , function(k , v){
                    if( data_v === v ) overlap = true;
                });
            });
            if(overlap === true){
                alert('이미 등록된 키워드입니다.');
                return false;
            }

            var html = "";
            $.each(aVal , function(k , v) {
                html += "<button type=\"button\" class=\"btn btn-info text-white fs-7 py-1 px-2 mt-2 \"  data-val=\"" + v + "\">" + v + "</button>";
            });

            $('.keywordList').append(html);
            $(this).val("");

            $('.keywordList-callout-wrap').addClass('d-block').removeClass('d-none');

        }

    });
    $(document).on('click' , '.keywordList button', function (e){
        e.preventDefault();
        if(confirm('키워드를 삭제하시겠습니까?')){
            $(this).remove();
            if($('.keywordList button').length < 1){
                $('.keywordList-callout-wrap').addClass('d-none').removeClass('d-flex');
            }
        }
    });
    //키워드 관련

    //파일관련
    $(document).on('change','input[name="save_file"]',function(){
        var mime = MimeChk($(this));
        var thumbObj = $('input[name="thumb_file"]');
        if(mime == 'application/pdf'){ //pdf인 경우
            thumbObj.parent().removeClass('d-none');
            $('.callout-save-file').addClass('d-flex').removeClass('d-none').find('.img').hide();
            $('.callout-save-file .pdf').show();
        }else{//pdf가 아닌경우
            thumbObj.parent().addClass('d-none');
            thumbObj.val("");
            $('.callout-save-file').addClass('d-flex').removeClass('d-none').find('.pdf').hide();
            $('.callout-save-file .img').show();
        }
    });
    //파일관련

    $(document).on('click','#checkAll',function(){ //체크박스
        var clicks = $(this).data('clicks');
        if (clicks) $('#list_table input[type=\'checkbox\']').prop('checked', false);
        else $('#list_table input[type=\'checkbox\']').prop('checked', true);

        $(this).data('clicks', !clicks)
    });

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();

        var set_page;
        if($(this).data('page_seq') === 'first') set_page = 1;
        else if($(this).data('page_seq') === 'prev') set_page = (loc_page - 1) < 1 ? 1 : (loc_page - 1);
        else if($(this).data('page_seq') === 'next') set_page = (loc_page + 1) > total_page ? total_page : (loc_page + 1);
        else if($(this).data('page_seq') === 'last') set_page = total_page;
        else set_page = $(this).data('page_seq');

        if(loc_page === set_page) return false;

        getList(set_page);

        $(window).scrollTop(0);

    });

    $(function(){

        getList(loc_page);

        $('.insertClip').on('click',function(){ //회원등록 함수
            upsertForm();
        });

        $('.delClip').on('click',function(){ //선택삭제

            if($('input[name="clip_id"]:checked').length < 1){
                alert('삭제하실 요소를 선택해주세요.');
                return false;
            }

            var arr = [];
            $('input[name="clip_id"]:checked').each(function(){
                arr.push($(this).val());
            });

            proc_del(arr);
        });


        $('.goSearch').on('click',function(){
            getList(1);
        });

        $('input[type="search"]').on('keyup',function(){
            if( window.event.keyCode == 13 ) getList(loc_page); //검색창 enter 액션
        });

        window.history.replaceState({} , '', window.location.pathname);//querystring 제거

    });

    function getList(page){

        loc_page = page; //전역 페이지변수 갱신.

        var search_text = $('input[name="search_text"]').val();
        var search_type = $('select[name="search_type"]').val();
        var category = $('select[name="category"]').val();
        var per_page    = $('select[name="per_page"]').val();
        var _csrf       = $('input[name="_csrf"]').val();

        let data = {
              page          : page
            , search_type   : search_type
            , search_text   : search_text
            , category      : category
            , per_page      : per_page
            , _csrf         : _csrf
        };

        $.ajax({
            url: "/ClipManagement/lists",
            data: data ,
            method: "post",
            dataType: "html",
            success: function (result) {
                printList(result);
            }
        }).done(function(){
            if(uniqId !== ''){
                //error : 403 forbbiden
                //csrf val가 들어가기전 호출이되어 timeout처리
                setTimeout(function(){
                    upsertForm(uniqId);
                    uniqId = ''; //초기화
                },300) ;
            }
        });

    }

    function printList(html){
        $('#list_table').html(html);
    }


</script>

