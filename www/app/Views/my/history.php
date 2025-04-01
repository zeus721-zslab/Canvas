<?php

/**
 * @var string $ext '외부 html'
 * @var array $aOrderLists '주문/결제 리스트'
 *
 */
?>

<main>
    <div class="container-fluid w-1560">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center">내 정보</h1>
        </div>

        <div class="row mt-5">

            <div class="col-12">

                <?=$ext?>

                <ul class="d-flex border-bottom my-info-tap mt-5">
                    <li class="active" style="border:1px solid #ddd; border-bottom: none;">
                        <a class="d-inline-block py-2 px-5" href="/My/history">결제내역 조회</a>
                    </li>
                    <li style="border:1px solid #ddd; border-bottom: none;border-left:none;">
                        <a class="d-inline-block py-2 px-5" href="/My/info">회원정보 수정</a>
                    </li>
                </ul>

                <div class="history-list-wrap">

                    <table class="border-bottom w-100 payment-history" >

                        <thead>
                        <tr class="border-top">
                            <th class="bg-light">결제일</th>
                            <th class="bg-light">상품명</th>
                            <th class="bg-light">결제수단</th>
                            <th class="bg-light">결제금액</th>
                            <th class="bg-light">주문번호</th>
                            <th class="bg-light">결제상태</th>
                            <th class="bg-light">영수증 확인</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($aOrderLists as $r) { //zsView($r);  ?>

                            <tr class="border-top">
                                <td>
                                    <?php if(!$r['pay_date']){ ?>
                                        입금 전
                                    <?php }else{?>
                                        <?=view_date_format($r['pay_date'])?>
                                    <?php }?>
                                </td>
                                <td><?=$r['good_name']?></td>
                                <td>
                                    <?php if($r['o_paymethod'] == 'card' ){?>
                                    신용카드
                                    <?php } else if($r['o_paymethod'] == 'fixed_vacc' || $r['o_paymethod'] == 'vcnt' ){ ?>
                                    가상계좌
                                    <?php } else if($r['o_paymethod'] == 'phone' ){ ?>
                                        휴대폰 결제
                                    <?php } ?>
                                </td>
                                <td><?=number_format($r['amount'])?>원</td>
                                <td><?=$r['order_id']?></td>
                                <td>
                                    <?php if($r['req_cancel'] == 'Y'){ //취소요청 여부?>

                                        <?php if($r['req_cancel_complete'] == 'Y'){ //취소처리 완료여부 ?>
                                            <span class="text-primary">취소처리 완료</span><br>
                                            <span class="text-primary"><?=view_date_format($r['req_cancel_date'])?></span>
                                        <?php }else{?>
                                            <span class="text-danger">취소처리 요청</span>
                                        <?php }?>

                                    <?php } else { ?>

                                        <?php if($r['pay_flag'] == 'Y') {?>
                                            결제완료
                                        <?php } else if($r['pay_flag'] == 'N') {?>
                                            입금 전
                                        <?php } else if($r['pay_flag'] == 'W') {?>
                                            입금 대기<br><button class="btn btn-xs btn-gray viewVC" data-bankacct="<?=$r['bankacct']?>" data-deposit="<?=$r['deposit']?>" data-vacc_limit="<?=view_date_format($r['vacc_limit'])?>" data-bank="<?=$r['bank']?>">입금계좌보기</button>
                                        <?php } else if($r['pay_flag'] == 'C') {?>
                                            결제 취소
                                        <?php } ?>

                                    <?php }?>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2">

                                    <?php if($r['req_cancel'] == 'N' && $r['pay_flag'] === 'Y' ) {?>
                                        <?php if($r['o_paymethod'] == 'card'){?>
                                            <button class="btn btn-xs btn-black payCheck paid-receipt" data-id="<?=$r['idx']?>" data-pay_method="<?=$r['o_paymethod']?>" data-tno="<?=$r['tno']?>" data-order_id="<?=$r['order_id']?>" data-amount="<?=$r['amount']?>">카드전표</button>
                                            <button class="btn btn-xs btn-black payCheck card-receipt-other" data-id="<?=$r['idx']?>" data-pay_method="<?=$r['o_paymethod']?>" data-tno="<?=$r['tno']?>" data-order_id="<?=$r['order_id']?>" data-amount="<?=$r['amount']?>">거래명세서</button>
                                        <?php } else{?>
                                            <button class="btn btn-xs btn-black payCheck paid-receipt" data-id="<?=$r['idx']?>" data-pay_method="<?=$r['o_paymethod']?>" data-tno="<?=$r['tno']?>" data-order_id="<?=$r['order_id']?>" data-amount="<?=$r['amount']?>">거래명세서</button>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if($r['req_cancel'] != 'Y' && in_array($r['pay_flag'] , ['Y','N'])) {?>
                                        <?php if($r['able_cancel'] == 'N'){?>
                                            <button class="btn btn-xs" onclick="alert('유료자료 열람 및 사용내역이 존재하여, 취소요청이 불가합니다.\n자세한 사항은 이용약관을 참고해주시기 바랍니다.')">취소요청</button>
                                        <?php } else if($r['able_cancel2'] == 'N'){?>
                                            <button class="btn btn-xs" onclick="alert('결제 후 7일이 지난 경우에는 취소요청이 불가합니다.\n자세한 사항은 이용약관을 참고해주시기 바랍니다.')">취소요청</button>
                                        <?php } else {?>
                                            <button class="btn btn-xs req_cancel" data-order_id="<?=$r['order_id']?>">취소요청</button>
                                        <?php }  ?>
                                    <?php } ?>

                                    <?php if(isTest()){


                                    }?>

                                    </div>
                                </td>
                            </tr>

                        <?php }?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>




<?=link_src_html('/css/layer_popup.css','css')?>
<?=link_src_html('/js/layer_popup.js','js')?>
<script type="text/javascript">

    const card_checkUrl = 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=#tno#&order_no=#order_id#&trade_mony=#amount#';
    const vcnt_checkUrl = 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=vcnt_bill&tno=#tno#&order_no=#order_id#&trade_mony=#amount#';
    const phone_checkUrl = 'https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=mcash_bill&tno=#tno#&order_no=#order_id#&trade_mony=#amount#';

    $(document).on('click','.receipt-submit',function(){
        var $receipt_name = $('input[name="receipt_name"]');
        if($receipt_name.val() == ''){
            alert('수신자이름을 입력해주세요!');
            return false;
        }

        var oData = $(this).data();
        $('#hiddenFrame').attr('src','/My/receipt?oid='+oData.id+'&receipt_name='+$receipt_name.val());
        __popup.close();
    });

    function view_cmc_receipt(oData){

        var html = '';
        html += '<div class="d-flex flex-column" style="width: 100%;">';
        html += '   <div class="form-floating mb-3">';
        html += '       <input type="text" class="form-control" style="border-radius: 0" id="floatingIdInput" name="receipt_name" inputmode="receipt_name" autocomplete="receipt_name" placeholder="수신자명" value="" required>';
        html += '       <label for="floatingIdInput">수신자명</label>';
        html += '   </div>';
        html += '   <button class="btn btn-black receipt-submit" data-id="'+oData.id+'">확인</button>';
        html += '</div>';

        __popup.init('거래명세서 수신',300,270);
        __popup.setMain(html);
        __popup.open();

        $('input[name="receipt_name"]').focus();

    }

    $(function(){

        $('.paid-receipt').on('click',function(){
            var oData = $(this).data();

            if( oData.pay_method === 'fixed_vacc' ){
                view_cmc_receipt(oData);
            }else{
                var obj = { 'tno' : oData.tno , 'order_id' : oData.order_id , 'amount' : oData.amount , 'pay_method' : oData.pay_method };
                getReceipt(obj);
            }

        })

        $('.card-receipt-other').on('click',function(){
            var oData = $(this).data();
            view_cmc_receipt(oData);
        });

        $('.req_cancel').on('click',function(){

            if(!confirm('해당 주문을 취소요청 하시겠습니까?')){
                return false;
            }
            var order_id = $(this).data('order_id');
            $.ajax({
                url: "/My/reqOrderCancel/",
                data: { _csrf : $('input[name="_csrf"]').val() , order_id : order_id },
                method: "post",
                dataType: "json",
                success: function (result) {
                    // console.log(result);
                    if(result.msg) alert(result.msg);
                    if(result.success) location.reload() ;
                }
            });
        });

        $('.viewVC').on('click',function(e){
            e.preventDefault();

            var bankacct    = $(this).data('bankacct');
            var deposit     = $(this).data('deposit');
            var vacc_limit  = $(this).data('vacc_limit');
            var bank        = $(this).data('bank');

            var html = '';
                html += '<div class="d-flex flex-column" style="width: 100%;">';
                html += '   <dl class="d-flex gap-3">';
                html += '       <dt style="width: 80px">입금은행</dt><dd>'+bank+'</dd>';
                html += '   </dl>';
                html += '   <dl class="d-flex gap-3">';
                html += '       <dt style="width: 80px">예금주</dt><dd>'+deposit+'</dd>';
                html += '   </dl>';
                html += '   <dl class="d-flex gap-3">';
                html += '       <dt style="width: 80px">계좌번호</dt><dd>'+bankacct+'</dd>';
                html += '   </dl>';
                html += '   <dl class="d-flex gap-3 mb-0">';
                html += '       <dt style="width: 80px">입금기한</dt><dd>'+vacc_limit+'</dd>';
                html += '   </dl>';
                html += '</div>';

            __popup.init('입금정보 보기',300,270);
            __popup.setMain(html);
            __popup.open();
        });
    });

    function getReceipt(obj){

        var url = '';
        if(obj.pay_method === 'vcnt')  url = vcnt_checkUrl.replace('#tno#' , obj.tno);
        else if(obj.pay_method === 'card')  url = card_checkUrl.replace('#tno#' , obj.tno);
        else if(obj.pay_method === 'phone')  url = phone_checkUrl.replace('#tno#' , obj.tno);
        else {
            alert('잘못된 결제 방식입니다.');
            return false;
        }

        url = url.replace('#order_id#' , obj.order_id);
        url = url.replace('#amount#' , obj.amount);

        win_open(url);

    }

</script>
