<?php

/**
 * @var object $aGoodInfo '상품정보'
 * @var array $aGoodList '구매가능 상품 리스트'
 * @var object $aUserInfo '회원정보'
 * @var string $order_id '주문번호'
 * @var string $site_code '결제 사이트코드'
 * @var string $site_name '사이트 명'
 * @var string $script_url 'kcp 스크립트 파일 URL'
 *
 */

list($celltel1,$celltel2,$celltel3) = ['','',''];
if($aUserInfo->cell_tel){
    list($celltel1,$celltel2,$celltel3)  = explode('-' , $aUserInfo->cell_tel);
}

$msg = session('message');
if($msg) alert_script($msg);

?>


<script type="text/javascript">
    /****************************************************************/
    /* m_Completepayment  설명                                      */
    /****************************************************************/
    /* 인증완료시 재귀 함수                                         */
    /* 해당 함수명은 절대 변경하면 안됩니다.                        */
    /* 해당 함수의 위치는 kcp_spay_hub.js 보다먼저 선언되어여 합니다.    */
    /* Web 방식의 경우 리턴 값이 form 으로 넘어옴                   */
    /****************************************************************/
    function m_Completepayment( FormOrJson, closeEvent )
    {
        var frm = document.upsertForm;

        /********************************************************************/
        /* FormOrJson은 가맹점 임의 활용 금지                               */
        /* frm 값에 FormOrJson 값이 설정 된 frm 값으로 활용 하셔야 됩니다.  */
        /********************************************************************/
        GetField( frm, FormOrJson );


        if( frm.res_cd.value == "0000" )
        {
            /* 결제인증 완료 후 결제승인 요청을 위한 비즈니스 로직 구현 */
            frm.submit();
        }
        else
        {
            /* 결제인증 실패에 대한 처리 */
            alert( "[" + frm.res_cd.value + "] " + frm.res_msg.value );
            closeEvent();
        }
    }
</script>
<?php
/*
?>
결제창 호출 JS
개발 : https://testspay.kcp.co.kr/plugin/kcp_spay_hub.js
운영 : https://spay.kcp.co.kr/plugin/kcp_spay_hub.js
*/
?>
<script type="text/javascript" src="<?=$script_url?>"></script>
<script type="text/javascript">

    /* 표준웹 실행 */
    function jsf__pay( form )
    {
        try
        {
            KCP_Pay_Execute_Web( form );
        }
        catch (e)
        {
            /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */
        }
    }
