<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->
<style> #upsertForm .ok-sort-list li{cursor: move} </style>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">그룹 관리</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 그룹 관리 </li>
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
                        <div class="col-md-4 col-sm-12 d-flex gap-3 ">
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">카테고리</label>
                                <select class="form-control" name="category" style="width: calc(100% - 100px);display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <option value="clip">클립</option>
                                    <option value="bg">배경</option>
                                    <option value="template">템플릿</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">보이는영역</label>
                                <select class="form-control" name="view_type" style="width: calc(100% - 100px);display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <option value="canvas">캔버스</option>
                                    <option value="menu">메뉴</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4 col-sm-12">
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">키워드</label>
                                <select class="form-control" name="search_type" style="display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <option value="title">제목</option>
                                    <option value="keyword">키워드</option>
                                </select>
                                <input type="search" name="search_text" value="" class="form-control" title="">
                            </div>
                        </div>
                        
                        <div class="col-md-8 col-sm-12 d-flex justify-content-between">
                            <div class="buttons">
                                <button type="button" class="btn btn-block btn-primary goSearch" style="">검색하기</button>
                                <button type="button" class="btn btn-success insertGroup">그룹 등록</button>
                                <button type="button" class="btn btn-danger delGroup">선택삭제</button>
                            </div>
                            <div class="form-group">
                                <a role="button" class="btn btn-info" href="/GroupManagement/recommend">이달의 추천 템플릿</a>
                                <a role="button" class="btn btn-info" href="/GroupManagement/sort">정렬순서 변경</a>
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
            url: "/GroupManagement/upsertForm",
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

        var no_arr = []
          , ok_arr = [];

        var isShow = true;

        $('#upsertForm .no-sort-list li').each(function(){
            if($(this).data('use_flag') === 'Y') isShow = false;
            no_arr.push($(this).data('id'));
        });

        $('#upsertForm .ok-sort-list li').each(function(){
            if($(this).data('use_flag') === 'Y') isShow = false;
            ok_arr.push($(this).data('id'));
        });

        if(isShow === true && confirm("노출가능한 컨텐츠가 없습니다.\n이대로 저장하시겠습니까?") == false) return false;

        $('#upsertForm input[name="ok_arr"]').val(JSON.stringify(ok_arr));
        $('#upsertForm input[name="no_arr"]').val(JSON.stringify(no_arr));

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
            url: "/GroupManagement/delete",
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

        $('.insertGroup').on('click',function(){ //회원등록 함수
            upsertForm();
        });

        $('.delGroup').on('click',function(){ //선택삭제


            if($('input[name="group_id"]:checked').length < 1){
                alert('삭제하실 요소를 선택해주세요.');
                return false;
            }

            var arr = [];
            $('input[name="group_id"]:checked').each(function(){
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
        var view_type = $('select[name="view_type"]').val();
        var per_page    = $('select[name="per_page"]').val();
        var _csrf       = $('input[name="_csrf"]').val();

        let data = {
            page          : page
            , search_type   : search_type
            , search_text   : search_text
            , category      : category
            , per_page      : per_page
            , _csrf         : _csrf
            , view_type     : view_type
        };

        $.ajax({
            url: "/GroupManagement/lists",
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

    $(document).on('change' , '#upsertForm select[name="category"]' , function(){

        var show = false;
        var cnt = $('#upsertForm .no-sort-list li').length + $('#upsertForm .ok-sort-list li').length;


        if(cnt > 0 ) show = true;

        if(show === true && confirm('카테고리를 변경하면 기존에 등록된 컨텐츠들이 모두 제거됩니다.') === false) {
            $('#upsertForm select[name="category"]').val(prev_category);
            return false;
        }
        prev_category = $(this).val();
        $('.no-sort-list , .ok-sort-list').html("");
    });

    $(document).on('keyup','input[name="form-search-text"]',function(e){
        e.preventDefault();

        if (e.keyCode === 13){

            var str = $(this).val();
            var type = $('#upsertForm select[name="category"]').val();
            if( str === '' ){
                alert('검색할 단어를 입력해주세요!');
                $(this).focus();
                return false;
            }

            form_search(str , type);
        }
    });

    $(document).on('click', '.go-form-search',function(e){
        e.preventDefault();

        var str = $('input[name="form-search-text"]').val();
        var type = $('#upsertForm select[name="category"]').val();

        if( str === '' ){
            alert('검색할 단어를 입력해주세요!');
            $('input[name="form-search-text"]').focus();
            return false;
        }

        form_search(str , type);

    });

    $(document).on('click', '.set-select-data',function(e){
        e.preventDefault();
        set_no_sort_data($(this).data());
    });

    $(document).on('click', '.sort_move',function(e){
        e.preventDefault();
        var act = $(this).data('act');
        var html = $(this).parent().parent().parent().get(0);

        if( act === 'to_ok' ) {
            $(html).find('.sort_move').data('act' , 'to_no').attr('data-act' , 'to_no').html('<i class="fa-solid fa-angles-left"></i>');
            $('#upsertForm .ok-sort-list').prepend(html);
        } else if( act === 'to_no' ) {
            $(html).find('.sort_move').data('act' , 'to_ok').attr('data-act' , 'to_ok').html('<i class="fa-solid fa-angles-right"></i>');
            $('#upsertForm .no-sort-list').prepend(html);
        }

    });

    $(document).on('click', '.remove-content',function(e){
        e.preventDefault();
        $(this).parent().parent().parent().remove();
    });


    $(document).on('click', '.change-paid',function(e){
        e.preventDefault();

        if(confirm('무료여부를 변경하시겠습니까?')){

            var $this = $(this);
            var id = $this.data('id');


            $.ajax({
                type: 'post',
                url: "/GroupManagement/changePaid",
                data: { template_id : id },
                dataType: 'json',
                success: function(result){
                    if(result.msg) alert(result.msg);
                }
            }).done(function(result){
                if(result.success){
                    $this.removeClass('btn-outline-primary').removeClass('btn-success');
                    if( result.paid_yn === 'Y' ) $this.addClass('btn-outline-primary').html('유료'); //무료 > 유료로 변경
                    else $this.addClass('btn-success').html('무료'); //유료 > 무료로 변경
                }
            });

        }


    });

    function set_no_sort_data(data){

        var bOverlap1 = false , bOverlap2 = false ;
        $('#upsertForm .no-sort-list li').each(function(){
            if( $(this).data('id') == data.id) bOverlap1 = true;
        });

        $('#upsertForm .ok-sort-list li').each(function(){
            if( $(this).data('id') == data.id) bOverlap2 = true;
        })
        if(bOverlap1){
            alert('"순서 미등록 컨텐츠"에 이미 등록된 컨텐츠 입니다.');
            return false;
        }
        if(bOverlap2){
            alert('"순서 등록 컨텐츠"에 이미 등록된 컨텐츠 입니다.');
            return false;
        }

        var html = '';
            html += '<li class="d-flex flex-row align-items-center py-2 border-bottom gap-2" data-use_flag="'+data.use_flag+'" data-id="'+data.id+'">';
            html += '   <img src="'+data.img_src+'" class="img-thumbnail" alt="" style="height: 50px">';
            html += '   <div class="d-flex justify-content-between w-100 align-items-center">';
            html += '       <span>'+data.title+'</span>';
            html += '       <div class="d-flex gap-2">';
            html += '           <button type="button" class="btn btn-xs btn-danger py-1 remove-content"><i class="fa-solid fa-xmark"></i></button>';
            html += '           <button type="button" class="btn btn-xs btn-info py-1 sort_move" data-act="to_ok"><i class="fa-solid fa-angles-right"></i></button>';
            html += '       </div>';
            //html += '       <button type="button" class="btn btn-xs btn-info py-2 sort_move" data-act="to_ok"><i class="fa-solid fa-angles-right"></i></button>';
            html += '   </div>';
            html += '</li>';
        $('#upsertForm .no-sort-list').append(html);
    }


    function form_search(str , type){
        var m = '_'+type;
        $.ajax({
            type: 'post',
            url: "/Canvas/getSearchContents",
            data: {
                    m : m
                ,   str : str
            },
            dataType: 'json',
            success: function(result){
                if(result.msg) alert(result.msg);
                if(result.success) print_search_result(result.data , m);
            }
        });
    }

    function print_search_result(data , m){

        var html = '';
        var search_str = $('input[name="form-search-text"]').val();

        if(data.length < 1){
            html = '<li class="d-flex justify-content-center fs-7 align-items-center"><b>"'+search_str+'"</b>&nbsp;를 포함한 검색 결과가 없습니다.</li>';
        }else{
            $.each(data,function(k,r){
                html += '<li class="d-flex flex-row py-2 border-bottom gap-2">';
                html += '   <img onerror="this.src=\'https://placehold.co/80x40?text=NO_IMG\'" src="'+r.thumb_file+'" class="img-thumbnail" alt="'+r.title+'" style="width: 80px;" />';
                html += '   <div class="d-flex justify-content-between w-100 align-items-center">';
                html += '       <span class="d-flex align-items-center fs-7">'+r.title+'</span>';

                if(m == '_clip' || m == '_bg') html += ' <button class="btn btn-xs btn-primary py-1 set-select-data" type="button" data-use_flag="'+r.use_flag+'" data-title="'+r.title+'" data-img_src="'+r.thumb_file+'" data-id="'+r.clip_id+'">선택</button>';
                else html += ' <button class="btn btn-xs btn-primary py-1 set-select-data" type="button" data-title="'+r.title+'" data-use_flag="'+r.use_flag+'" data-img_src="'+r.thumb_file+'" data-id="'+r.template_id+'">선택</button>';

                html += '   </div>';
                html += '</li>';
            });
        }

        $('#upsertFormModal .search-result').html(html);

    }

    function setSortable(){
        $('#upsertForm .ok-sort-list').sortable({
            axis: 'y',
            opacity: 0.5,
            tolerance: 'pointer' // 이동 중인 항목이 마우스 포인터 기준으로 다른 항목 위에 있는지 확인
        });
    }


</script>

