<?php
/**
 * @var numeric $id 'id'
 **/

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>위하고 아이디로 로그인</title>
    <script type="text/javascript" src="https://static.wehago.com/support/jquery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://static.wehago.com/support/wehagoLogin-1.1.4.min.js" charset="utf-8"></script>
    <!--  wehago_globals  -->
    <?=link_src_html('/js/wehago_globals.js' , 'js')?>

</head>
<body>

<div style="width: 600px; margin: 200px auto 0; padding: 50px; border: 1px solid #9297a4;">
    <h1>위하고 아이디로 로그인</h1>

    <!-- 위하고 아이디로 로그인 버튼 노출 영역 -->
    <div id="wehago_id_login"></div>
    <!-- // 위하고 아이디로 로그인 버튼 노출 영역 -->
    <script type="text/javascript">
        var wehago_id_login = new wehago_id_login({
            app_key: keyInfo.app_key,  // AppKey
            service_code: keyInfo.service_code,  // ServiceCode
            redirect_uri: 'https://kca.kindercanvas.co.kr/Wehago/invoicePop?id='+<?=$id?>,  // Callback URL
            mode: keyInfo.mode,  // dev-개발, live-운영 (기본값=live, 운영 반영시 생략 가능합니다.)
        });

        var state = wehago_id_login.getUniqState();
        wehago_id_login.setButton("white", 1, 40);
        wehago_id_login.setDomain(".wehago.com");
        wehago_id_login.setState(state);
        wehago_id_login.setPopup();  // 위하고 로그인페이지를 팝업으로 띄울경우

        wehago_id_login.init_wehago_id_login();

        setTimeout(function(){
            $('#wehago_id_login a').click().trigger('click');
        },500);

    </script>

</div>

</body>
</html>