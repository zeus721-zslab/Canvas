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
        }
        /* 결제인증 완료 후 결제승인 요청을 위한 비즈니스 로직 구현 */
        if (pay_form.enc_info.value)
            pay_form.submit();
    }

    $(chk_pay);

</script>

<script type="text/javascript">

    function goReq()
    {
        <?php
        // 거래등록 처리 정상
        if ( $aInput['res_cd'] == "0000" )
        {
        ?>
        // alert("거래등록 성공");
        document.form_trade_reg.action = "/Payment/m_step2";
        document.form_trade_reg.submit();
        <?php
        }

        // 거래등록 처리 실패, 여기(샘플)에서는 trade_reg page로 리턴 합니다.
        else
        {
        ?>
        alert("에러 코드 : <?=$aInput['res_cd']?>, 에러 메세지 : <?=$aInput['res_msg']?>");
        location.href = "<?=route_to('/Payment/upsertForm')?>";
        <?php
        }
        ?>
    }

    $(goReq);

</script>
<div class="wrap">
    <!--  거래등록 form : form_trade_reg -->
    <form name="form_trade_reg" method="post">
        <input type="hidden" name="site_cd"         value="<?=$aInput['site_cd'] ?>" />  <!-- 사이트 코드 -->
        <input type="hidden" name="ordr_idxx"       value="<?=$aInput['ordr_idxx'] ?>" /><!-- 주문번호     -->
        <input type="hidden" name="good_id"        value="<?=$aInput['good_id'] ?>" /> <!-- 결제금액     -->
        <input type="hidden" name="good_mny"        value="<?=$aInput['good_mny'] ?>" /> <!-- 결제금액     -->
        <input type="hidden" name="good_name"       value="<?=$aInput['good_name']?>" /><!-- 상품명        -->
        <!-- 인증시 필요한 파라미터(변경불가)-->
        <input type="hidden" name="o_paymethod"      value="<?=$aInput['o_paymethod'] ?>" />
        <input type="hidden" name="ActionResult"    value="<?=$aInput['actionResult'] ?>" />
        <input type="hidden" name="van_code"        value="<?=$aInput['van_code'] ?>" />
        <!-- 리턴 URL (kcp와 통신후 결제를 요청할 수 있는 암호화 데이터를 전송 받을 가맹점의 주문페이지 URL) -->
        <input type="hidden" name="Ret_URL"         value="<?=$aInput['Ret_URL'] ?>" />
        <!-- 거래등록 응답 값 -->
        <input type="hidden" name="approvalKey"     value="<?=$aInput['approvalKey'] ?>" />
        <input type="hidden" name="traceNo"         value="<?=$aInput['traceNo'] ?>" />
        <input type="hidden" name="PayUrl"          value="<?=$aInput['PayUrl'] ?>" />
        <!-- 주문자 정보 -->
        <input type="hidden" name="buyr_name"     value="<?=$aInput['o_name'] ?>" />
        <input type="hidden" name="buyr_mail"         value="<?=$aInput['o_email'] ?>" />
        <input type="hidden" name="buyr_tel2"          value="<?=$aInput['o_celltel'] ?>" />
    </form>
</div>
<!--//wrap-->