</script>
<main>
    <div class="container-fluid w-1560">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center">요금제</h1>
        </div>

        <div class="row mt-md-5 mt-3 gap-5">

            <div class="border payment-border-wrap col-10 offset-1 col-md-12 offset-md-0 shadow">

                <h4 class="border-bottom pb-3"><b>구매 전 확인해주세요!</b></h4>

                <ul class="my-3 my-md-5 payment-agree">
                    <li>연간 구독권은 구매한 시점부터 바로 적용됩니다.</li>
                    <li>결제 후 7일을 경과하거나 서비스 이용이력이 있는 경우 중도해지 및 이에 따른 환불이 불가능합니다.</li>
                    <li>신용카드 결제는 세금계산서가 발행되지 않으며, 카드 매출전표를 출력 할 수 있습니다.</li>
                    <li>매출전표는 내 정보 > 결제내역 조회에서 출력 할 수 있습니다.</li>
                </ul>

                <div class="main-checkbox">
                    <div class="round">
                        <input type="checkbox" name="agree1" id="agree1_yn" value="Y" title="" <?=old('agree1') == 'Y' ? 'checked':''?> />
                        <label for="agree1_yn"></label>
                    </div>
                    <label for="agree1_yn" class="d-none d-md-inline-block fw-normal zs-cp"><b>이용약관 및 안내 내용을 확인하였으며 상기 내용에 동의합니다.</b></label>
                    <label for="agree1_yn" class="d-inline-block d-md-none fw-normal"><b>이용약관 및 안내 내용을 확인하였으며 상기 내용에 동의</b></label>
                </div>

            </div>

            <div class="border payment-border-wrap col-10 offset-1 col-md-12 offset-md-0 shadow">

                <div class="accordion" id="order_info">
                    <div class="accordion-item border-0">
                        <h4 class="accordion-header d-flex justify-content-between border-0 mb-4" id="headingOne" >
                            <button class="fs-4 accordion-button border-0 border-bottom bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b>주문자 정보</b>
                            </button>
                        </h4>

                        <span class="fs-6">
                            <span class="main-checkbox sm pb-2 ps-3">
                                <span class="round">
                                    <input type="checkbox" name="same_info" id="same_info_yn" value="Y" title="" checked>
                                    <label for="same_info_yn"></label>
                                </span>
                                <label for="same_info_yn" class="d-inline-block fw-normal zs-cp">회원정보와 같음</label>
                            </span>
                        </span>

                        <div id="collapseOne" class="accordion-collapse collapse  " aria-labelledby="headingOne" data-bs-parent="#order_info">
                            <div class="accordion-body">
                                <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3">
                                    <dt style="width: 80px;"><label class="form-control-plaintext">주문자 명</label></dt>
                                    <dd><input type="text" value="<?=$aUserInfo->username?>" class="form-control" name="buyr_name" title=""></dd>
                                </dl>
                                <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3">
                                    <dt style="width: 80px;"><label class="form-control-plaintext">연락처</label></dt>
                                    <dd class="d-flex gap-3">
                                        <!--                                        <input type="text" class="form-control" name="buyr_tel2" title="">-->
                                        <input type="number" value="<?=$celltel1?>" class="form-control" maxlenthCheck maxlength="3" onkeyup="moveFocus(this,3,'floatingCell_tel2Input')" id="floatingCell_tel1Input" name="cell_tel1" inputmode="text" autocomplete="cell_tel1" placeholder="연락처" title="연락처1" required>
                                        <input type="number" value="<?=$celltel2?>" class="form-control" maxlenthCheck maxlength="4" onkeyup="moveFocus(this,4,'floatingCell_tel3Input')" id="floatingCell_tel2Input" name="cell_tel2" inputmode="text" autocomplete="cell_tel2" placeholder="연락처" title="연락처2" required>
                                        <input type="number" value="<?=$celltel3?>" class="form-control" maxlenthCheck maxlength="4" id="floatingCell_tel3Input" name="cell_tel3" inputmode="text" autocomplete="cell_tel3" placeholder="연락처" title="연락처3" required>
                                    </dd>
                                </dl>
                                <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 mb-0">
                                    <dt style="width: 80px;"><label class="form-control-plaintext">이메일</label></dt>
                                    <dd><input type="text" value="<?=$aUserInfo->user_email?>" class="form-control" name="buyr_mail" title=""></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //현금영수증 ?>

            <div class="border payment-border-wrap col-10 offset-1 col-md-12 offset-md-0 shadow vacct d-none flex-column">
                <h4 class="border-bottom pb-3"><b>세금계산서 정보</b></h4>

                <div class="d-flex flex-column mt-3">

                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3">
                        <dt style="width: 140px;"><label class="form-control-plaintext">발급 여부</label></dt>
                        <dd class="d-flex align-items-center m-0 gap-3" >
                            <span class="main-checkbox-ol sm ">
                                <span class="square">
                                    <input type="radio" name="cash_yn" id="cash_yn_Y" value="Y" title="">
                                    <label for="cash_yn_Y"></label>
                                </span>
                                <label for="cash_yn_Y" class="d-inline-block fw-normal zs-cp">발급</label>
                            </span>
                            <span class="main-checkbox-ol sm ">
                                <span class="square">
                                    <input type="radio" name="cash_yn" id="cash_yn_N" value="N" title="" checked>
                                    <label for="cash_yn_N"></label>
                                </span>
                                <label for="cash_yn_N" class="d-inline-block fw-normal zs-cp">발급안함</label>
                            </span>
                        </dd>
                    </dl>

                    <!--
                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash">
                        <dt style="width: 140px;"><label class="form-control-plaintext">발급용도</label></dt>
                        <dd class="d-flex align-items-center m-0 gap-3" >
                            <span class="main-checkbox-ol sm">
                                <span class="square">
                                    <input type="radio" name="tr_code" id="tr_code_1" value="1" title="" checked>
                                    <label for="tr_code_1"></label>
                                </span>
                                <label for="tr_code_1" class="d-flex fw-normal zs-cp gap-2 align-items-center">지출증빙용</label>
                                <i class="fa-regular fa-circle-question zs-cp" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                   data-bs-title="기업(사업자)이신 경우 선택이 가능합니다. (사업자번호)"></i>
                            </span>

                            <span class="main-checkbox-ol sm">
                                <span class="square">
                                    <input type="radio" name="tr_code" id="tr_code_0" value="0" title="">
                                    <label for="tr_code_0"></label>
                                </span>
                                <label for="tr_code_0" class="d-flex fw-normal zs-cp gap-2 align-items-center">소득공제용</label>
                                <i class="fa-regular fa-circle-question zs-cp" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                   data-bs-title="개인이신 경우 선택이 가능합니다.<br>(휴대폰번호)"></i>
                            </span>
                        </dd>
                    </dl>
                    -->

                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash">
                        <dt style="width: 140px;"><label class="form-control-plaintext">상호명</label></dt>
                        <dd class="d-flex align-items-center">
                            <input type="text" class="form-control" name="cash_name" />
                        </dd>
                    </dl>
                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash">
                        <dt style="width: 140px;"><label class="form-control-plaintext">대표자명</label></dt>
                        <dd class="d-flex align-items-center">
                            <input type="text" class="form-control" name="cash_ceo" />
                        </dd>
                    </dl>
                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash">
                        <dt style="width: 140px;"><label class="form-control-plaintext">이메일</label></dt>
                        <dd class="d-flex align-items-center">
                            <input type="email" class="form-control" name="cash_email" />
                        </dd>
                    </dl>

                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash">
                        <dt style="width: 140px;"><label class="form-control-plaintext">주소</label></dt>
                        <dd class="d-flex align-items-center flex-column gap-2">
                            <div class="input-group ">
                                <input type="text" class="form-control" name="cash_address" readonly />
                                <button class="btn btn-black searchAddr" type="button">검색</button>
                            </div>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" style="width: 65%" name="cash_address_detail" />
                                <input type="text" class="form-control" style="width: 35%" name="cash_address_extra" readonly />
                            </div>
                        </dd>
                    </dl>

                    <dl class="d-flex flex-column flex-md-row gap-1 gap-md-3 onCash tr_code_info" id="tr_code_1_info">
                        <dt style="width: 140px;"><label class="form-control-plaintext">사업자 등록번호</label></dt>
                        <dd class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2 tr_code_input-wrap"> <!-- 지출증빙 -->
                                <input type="text" class="form-control" maxlength="3" name="id_info_21" id="id_info_21" onkeyup="moveFocus(this,3,'id_info_22')" numberOnly />
                                -
                                <input type="text" class="form-control" maxlength="2" name="id_info_22" id="id_info_22" onkeyup="moveFocus(this,2,'id_info_23')" numberOnly />
                                -
                                <input type="text" class="form-control" maxlength="5" name="id_info_23" id="id_info_23" numberOnly />
                            </div>
                        </dd>
                    </dl>

                    <?php /*
                    <!--
                    <dl class="d-none flex-column flex-md-row gap-1 gap-md-3 onCash tr_code_info" id="tr_code_0_info">
                        <dt style="width: 140px;"><label class="form-control-plaintext">휴대폰 번호</label></dt>
                        <dd class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2 tr_code_input-wrap">
                                <input type="text" class="form-control" maxlength="3" name="id_info_11" id="id_info_11" onkeyup="moveFocus(this,3,'id_info_12')" numberOnly />
                                -
                                <input type="text" class="form-control" maxlength="4" name="id_info_12" id="id_info_12" onkeyup="moveFocus(this,4,'id_info_13')" numberOnly />
                                -
                                <input type="text" class="form-control" maxlength="4" name="id_info_13" id="id_info_13" numberOnly />
                            </div>
                        </dd>
                    </dl>
                    -->
                    */ ?>
                </div>
            </div>

            <?php
            /*기간선택
            <!--
            <div class="border payment-border-wrap col-10 offset-1 col-md-12 offset-md-0 shadow">
                <h4 class="border-bottom pb-3"><b>이용기간 선택</b></h4>
                <div class="d-flex gap-5 mt-4">
                <?php foreach ($aGoodList as $r) {?>
                    <span class="fs-6">
                        <span class="main-checkbox-ol sm pb-2 ps-3">
                            <span class="square">
                                <input type="radio" name="months" id="months<?=$r['good_id']?>" value="<?=$r['good_id']?>" title="" <?=$r['months'] == 12 ? 'checked' : ''?>>
                                <label for="months<?=$r['good_id']?>"></label>
                            </span>
                            <label for="months<?=$r['good_id']?>" class="d-inline-block fw-normal zs-cp"><?=$r['good_name']?></label>
                        </span>
                    </span>
                <?php } ?>
                </div>
            </div>
            -->
            */?>
            <div class="border payment-border-wrap payment-info col-10 offset-1 col-md-12 offset-md-0 shadow">

                <dl class="d-flex gap-2 gap-md-5 fs-4 border-bottom flex-md-row flex-column pb-2 pb-md-3">
                    <dt class="d-flex align-items-center">이용 기간</dt>
                    <dd class="d-flex gap-2 align-items-center">
                        <span class="setDate"></span>
                        <i class="fa-regular fa-circle-question zs-cp" style="color:#a69688" data-bs-toggle="tooltip" data-bs-placement="top"
                           data-bs-title="무통장입금에 경우 입금일에 따라 달라 질 수 있습니다."></i>
                    </dd>
                </dl>
                <dl class="d-flex gap-2 gap-md-5 fs-4 border-bottom flex-md-row flex-column pb-2 pb-md-3">
                    <dt>결제 구분</dt>
                    <dd class="d-flex flex-column _flex-md-row">
                        <span style="color:#a69688;font-weight: bold">연간 구독권 <span class="org-amount position-relative fs-5"></span> <span class="good-amount" style="color:var(--logo-red)"></span></span>
                        <p class="m-0 event-noti" style="color:var(--logo-red);"><i style="color:color:var(--logo-red);" class="fa-solid fa-triangle-exclamation"></i>&nbsp;이벤트 기간 동안만 할인된 금액으로 이용 가능하십니다.</p>
                    </dd>
                </dl>
                <dl class="d-flex flex-md-row flex-column gap-2 gap-md-5 fs-4 mt-3 mt-md-4 pt-md-2 w-100">
                    <dt>결제 수단</dt>
                    <dd class="flex-grow-1 mt-2 mt-md-0">

                        <ul class="payment-method-wrap d-flex flex-column flex-md-row  justify-content- mb-3 mb-md-5 gap-2 gap-md-5">

                            <li class="d-flex flex-row flex-md-column payment-method active" data-method="100000000000" data-src="card">
                                <div class="d-flex align-items-center icon-wrap">
                                    <i class="fa-regular fa-credit-card "></i>
                                </div>
                                <span class="payment-method-desc text-center d-flex align-items-center justify-content-center zs-cp"> 신용카드 결제 </span>
                            </li>

                            <li class="d-flex flex-row flex-md-column payment-method"  data-method="001000000000" data-src="bank">
                                <div class="d-flex align-items-center icon-wrap">
                                    <i class="fa-solid fa-won-sign"></i>
                                </div>
                                <span class="payment-method-desc text-center d-flex flex-column align-items-center justify-content-center zs-cp"> <span>가상계좌</span><span class="fs-7">(입금즉시 이용가능)</span> </span>
                            </li>

                            <li class="d-flex flex-row flex-md-column  payment-method" data-method="000000000009" data-src="bank">
                                <div class="d-flex align-items-center icon-wrap">
                                    <i class="fa-solid fa-won-sign"></i>
                                </div>
                                <span class="payment-method-desc text-center d-flex flex-column align-items-center justify-content-center zs-cp"> <span>고정계좌</span><span class="fs-7">(입금이후 1일 소요)</span> </span>
                            </li>
                            <!--
                                                        <li class="d-flex flex-row flex-md-column payment-method" data-method="000010000000" data-src="phone">
                                                            <div class="d-flex align-items-center icon-wrap">
                                                                <i class="fa-solid fa-mobile"></i>
                                                            </div>
                                                            <span class="payment-method-desc text-center d-flex flex-column align-items-center justify-content-center zs-cp "> <span>휴대폰</span> </span>
                                                        </li>
                            -->
                        </ul>

                        <div class="mt-5 d-flex justify-content-center">
                            <button type="button" class="btn btn-black complete" style="width: 120px;">결제</button>
                        </div>

                    </dd>
                </dl>
            </div>
        </div>
    </div>
