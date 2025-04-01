<?php
/**
 * @var int $tot_page '전체 페이지'
 * @var int $uniqId 'req id'
 *
 */

?>
<?=link_src_html('/plugins/sweetalert2/sweetalert2.css','css') ?><!-- Toast css -->
<?=link_src_html('/plugins/sweetalert2/sweetalert2.min.js','js') ?><!-- Toast js -->

<?=link_src_html('/css/layer_popup.css','css')?>
<?=link_src_html('/js/layer_popup.js','js')?>

<style> #upsertForm .ok-sort-list li{cursor: move} </style>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">결제 관리</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> 결제 관리 </li>
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
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">결제상태</label>
                                <select class="form-control" name="pay_flag" style="display: inline-block;w" title="">
                                    <option value="">전체</option>
                                    <option value="W">입금대기</option>
                                    <option value="Y">결제완료</option>
                                    <option value="C">결제취소</option>
                                    <option value="R">결제준비(KCP미완료)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">결제방법</label>
                                <select class="form-control" name="o_paymethod" style="display: inline-block;w" title="">
                                    <option value="">전체</option>
                                    <option value="card">신용카드</option>
                                    <option value="vcnt">가상계좌</option>
                                    <option value="fixed_vacc">고정계좌</option>
                                    <option value="phone">휴대폰</option>
                                </select>
                            </div>
                        </div>

                    </div>




                    <div class="row mb-3">

                        <div class="col-md-4 col-sm-12">
                            <div class="input-group">
                                <label class="d-flex align-items-center" style="margin-right: 20px;">키워드</label>
                                <select class="form-control" name="search_type" style="display: inline-block;w" title="">
                                    <option value="">전체</option>
                                    <option value="A.o_name">주문자 이름</option>
                                    <option value="A.o_celltel">주문자 연락처</option>
                                    <option value="B.username">회원이름</option>
                                    <option value="B.cell_tel">회원 연락처</option>
                                    <option value="B.user_email">회원 이메일</option>
                                    <option value="B.login_id">회원 아이디</option>
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
            url: "/PaymentManagement/upsertForm",
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

    $(document).on('click','.receipt-submit',function(){
        var $receipt_name = $('input[name="receipt_name"]');
        if($receipt_name.val() === ''){
            alert('수신자이름을 입력해주세요!');
            return false;
        }

        var oData = $(this).data();
        $('#hiddenFrame').attr('src','/PaymentManagement/receipt?oid='+oData.id+'&receipt_name='+$receipt_name.val());
        __popup.close();
    });

    $(document).on('click','.download-receipt',function(){

        var oData = $(this).data();

        var html = '';
        html += '<div class="d-flex flex-column" style="width: 100%;">';
        html += '   <div class="form-floating mb-3">';
        html += '       <input type="text" class="form-control" style="border-radius: 0" id="floatingIdInput" name="receipt_name" inputmode="receipt_name" autocomplete="receipt_name" placeholder="수신자명" value="" required>';
        html += '       <label for="floatingIdInput">수신자명</label>';
        html += '   </div>';
        html += '   <button class="btn btn-primary receipt-submit" data-id="'+oData.id+'">확인</button>';
        html += '</div>';

        __popup.init('거래명세서 수신',300,270);
        __popup.setMain(html);
        __popup.open();

        $('input[name="receipt_name"]').focus();

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

    $(document).on('change','#upsertFormModal select[name="pay_flag"]',function(){

        $payment_cancel_wrap = $('#upsertFormModal .payment-cancel-wrap');
        $send_sms_wrap = $('#upsertFormModal .send_sms_wrap');

        if( $payment_cancel_wrap.length > 0 ){
            $payment_cancel_wrap.addClass('d-none');
            if($(this).val() !== 'Y') $payment_cancel_wrap.removeClass('d-none');
        }

        if( $send_sms_wrap.length > 0 ){
            $send_sms_wrap.removeClass('d-none').addClass('d-flex');
            if($(this).val() !== 'Y') $send_sms_wrap.addClass('d-none').removeClass('d-flex');
            else if($(this).val() === 'Y') $send_sms_wrap.removeClass('d-none').addClass('d-flex');
        }

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

    $(document).on('click','.invoicePop',function(){
        var id = $(this).data('id');
        var win = window.open('','payment_invoice_pop','width=800,height=1000,left=0,top=0');
        win.location.href = '/Wehago/invoicePop?id='+id;

    })

    $(document).on('click','.show-meminfo-more',function(){

        var hasNONE = $(this).parent().parent().find('.meminfo-more').hasClass('d-none');
        $('.show-meminfo-more').html('+');

        if(hasNONE) $(this).html('-');
        else $(this).html('+');


        $('.meminfo-more').addClass('d-none').removeClass('d-flex');
        if(!hasNONE) $(this).parent().parent().find('.meminfo-more').addClass('d-none').removeClass('d-flex');
        else $(this).parent().parent().find('.meminfo-more').toggleClass('d-none').toggleClass('d-flex');
    });

    $(function(){

        getList(loc_page);


        $('.goSearch').on('click',function(){
            getList(1);
        });

        $('input[type="search"]').on('keyup',function(){
            if( window.event.keyCode == 13 ) getList(loc_page); //검색창 enter 액션
        });
        window.history.replaceState({} , '', window.location.pathname);//querystring 제거

    });

    $(document).on('click','.kcp-cancel',function(e){

        e.preventDefault();

        if(confirm('해당 주문 취소하시겠습니까?') == false) return false;

        var idx = $(this).data('idx');

        $.ajax({
            url: "/PaymentManagement/cancel_kcp",
            data: { _csrf : $('input[name="_csrf"]').val() , idx : idx },
            method: "post",
            dataType: "json",
            success: function (result) {
                // console.log(result);
                if(result.msg) alert(result.msg);
            }
        });

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
        var per_page    = $('select[name="per_page"]').val();
        var o_paymethod = $('select[name="o_paymethod"]').val();
        var pay_flag = $('select[name="pay_flag"]').val();
        var _csrf       = $('input[name="_csrf"]').val();





        let data = {
            page          : page
            , search_type   : search_type
            , search_text   : search_text
            , o_paymethod      : o_paymethod
            , pay_flag      : pay_flag
            , per_page      : per_page
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

