<?php

/**
 * @var array $aInput '입력정보'
 * */
?>

<script type="text/javascript">
    /* kcp web 결제창 호츨 (변경불가) */
    function call_pay_form()
    {
        var v_frm = document.order_info;
        var PayUrl = v_frm.PayUrl.value;
        // 인코딩 방식에 따른 변경 -- Start
        if(v_frm.encoding_trans == undefined)
        {
            v_frm.action = PayUrl;
        }
        else
        {
            // encoding_trans "UTF-8" 인 경우
            if(v_frm.encoding_trans.value == "UTF-8")
            {
                v_frm.action = PayUrl.substring(0,PayUrl.lastIndexOf("/"))  + "/jsp/encodingFilter/encodingFilter.jsp";
                v_frm.PayUrl.value = PayUrl;
            }
            else
            {
                v_frm.action = PayUrl;
            }
        }

        if (v_frm.Ret_URL.value == "")
        {
            /* Ret_URL값은 현 페이지의 URL 입니다. */
            alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");
            location.href = "/Payment/upsertForm";
            return false;
        }
        else
        {
            v_frm.submit();
        }
    }

    /* kcp 통신을 통해 받은 암호화 정보 체크 후 결제 요청 (변경불가) */
    function chk_pay()
    {
        self.name = "tar_opener";
        var pay_form = document.pay_form;

        if (pay_form.res_cd.value != "" )
        {
            if (pay_form.res_cd.value != "0000" )
            {
                if (pay_form.res_cd.value == "3001")
                {
                    alert("사용자가 취소하였습니다.");
                }
                pay_form.res_cd.value = "";
                location.href = "/Payment/upsertForm"; // 샘플에서는 거래등록 페이지로 이동
            }
        }else{
            call_pay_form();
        }
        /* 결제인증 완료 후 결제승인 요청을 위한 비즈니스 로직 구현 */
        if (pay_form.enc_info.value)
            pay_form.submit();
    }

    $(chk_pay);

</script>


<div class="wrap d-none">

    <!-- 주문정보 입력 form : order_info -->
    <form name="order_info" method="post">
        <!-- header -->
        <div class="header">
            <a href="/Payment/upsertForm" class="btn-back"><span>뒤로가기</span></a>
            <h1 class="title">주문/결제</h1>
        </div>
        <!-- //header -->
        <!-- contents -->
        <div id="skipCont" class="contents">
            <p class="txt-type-1">이 페이지는 거래등록 완료 후 주문 요청하는 샘플 페이지입니다.</p>
            <p class="txt-type-2">소스 수정 시 [※ 필수] 또는 [※ 옵션] 표시가 포함된 문장은 가맹점의 상황에 맞게 적절히 수정 적용하시기 바랍니다.</p>
            <!--
                ==================================================================
                    1. 주문정보 입력
                ------------------------------------------------------------------
                                  결제에 필요한 주문 정보를 입력 및 설정합니다.
                ------------------------------------------------------------------
            -->
            <!-- 주문정보 -->
            <h2 class="title-type-3">주문정보</h2>
            <ul class="list-type-1">
                <!-- 주문번호(ordr_idxx) -->
                <li>
                    <div class="left"><p class="title">주문번호</p></div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="ordr_idxx" value="<?=$aInput['ordr_idxx']?>" maxlength="40" readonly />
                        </div>
                    </div>
                </li>
                <!-- 상품명(good_name) -->
                <li>
                    <div class="left"><p class="title">상품명</p></div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="good_name" value="<?=$aInput['good_name'] ?>" readonly />
                        </div>
                    </div>
                </li>
                <!-- 결제금액(good_mny) - ※ 필수 : 값 설정시 ,(콤마)를 제외한 숫자만 입력하여 주십시오. -->
                <li>
                    <div class="left"><p class="title">상품금액</p></div>
                    <div class="right">
                        <div class="ipt-type-1 gap-2 pc-wd-2">
                            <input type="text" name="good_mny" value="<?=$aInput['good_mny'] ?>" maxlength="9" readonly />
                            <span class="txt-price">원</span>
                        </div>
                    </div>
                </li>
                <!-- 주문자명(buyr_name) -->
                <li>
                    <div class="left"><p class="title">주문자명</p></div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="buyr_name" value="<?=$aInput['buyr_name']?>" />
                        </div>
                    </div>
                </li>
                <!-- 휴대폰번호(buyr_tel2) -->
                <li>
                    <div class="left"><p class="title">휴대폰번호</p></div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="buyr_tel2" value="<?=$aInput['buyr_tel2']?>" />
                        </div>
                    </div>
                </li>
                <!-- 주문자 E-mail(buyr_mail) -->
                <li>
                    <div class="left"><p class="title">이메일</p></div>
                    <div class="right">
                        <div class="ipt-type-1 pc-wd-2">
                            <input type="text" name="buyr_mail" value="<?=$aInput['buyr_mail']?>" />
                        </div>
                    </div>
                </li>
            </ul>
            <div Class="Line-Type-1"></div>
            <ul class="list-btn-2">
                <li class="pc-only-show"><a href=/Payment/upsertForm" class="btn-type-3 pc-wd-2">뒤로</a></li>
                <li><a href="#none" onclick="call_pay_form();" class="btn-type-2 pc-wd-3">결제요청</a></li>
            </ul>
        </div>
        <!-- //contents -->

        <!-- footer -->
        <div class="grid-footer">
            <div class="inner">
                <div class="footer">
                    ⓒ NHN KCP Corp.
                </div>
            </div>
        </div>
        <!--//footer-->
        <!-- 공통정보 -->
        <input type="hidden" name="req_tx"          value="pay" />              <!-- 요청 구분 -->
        <input type="hidden" name="shop_name"       value="<?=config('App')->site_name?>>" />        <!-- 사이트 이름 -->
        <input type="hidden" name="site_cd"         value="<?=$aInput['site_cd'] ?>" />    <!-- 사이트 코드 -->
        <input type="hidden" name="currency"        value="410"/>               <!-- 통화 코드 -->
        <!-- 인증시 필요한 파라미터(변경불가)-->
        <input type="hidden" name="escw_used"       value="N" />
        <input type="hidden" name="pay_method"      value="<?=isset($aInput['o_paymethod'])?strtoupper($aInput['o_paymethod']):'' ?>" />
        <input type="hidden" name="ActionResult"    value="<?=isset($aInput['ActionResult'])?$aInput['ActionResult']:'' ?>" />
        <input type="hidden" name="van_code"        value="<?=isset($aInput['van_code'])?$aInput['van_code']:'' ?>" />
        <!-- 신용카드 설정 -->
        <input type="hidden" name="quotaopt"        value="12"/> <!-- 최대 할부개월수 -->
        <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
        <input type="hidden" name="Ret_URL"         value="<?=$aInput['Ret_URL'] ?>" />
        <!-- 화면 크기조정 -->
        <input type="hidden" name="tablet_size"     value="1.0 " />
        <!-- 추가 파라미터 ( 가맹점에서 별도의 값전달시 param_opt 를 사용하여 값 전달 ) -->
        <input type="hidden" name="param_opt_1"     value="<?=isset($aInput['good_id'])?$aInput['good_id']:''?>" />
        <input type="hidden" name="param_opt_2"     value="<?=isset($aInput['o_paymethod'])?$aInput['o_paymethod']:''?>" />
        <input type="hidden" name="param_opt_3"     value="" />
        <!-- 거래등록 응답값 -->
        <input type="hidden" name="approval_key" id="approval" value="<?=isset($aInput['approvalKey'])?$aInput['approvalKey']:''?>"/>
        <input type="hidden" name="traceNo"                    value="<?=isset($aInput['traceNo'])? $aInput['traceNo'] : ''?>" />
        <input type="hidden" name="PayUrl"                     value="<?=isset($aInput['PayUrl'])? $aInput['PayUrl'] : ''?>" />
        <!-- 인증창 호출 시 한글깨질 경우 encoding 처리 추가 (**인코딩 네임은 대문자) -->
        <input type="hidden" name="encoding_trans" value="UTF-8" />
    </form>