</main>

<form id="upsertForm" name="upsertForm" method="post">

    <!-- 주문자정보  -->
    <input type="hidden" name="buyr_name" value="" />
    <input type="hidden" name="buyr_mail" value="" />
    <input type="hidden" name="buyr_tel2" value="" />

    <!-- 상품정보 -->
    <input type="hidden" name="ordr_idxx" value="<?=$order_id?>" />
    <input type="hidden" name="good_name" value="<?=$aGoodInfo->good_name?>" />
    <input type="hidden" name="good_mny"  value="<?=$aGoodInfo->good_amount?>"/>
    <input type="hidden" name="good_id"  value="<?=$aGoodInfo->good_id?>"/>

    <!-- 가맹점 정보 설정-->
    <input type="hidden" name="site_cd"         value="<?=$site_code?>" />
    <input type="hidden" name="site_name"       value="<?=$site_name?>" />
    <input type="hidden" name="pay_method"      value="100000000000" />

    <!-- 신용카드 설정 -->
    <input type="hidden" name="quotaopt"        value="12"/> <!-- 최대 할부개월수 -->
    <!--
        ※필수 항목
        결제인증 완료 후 결제창에서 값을 설정하는 부분으로 반드시 포함되어야 합니다.
        임의로 값을 설정하지 마십시오.
    -->
    <input type="hidden" name="res_cd"          value=""/>
    <input type="hidden" name="res_msg"         value=""/>
    <input type="hidden" name="enc_info"        value=""/>
    <input type="hidden" name="enc_data"        value=""/>
    <input type="hidden" name="tran_cd"         value=""/>
    <!-- 필수 항목 : 결제 금액/화폐단위 -->
    <input type='hidden' name='currency'        value='410'>

    <!-- 추가정보 -->
    <input type="hidden" name="o_paymethod"      value="" />

    <!-- 세금계산서 관련 -->
    <input type="hidden" name="cash_yn"      value="" />
    <input type="hidden" name="cash_receipt"      value="" />
    <input type="hidden" name="cash_name"      value="" />
    <input type="hidden" name="cash_ceo"      value="" />
    <input type="hidden" name="cash_email"      value="" />
    <input type="hidden" name="cash_address"      value="" />
    <input type="hidden" name="id_info"      value="" />
    <!--    <input type="hidden" name="id_info_2"      value="" />-->
    <!--    <input type="hidden" name="id_info_3"      value="" />-->

