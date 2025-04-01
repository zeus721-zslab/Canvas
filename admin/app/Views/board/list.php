<?php
/**
 * @var int $tot_page '전체 페이지'
 * @var int $uniqId 'req id'
 *
 */

?>
<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
<?=link_src_html('/plugins/ckeditor-bundle/style.css','css') ?><!-- Toast css -->
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>


<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">공지사항 관리</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 공지사항 관리 </li>
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

                        <div class="col-md-4 col-sm-12">
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">키워드</label>
                                <select class="form-control" name="search_type" style="display: inline-block;" title="">
                                    <option value="">전체</option>
                                    <!--                                    <option value="B.id">아이디</option>-->
                                    <option value="title">이름</option>
                                    <option value="content">내용</option>
                                </select>
                                <input type="search" name="search_text" value="" class="form-control" title="">
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 d-flex justify-content-between">
                            <div class="buttons">
                                <button type="button" class="btn btn-block btn-primary goSearch">검색하기</button>
                                <button type="button" class="btn btn-block btn-success" onclick="upsertBoardForm()">공지사항 등록</button>
                                <button type="button" class="btn btn-block btn-danger delBoard">선택삭제</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- result table-->
            <div class="row">
                <div class="col-12">
                    <div class="card fs-7" id="list_table"></div>
                </div>
            </div>

        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->

<script type="text/javascript">

    function proc_del(arr){

        if(arr.length < 1){
            alert('삭제하실 공지를 선택해주세요.');
            return false;
        }

        if(confirm("공지사항을 삭제하시겠습니까?\n삭제 후 복구는 불가능합니다.") == false) return false;

        $.ajax({
            url: "/BoardManagement/delete",
            data: { board_id_arr : arr },
            method: "post",
            dataType: "json",
            success: function (result) {

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

    $(document).on('click','.delBoard',function(){ //회원정보 삭제

        if($('.del_chk:checked').length < 1){
            alert('삭제하실 공지를 선택해주세요.');
            return false;
        }

        var arr = [];
        $('.del_chk:checked').each(function(k,r){
            arr.push($(this).val());
        });

        proc_del(arr);

    });

    $(document).on('click','.updateBoard',function(){ //수정
        var user_id = $(this).data('seq');
        upsertBoardForm(user_id);
    });

    $(document).on('click','#checkAll',function(){ //체크박스
        var clicks = $(this).data('clicks');
        if (clicks) $('#list_table input[type=\'checkbox\']').prop('checked', false);
        else $('#list_table input[type=\'checkbox\']').prop('checked', true);

        $(this).data('clicks', !clicks)
    });

    var loc_page    = 1;
    var total_page  = <?=$tot_page?>;
    var pop_id      = 'upsertFormModal';
    var start       = true;
    var Toast       = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();

        var set_page;
        if($(this).data('page_seq') == 'first') set_page = 1;
        else if($(this).data('page_seq') == 'prev') set_page = (loc_page - 1) < 1 ? 1 : (loc_page - 1);
        else if($(this).data('page_seq') == 'next') set_page = (loc_page + 1) > total_page ? total_page : (loc_page + 1);
        else if($(this).data('page_seq') == 'last') set_page = total_page;
        else set_page = $(this).data('page_seq');

        if(loc_page == set_page) return false;

        getList(set_page);

    });

    $(document).on('hidden.bs.modal','#'+pop_id, function () {//animation 후 처리
        $('#'+pop_id).remove();
        if(typeof editor === 'object'){
            editor.destroy();
        }
    });

    $(function(){

        getList(loc_page);

        $('input[type="search"]').on('keyup',function(){
            if( window.event.keyCode == 13 ) getList(loc_page); //검색창 enter 액션
        });
        $('.goSearch').on('click',function(){
            getList(1);
        });
        
        window.history.replaceState({} , '', window.location.pathname);//querystring 제거
    });

    $(document).on('click','.fileDownload',function(){
        single_download(this);
    });

    $(document).on('click','.fileDelete',function(){

        if(confirm('파일을 삭제하시겠습니까?') == false){
            return false;
        }
        var $this = $(this);
        var file_id = $this.data('id');

        $.ajax({
            url: "/BoardManagement/delete/file",
            data: { file_id : file_id },
            method: "post",
            dataType: "json",
            success: function (result) {
                if(result.success){
                    if(result.msg){
                        Toast.fire({
                            icon: 'success',
                            title: result.msg
                        });
                    }
                    $this.parent().parent().remove();
                }
            }
        });

    });

    function getList(page){

        loc_page = page; //전역 페이지변수 갱신.

        var search_text = $('input[name="search_text"]').val();
        var search_type = $('select[name="search_type"]').val();
        var per_page    = $('select[name="per_page"]').val();

        $.ajax({
            url: "/BoardManagement/lists",
            data: { page: page , search_type : search_type , search_text : search_text , per_page : per_page },
            method: "post",
            dataType: "html",
            success: function (result) {
                printList(result);
            }
        }).done(function(){
            <?php if(empty($get_data) == false){?>
            if(start === true) {
                upsertBoardForm('<?=$get_data['data']?>');
                start = false;
            }
            <?php }?>
        });

    }

    function printList(html){
        $('#list_table').html(html);
    }
    function upsertBoardForm(board_id = null){

        $.ajax({
            url: "/BoardManagement/upsertForm",
            data: { board_id : board_id },
            method: "post",
            dataType: "html",
            success: function (result) {
                $('body').append(result);
                $modal = $('#'+pop_id);
                $modal.modal({backdrop : 'static' , focus : false});
                $modal.modal('show');
            }
        });

    }

    function fn_UpsertForm(){

        if(confirm('저장하시겠습니까?') == false) return false;

        var content = editor.getData();
        $('#'+pop_id+' textarea[name="content"]').val(content);

        $('#upsertForm input').removeClass('is-invalid');
        $('#upsertForm textarea').removeClass('is-invalid');
        $('#upsertForm select').removeClass('is-invalid');
        $('#upsertForm span.error.invalid-feedback').remove();

        $('#upsertForm').submit();

    }
</script>
