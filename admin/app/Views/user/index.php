<?php
/**
 * @var int $tot_page '전체 페이지'
 * @var int $uniqId 'req id'
 *
 */

?>
<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->
<style> #upsertForm .ok-sort-list li{cursor: move} </style>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">회원 관리</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 회원 관리 </li>
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
                                    <option value="A.username">이름</option>
                                    <option value="A.user_email">이메일</option>
                                    <option value="A.cell_tel">연락처</option>
                                    <option value="A.login_id">아이디</option>
                                    <option value="A.id">회원번호</option>
                                </select>
                                <input type="search" name="search_text" value="" class="form-control" title="">
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 d-flex justify-content-between">
                            <div class="buttons">
                                <button type="button" class="btn btn-block btn-primary goSearch">검색하기</button>
                                <button type="button" class="btn btn-block btn-success insertUser">회원가입</button>
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
            url: "/UserManagement/upsertForm",
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

    $(document).on('click','.add-1year',function(e){
        e.preventDefault();
        var target = $(this).data('target');
        var aTarget = target.split('|');
        var $s_date = $('input[name='+aTarget[0]+']');
        var $e_date = $('input[name='+aTarget[1]+']');
        if( $s_date.length > 0 && $e_date.length > 0 ){
            var setSDate = addDate();
            var setEDate = addDate($e_date.val() , 1 , 'year');
            $s_date.val(setSDate);
            $e_date.val(setEDate);
        }

    });

    $(document).on('click','.add-6month',function(e){
        e.preventDefault();
        var target = $(this).data('target');
        var aTarget = target.split('|');
        var $s_date = $('input[name='+aTarget[0]+']');
        var $e_date = $('input[name='+aTarget[1]+']');
        if( $s_date.length > 0 && $e_date.length > 0 ){
            var setSDate = addDate();
            var setEDate = addDate($e_date.val() , 6 , 'month');
            $s_date.val(setSDate);
            $e_date.val(setEDate);
        }

    });

    $(document).on('keyup','input[name="userCsMemo"]',function(e){
        e.preventDefault();
        if (e.keyCode === 13){
            var data = {user_id : $(this).data('id') , cs_memo : $(this).val() }

            if(data.cs_memo == ''){
                alert('저장할 내용을 입력해주세요!');
                return false;
            }

            $.ajax({
                url: "/UserManagement/setCsMemo",
                data: data,
                method: "post",
                dataType: "json",
                success: function (result) {

                    if (result.msg) {
                        if (result.success) {
                            Toast.fire({
                                icon: 'success',
                                title: result.msg
                            });
                        }else {
                            alert(result.msg);
                        }
                    }

                }

            });
        }
    });

    function addDate(date = '',num = 0, type = 'date' ){
        var today = '';
        if(date === ''){
            today = new Date();
            date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        }

        var newDate = new Date(date);
        if(num > 0){
            if(type === 'year') newDate.setFullYear(newDate.getFullYear() + num);
            if(type === 'month') newDate.setMonth((newDate.getMonth()) + num);
            if(type === 'day' || type === 'date') newDate.setDate(newDate.getDate() + num);
        }

        return newDate.getFullYear()+'-'+String(newDate.getMonth()+1).padStart(2, "0")+'-'+String(newDate.getDate()).padStart(2, "0");

    }

    $(function(){

        getList(loc_page);

        $('.insertUser').on('click',function(){ //회원등록 함수
            upsertForm();
        });

        $('.goSearch').on('click',function(){
            getList(1);
        });

        $('input[type="search"]').on('keyup',function(){
            if( window.event.keyCode == 13 ) getList(loc_page); //검색창 enter 액션
        });

        window.history.replaceState({} , '', window.location.pathname);//querystring 제거

    });

    function fn_UpsertForm(){

        if(confirm('저장하시겠습니까?') === false) return false;

        $('#upsertForm input').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm textarea').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm select').removeClass('is-invalid').removeClass('is-valid');
        $('#upsertForm span.error.invalid-feedback').remove();
        $('#upsertForm span.success.valid-feedback').remove();

        $('#upsertForm').submit();

    }

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
            url: "/UserManagement/lists",
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