</div>
<form name="pay_form" method="post" action="/Payment/process">
    <input type="hidden" name="req_tx"         value="<?=isset($aInput['req_tx'])? $aInput['req_tx']:'' ?>" />               <!-- 요청 구분          -->
    <input type="hidden" name="res_cd"         value="<?=isset($aInput['res_cd']) ? $aInput['res_cd']:''?>" />               <!-- 결과 코드          -->
    <input type="hidden" name="site_cd"        value="<?=isset($aInput['site_cd'])? $aInput['site_cd']:''?>" />              <!-- 사이트 코드      -->
    <input type="hidden" name="tran_cd"        value="<?=isset($aInput['tran_cd']) ? $aInput['tran_cd']:''?>" />              <!-- 트랜잭션 코드      -->
    <input type="hidden" name="ordr_idxx"      value="<?=isset($aInput['ordr_idxx'])? $aInput['ordr_idxx']:''?>" />            <!-- 주문번호           -->
    <input type="hidden" name="good_mny"       value="<?=isset($aInput['good_mny']) ? $aInput['good_mny']:''?>" />             <!-- 결제금액    -->
    <input type="hidden" name="good_name"      value="<?=isset($aInput['good_name'])? $aInput['good_name']:''?>" />            <!-- 상품명             -->
    <input type="hidden" name="buyr_name"      value="<?=isset($aInput['buyr_name']) ? $aInput['buyr_name']:''?>" />            <!-- 주문자명           -->
    <input type="hidden" name="buyr_tel2"      value="<?=isset($aInput['buyr_tel2']) ? $aInput['buyr_tel2']:''?>" />            <!-- 주문자 휴대폰번호  -->
    <input type="hidden" name="buyr_mail"      value="<?=isset($aInput['buyr_mail']) ? $aInput['buyr_mail']:''?>" />            <!-- 주문자 E-mail      -->
    <input type="hidden" name="enc_info"       value="<?=isset($aInput['enc_info']) ? $aInput['enc_info']:''?>" />
    <input type="hidden" name="enc_data"       value="<?=isset($aInput['enc_data']) ? $aInput['enc_data']:''?>" />
    <!-- 추가 파라미터 -->
    <input type="hidden" name="param_opt_1"    value="<?=isset($aInput['param_opt_1']) ? $aInput['param_opt_1']:''?>" />
    <input type="hidden" name="param_opt_2"    value="<?=isset($aInput['param_opt_2']) ? $aInput['param_opt_2']:''?>" />
    <input type="hidden" name="param_opt_3"    value="<?=isset($aInput['param_opt_3']) ? $aInput['param_opt_3']:''?>" />

    <input type="hidden" name="pay_method"    value="<?=isset($aInput['pay_method']) ? $aInput['pay_method']:''?>" />

    <input type="hidden" name="cash_yn"     value="" />
    <input type="hidden" name="cash_name"         value="" />
    <input type="hidden" name="cash_ceo"          value="" />
    <input type="hidden" name="cash_email"     value="" />
    <input type="hidden" name="cash_address"         value="" />
    <input type="hidden" name="cash_no"          value="" />
</form>
<!--//wrap-->