</form>

<form id="upsertFormMobile" name="upsertFormMobile" method="post" action="/Payment/m_step1">
    <!-- 주문 정보-->
    <input type="hidden" name="ordr_idxx" value="<?=$order_id?>" />

    <!-- 주문자정보  -->
    <input type="hidden" name="buyr_name" value="" />
    <input type="hidden" name="buyr_mail" value="" />
    <input type="hidden" name="buyr_tel2" value="" />

    <!-- 상품정보 -->
    <input type="hidden" name="good_name" value="<?=$aGoodInfo->good_name?>" />
    <input type="hidden" name="good_mny" value="<?=$aGoodInfo->good_amount?>" />
    <input type="hidden" name="good_id" value="<?=$aGoodInfo->good_id?>" />

    <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
    <input type="hidden"   name="Ret_URL"         value="<?=base_url('/Payment/m_step2')?>" />
    <input type="hidden"   name="user_agent"      value="" /> <!--사용 OS-->
    <input type="hidden"   name="site_cd"         value="<?=$site_code?>" /> <!--사이트코드-->
    <!-- 인증시 필요한 파라미터(변경불가)-->
    <input type="hidden" name="pay_method"      value="100000000000">
    <input type="hidden" name="van_code"        value="">
    <!-- 추가정보 -->
    <input type="hidden" name="o_paymethod"      value="" />
    <!-- 세금계산서 관련 -->
    <input type="hidden" name="cash_yn"      value="" />
    <input type="hidden" name="cash_receipt"      value="" />
    <input type="hidden" name="cash_name"      value="" />
    <input type="hidden" name="cash_ceo"      value="" />
    <input type="hidden" name="cash_email"      value="" />
    <input type="hidden" name="cash_address"      value="" />
    <input type="hidden" name="id_info"      value="" />
    <!--    <input type="hidden" name="id_info_2"      value="" />-->
    <!--    <input type="hidden" name="id_info_3"      value="" />-->
