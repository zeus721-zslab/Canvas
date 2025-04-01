<?php
/**
 * @var int $tot_page '전체 페이지'
 * @var int $uniqId 'req id'
 *
 */

?>
<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->

<?=link_src_html('/plugins/moment/moment.min.js' , 'js')?>
<?=link_src_html('/plugins/moment/locale/ko.js' , 'js')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.css' , 'css')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.js' , 'js')?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">취소 요청</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 취소 요청 </li>
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
                                    <option value="B.username">이름</option>
                                </select>
                                <input type="search" name="search_text" value="" class="form-control" title="">
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 d-flex justify-content-between">
                            <div class="buttons">
                                <button type="button" class="btn btn-block btn-primary goSearch">검색하기</button>
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

<div id="upsertFormModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content ">

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/PaymentManagement/upsert" method="post">
                    <?=csrf_field()?>
                    <input type="hidden" name="id" value="" />
                    <input type="hidden" name="cancel_type" value="req_cancel" />
                    <input type="hidden" name="pay_flag" value="C" />
                    <div class="col-md-12 d-flex flex-column gap-2">
                        <div class="fw-bold">결제 취소 - 회원 이용기간 수정 </div>
                        <div>
                            <button type="button" class="btn btn-xs btn-danger initUseDate">이용기간 초기화</button>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input-group date w-50" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="s_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="" autocomplete="off">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <span class="d-flex align-items-center">~</span>
                            <div class="input-group date w-50" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="e_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="" autocomplete="off">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#upsertFormModal').modal('hide');">닫기</button>
                <button type="button" class="btn btn-danger" onclick="fn_UpsertForm();">결제취소</button>
            </div>

        </div>
    </div>
</div>

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

    // $(document).on('hidden.bs.modal','#'+pop_id, function () {//animation 후 처리
    //     $('#'+pop_id).remove();
    // });
    $(document).on('click','.show-meminfo-more',function(){

        var hasNONE = $(this).parent().parent().find('.meminfo-more').hasClass('d-none');
        $('.show-meminfo-more').html('+');

        if(hasNONE) $(this).html('-');
        else $(this).html('+');


        $('.meminfo-more').addClass('d-none').removeClass('d-flex');
        if(!hasNONE) $(this).parent().parent().find('.meminfo-more').addClass('d-none').removeClass('d-flex');
        else $(this).parent().parent().find('.meminfo-more').toggleClass('d-none').toggleClass('d-flex');
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

    $(document).on('click','#upsertFormModal .initUseDate',function(e){
        e.preventDefault();

        var $s_date_input = $('#upsertFormModal input[name="s_use_date"]');
        var $e_date_input = $('#upsertFormModal input[name="e_use_date"]');

        var s_date = $s_date_input.val();
        var e_date = $e_date_input.val();

        if(s_date && e_date){
            const newDate = new Date(e_date);

            <?php /* @TODO ' 차후 상품정보(months)에 따라 개월 수를 차감해야함' */?>
            newDate.setMonth(newDate.getMonth() - 12);

            var set_e_date = newDate.getFullYear()+'-'+(newDate.getMonth()+1).toString().padStart(2,'0')+'-'+newDate.getDate().toString().padStart(2,'0');

            if(set_e_date === s_date){
                $s_date_input.val('');
                $e_date_input.val('');
            }else{
                $e_date_input.val(set_e_date);
            }
        }else{
            alert('이용기간 정보가 없습니다.');
        }

    });

    $(document).on('click','.reqCancel',function(){

        var order_id = $(this).data('order_id');
        if(order_id === ''){
            alert('주문 아이디가 없습니다');
            return false;
        }

        if($(this).data('status') === 'Y' && $(this).data('req') === 'Y'){ //결제완료상태 & 결제취소요청

            var $s_use_date = $('#upsertFormModal input[name="s_use_date"]');
            var $e_use_date = $('#upsertFormModal input[name="e_use_date"]');

            $.ajax({
                url: "/PaymentManagement/getCancelInfo/",
                data: { _csrf : $('input[name="_csrf"]').val() , order_id : order_id },
                method: "post",
                dataType: "json",
                async: false,
                success: function (result) {

                    if(result.msg) alert(result.msg);

                    if(result.success){
                        var data = result.data ;
                        $s_use_date.val(data.s_use_date);
                        $e_use_date.val(data.e_use_date);

                        var $modal = $('#upsertFormModal');
                        $modal.modal({backdrop : 'static'});
                        $modal.modal('show');

                        $modal.find('input[name="id"]').val(data.idx);
                        $s_use_date.val(data.user_s_use_date);
                        $e_use_date.val(data.user_e_use_date);

                    }
                }
            });

            $('.datetimepicker-input').daterangepicker({
                autoclose: true,
                singleDatePicker: true,
                autoUpdateInput: false,
                changeYear: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: '취소',
                    applyLabel:'확인'
                }
            });

            $s_use_date.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

            $e_use_date.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });


        }else{

            var req = $(this).data('req');
            var confimr_msg = '취소처리를 하시겠습니까?';
            if(req === 'C') confimr_msg = '취소요청을 원 상태로 되될리시겠습니까?';

            if(!confirm(confimr_msg)){
                return false;
            }

            $.ajax({
                url : '/PaymentManagement/reqCancel',
                type : 'post',
                data : { req : req , order_id : order_id , _csrf : $('input[name="_csrf"]').val() },
                dataType : 'json',
                success : function(result){
                    if(result.msg) alert(result.msg);
                    if(result.success) {
                        chkReqCancel();
                        getList();
                    }

                }
            });

        }

    });

    function fn_UpsertForm(){
        $('#upsertForm').submit();
    }

    $(function(){

        getList(loc_page);

        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result, status) {

                $('input[name="_csrf"]').val(result.csrf);

                if(result.success){
                    //modal off
                    $('#upsertFormModal').modal('hide');
                    var msg = result.msg ? result.msg : '정상적으로 저장되었습니다.';
                    Toast.fire({
                        icon: 'success',
                        title: msg
                    });
                    getList(loc_page);
                    chkReqCancel();

                }else{

                    if(result.msg) alert(result.msg);

                }
            }
            , error : function (request,status,error){
                alert("처리 중 문제가 발생하였습니다\n다시시도해주세요.");
                // location.reload();
            }
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
            , isReqCancel    : 'Y'
            , _csrf         : _csrf
        };

        $.ajax({
            url: "/PaymentManagement/lists",
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

