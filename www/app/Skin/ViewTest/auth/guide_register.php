<?php

/**
 * @var string $NAVER_REQUEST_URL '네이버로그인 URL'
 * @var string $KAKAO_REQUEST_URL '카카오로그인 URL'
 */

?>
<style>
    .char-wrap span:nth-child(1){width: 38%;}
    .char-wrap span:nth-child(2){width: 38%;}
    .char-wrap span:nth-child(3){width: 24%;}
</style>

<div class="container d-flex justify-content-center py-5 px-md-5">

    <div class="card col-11 col-md-6 border-0 ">
        <div class="card-body">

            <div class="main-title border-bottom">
                <a href="/" class="d-flex justify-content-center mb-3"><img src="/img/kinder_logo.png" alt="" style="width: 60%; "/></a>
                <p class="text-center m-0">킨더캔버스를 방문해 주셔서 감사합니다.</p>
                <p class="text-center">회원가입을 통해 편리한 이용과<br>다양한 혜택을 받아보세요.</p>
            </div>

            <div class="d-flex col-12 col-md-8 mx-auto m-3 flex-column py-4">
                <div class="d-flex char-wrap gap-3">
                    <span><img src="/img/char3.png" alt=""  style="width: 100%;" /></span>
                    <span><img src="/img/char1.png" alt=""  style="width: 100%;" /></span>
                    <span><img src="/img/char2.png" alt=""  style="width: 100%;" /></span>
                </div>
            </div>
            <div class="d-flex col-12 col-md-8 mx-auto m-3 flex-column gap-3 pb-4">
                <a role="button" class="btn btn-lightgray btn-block" href="<?=route_to('register')?>">킨더 캔버스 가입하기</a>
                <a role="button" class="btn btn-gray btn-block goCmcSync">꼬망세 회원 연동하기</a>
            </div>

            <div class="d-flex col-12 col-md-8 mx-auto m-3 gap-3 justify-content-between">
                <span class="mid-line d-flex align-items-center w-25">
                    <span class="line border-top border-bottom w-100"></span>
                </span>
                <span style="opacity: .5">SNS 간편 로그인</span>
                <span class="mid-line d-flex align-items-center w-25">
                    <span class="line border-top border-bottom w-100"></span>
                </span>
            </div>

            <div class="col-12 col-md-8 mx-auto row justify-content-between">
                <div class="d-flex justify-content-center align-items-center p-0" style="width: 48%;"> <a class="d-inline-block w-100" href="<?=$NAVER_REQUEST_URL?>"><img src="/images/sns_login/naver_login.png?t" alt="네이버로그인" class="w-100"/></a> </div>
                <div class="d-flex justify-content-center align-items-center p-0" style="width: 48%;"> <a class="d-inline-block w-100" href="<?=$KAKAO_REQUEST_URL?>"><img src="/images/sns_login/kakao_login.png?t" alt="카카오로그인"  class="w-100"/></a> </div>
            </div>

        </div>
    </div>
</div>

<!-- jquery   -->
<?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>

<script type="text/javascript">
    $(function(){
        $('.goCmcSync').on('click',function(){
            win_open('https://www.edupre.co.kr/api/kindercanvas/cmc_sync.php')
        })
    })
</script>