</form>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<?=link_src_html('/js/bootstrap.bundle.js','js')?>

<script type="text/javascript">

    $(function(){
        //tooltip 초기화
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        //주소검색
        $('.searchAddr').on('click',function(){

            new daum.Postcode({
                oncomplete: function(data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var addr = ''; // 주소 변수
                    var extraAddr = ''; // 참고항목 변수

                    //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                        addr = data.roadAddress;
                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                        addr = data.jibunAddress;
                    }

                    // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                    if(data.userSelectedType === 'R'){
                        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                        if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                            extraAddr += data.bname;
                        }
                        // 건물명이 있고, 공동주택일 경우 추가한다.
                        if(data.buildingName !== '' && data.apartment === 'Y'){
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                        if(extraAddr !== ''){
                            extraAddr = ' (' + extraAddr + ')';
                        }
                        $('input[name="cash_address_extra"]').val(extraAddr);

                    }

                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    $('input[name="cash_address"]').val(addr);
                    // 커서를 상세주소 필드로 이동한다.
                    $('input[name="cash_address_detail"]').focus();
                }
            }).open();

        });

        $('.payment-method').on('click',function(e){

            e.preventDefault();

            $('.payment-method').removeClass('active');
            $(this).addClass('active');
            var method = $(this).data('method');
            var $vacct = $('.vacct');
            var curr_cash_val = $vacct.find('input[name="cash_yn"]:checked').val();


            $vacct.find('input[name="cash_yn"][value="N"]').click().trigger('click');
            $vacct.addClass('d-none');

            if( method === '001000000000' || method === '000000000009'){

                if(curr_cash_val === 'N'){
                    $vacct.find('input').each(function(){
                        if( $(this).attr('type') === 'text' || $(this).attr('type') === 'email' ) $(this).val('');
                    });
                }

                $vacct.removeClass('d-none');
                $vacct.find('input[name="cash_yn"][value="Y"]').click().trigger('click');

                var vacct_top = $('.vacct').offset().top-20;
                $(window).scrollTop(vacct_top);

            }

            $('#upsertForm input[name="pay_method"]').val(method);
            $('#upsertFormMobile input[name="pay_method"]').val(method);

        });

        $('input[name="same_info"]').on('click',function(e){
            var $accordion_button = $('.accordion-button');
            if( $(this).prop('checked') === false && $accordion_button.hasClass('collapsed') === true ){//열림
                $accordion_button.click();

                $('input[name="buyr_name"]').val('');
                $('input[name="cell_tel1"]').val('');
                $('input[name="cell_tel2"]').val('');
                $('input[name="cell_tel3"]').val('');
                $('input[name="buyr_mail"]').val('');

            }else if($(this).prop('checked') === true && $accordion_button.hasClass('collapsed') === false){ //닫힘
                $accordion_button.click();
                $.ajax({
                    url: "/myInfo",
                    data: { _csrf : $('input[name="_csrf"]').val() },
                    method: "post",
                    dataType: "json",
                    success: function (result) {
                        var aCelltel = result.data.cell_tel.split('-');
                        $('input[name="buyr_name"]').val(result.data.username);
                        $('input[name="cell_tel1"]').val(aCelltel[0]);
                        $('input[name="cell_tel2"]').val(aCelltel[1]);
                        $('input[name="cell_tel3"]').val(aCelltel[2]);
                        $('input[name="buyr_mail"]').val(result.data.user_email);
                    }
                });
            }
        });

        $('input[name="cash_yn"]').on('click',function(){
            if( $(this).val() === 'Y' ) $('.onCash').removeClass('d-none').addClass('d-flex');
            else $('.onCash').addClass('d-none').removeClass('d-flex');
        });

        $('.complete').on('click',function(e){
            e.preventDefault();

            //setData
            setData('m');
            setData('p');

            var $form = $('form[name="upsertForm"]'); // PC
            //defined upsertForm
            if(check_mobile()) { //모바일
                $form = $('form[name="upsertFormMobile"]');
            }

            /* validation */
            var $agree1_yn = $('#agree1_yn');
            if($agree1_yn.prop('checked') === false){
                alert('약관에 동의해주세요!');
                $(window).scrollTop(0);
                return false;
            }

            var $vacct = $('.vacct');

            if( $form.find('input[name="cash_yn"]').val() === 'Y' ) { //세금계산서 발급요청

                if($form.find('input[name="cash_name"]').val() === ''){
                    alert('상호명을 입력해주세요');
                    $vacct.find('input[name="cash_name"]').focus();
                    return false;
                }

                if($form.find('input[name="cash_ceo"]').val() === ''){
                    alert('대표자명을 입력해주세요');
                    $vacct.find('input[name="cash_ceo"]').focus();
                    return false;
                }

                if( isEmail($form.find('input[name="cash_email"]').val()) === false ){
                    alert('이메일을 확인해주세요');
                    $vacct.find('input[name="cash_email"]').focus();
                    return false;
                }

                if(     $vacct.find('input[name="cash_address"]').val() === ''
                    ||  $vacct.find('input[name="cash_address_detail"]').val() === ''
                    ||  $form.find('input[name="cash_address"]').val() === ''
                ){
                    alert('주소를 확인해주세요');
                    return false;
                }

                var id_num = $form.find('input[name="id_info"]').val();
                if( isCorporateRegiNo(id_num) === false || id_num === '--' || id_num === '' ){
                    alert('사업자 번호를 확인해주세요');
                    $vacct.find('input[name="id_info_21"]').focus();
                    return false;
                }

            }
            /* end of validation */

            if(check_mobile()) pay_process_mobile(); //모바일
            else pay_process_pc(); //PC

        });

        getGoodInfo();
        $('input[name="months"]').on('change',getGoodInfo);

    });



    function getGoodInfo(){
        $.ajax({
            type: 'post',
            url: '/Payment/getGoodInfo',
            <?php /*data: {good_id : $('input[name="months"]:checked').val()},*/ ?>
            data: {good_id : 1},
            dataType: 'json',
            success: function(result){
                if(result.msg) alert(result.msg);
                if(result.success) setInfo(result.data);
                else location.reload();
            }
        });
    }

    function setInfo(data){
        if($('.payment-info').length > 0 ){
            //기간
            $('.payment-info .setDate').html(data.set_s_use_date + ' ~ ' +data.set_e_use_date);
            //원 판매금액
            $('.payment-info .org-amount').html(data.org_amount_str+'원');
            //월별금액
            //$('.payment-info .amount-per-month').html('(월 '+data.amount_per_month+'원)');
            //결제 금액
            $('.payment-info .good-amount').html(data.amount+'원');
        }
    }

    function setData(t){

        //defined upsertForm
        var $form = $('form[name="upsertForm"]'); // def pc
        if(t === 'm') $form = $('form[name="upsertFormMobile"]'); //모바일

        //일반정보
        var method = $form.find('input[name="pay_method"]').val();
        $form.find('input[name="buyr_name"]').val($('main input[name="buyr_name"]').val());
        $form.find('input[name="buyr_mail"]').val($('main input[name="buyr_mail"]').val());
        $form.find('input[name="buyr_tel2"]').val($('main input[name="cell_tel1"]').val()+'-'+$('main input[name="cell_tel2"]').val()+'-'+$('main input[name="cell_tel3"]').val());
        $form.find('input[name="o_paymethod"]').val(getPayMethodString(method));

        //세금계산서정보
        $vacct = $('.vacct');
        if($vacct.find('input[name="cash_yn"]:checked').val() === 'Y'){
            $form.find('input[name="cash_yn"]').val( $vacct.find('input[name="cash_yn"]:checked').val() );
            $form.find('input[name="cash_receipt"]').val( $vacct.find('input[name="cash_yn"]:checked').val() );
            $form.find('input[name="cash_name"]').val( $vacct.find('input[name="cash_name"]').val() );
            $form.find('input[name="cash_ceo"]').val( $vacct.find('input[name="cash_ceo"]').val() );
            $form.find('input[name="cash_email"]').val( $vacct.find('input[name="cash_email"]').val() );
            $form.find('input[name="cash_address"]').val( $vacct.find('input[name="cash_address"]').val() +' '+ $vacct.find('input[name="cash_address_detail"]').val() + $vacct.find('input[name="cash_address_extra"]').val() );
            $form.find('input[name="id_info"]').val( $vacct.find('input[name="id_info_21"]').val() + '-'+ $vacct.find('input[name="id_info_22"]').val() +'-'+ $vacct.find('input[name="id_info_23"]').val() );
        }else{
            $form.find('input[name="cash_yn"]').val('N');
            $form.find('input[name="cash_receipt"]').val('N');
            $form.find('input[name="cash_name"]').val('');
            $form.find('input[name="cash_ceo"]').val('');
            $form.find('input[name="cash_email"]').val('');
            $form.find('input[name="cash_address"]').val('');
            $form.find('input[name="id_info"]').val('');
        }

    }

    function pay_process_mobile(){
        var $upsertFormMobile = $('#upsertFormMobile');
        $upsertFormMobile.attr('action' , '/Payment/m_step1');
        $upsertFormMobile.submit();
    }

    function getPayMethodString(method){
        var o_paymethod = 'card';
        if(method === '001000000000') o_paymethod = 'vcnt';
        else if(method === '000010000000') o_paymethod = 'phone';
        else if(method === '000000000009') o_paymethod = 'fixed_vacc';

        return o_paymethod;
    }

    function pay_process_pc(){
        var $upsertForm = $('#upsertForm');
        var method = $upsertForm.find('input[name="pay_method"]').val();
        $upsertForm.attr('action' , '/Payment/process');

        if(method === '000000000009') $upsertForm.submit();
        else jsf__pay(document.upsertForm);

    }

</script>