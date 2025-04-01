<?php
/**
 * @var object $user '회원세션 정보'
 *
 **/

/**
 * @date 240628
 * @modify 황기석
 * @desc redirect로 이동시 session error 데이터를 전달
 */
$alert_msg = '';
if (is_array(session('errors'))) :
    foreach (session('errors') as $error) :
        $alert_msg .= $error."\n";
    endforeach;
else :
    $alert_msg = session('error');
endif;

if($alert_msg) alert_script($alert_msg);
?>

<footer class="border-top">

    <!-- for MOBILE -->
    <div class="container-fluid d-flex d-lg-none flex-column flex-lg-row w-1560 w-100 gap-5 justify-content-evenly mb-5">
        <div class="d-flex flex-column align-items-center">
            <a href="#" class="d-block pt-3 pb-4"><img src="/img/kinder_logo_bw.png" style="width: 240px;" /></a>

            <div class="d-flex flex-column gap-1 align-items-center">
                <div class="d-flex gap-3">
                    <dl class="d-flex gap-1 mb-0">
                        <dt>사업자등록번호</dt>
                        <dd>105-81-01773</dd>
                    </dl>

                    <dl class="d-flex gap-1 mb-0">
                        <dt>업체명</dt>
                        <dd>(주)꼬망세미디어</dd>
                    </dl>
                </div>

                <div class="d-flex gap-3">
                    <dl class="d-flex gap-1 mb-0">
                        <dt>대표</dt>
                        <dd>최남호</dd>
                    </dl>
                    <dl class="d-flex gap-1 mb-0">
                        <dt>통신판매업신고</dt>
                        <dd>제 2023-서울강남-01170호</dd>
                    </dl>
                </div>

                <dl class="d-flex gap-1 mb-0">
                    <dt>주소</dt>
                    <dd>(06224) 서울 강남구 논현로 76길 27<br>(역삼동, 에이포스페이스빌딩) 5층</dd>
                </dl>

                <div class="d-flex gap-3">
                    <dl class="d-flex gap-1 mb-0">
                        <dt>개인정보관리책임자</dt>
                        <dd>최훈</dd>
                    </dl>
                    <dl class="d-flex gap-1 mb-0">
                        <dt>메일</dt>
                        <dd>web@edupre.co.kr</dd>
                    </dl>
                </div>

                <ul class="d-flex justify-content-center gap-3 mb-3">


                    <li><a href="<?=route_to('termOfUs')?>">이용약관</a></li>
                    <li><a href="<?=route_to('privacy')?>">개인정보 처리방침</a></li>
                </ul>

                <div class="d-flex gap-2 justify-content-evenly w-100">
                    <dl class="d-flex flex-column gap-1 mb-0 align-items-center w-50">
                        <dt class="fs-6"><i class="fa-solid fa-phone-volume"></i>&nbsp;문의전화</dt>
                        <dd class="fs-6 fw-bold">1588-1978</dd>
                    </dl>
                    <div class="d-flex align-items-center">
                        <a href="http://pf.kakao.com/_kFxjxhn" target="_blank"><img src="/img/kakao_channel.jpg" ></a>
                    </div>
                    <dl class="d-flex flex-column gap-1 mb-0 align-items-center w-50">
                        <dt class="fs-6"><i class="fa-solid fa-phone-volume"></i>&nbsp;광고문의</dt>
                        <dd class="fs-6 fw-bold">02-324-6319</dd>
                    </dl>
                </div>


            </div>
        </div>
    </div>
    <!-- for PC -->
    <div class="container-fluid d-none d-lg-flex w-1560 w-100 gap-5 justify-content-evenly mb-5">
        <div class="footer-l d-flex flex-column">
            <ul class="d-flex align-items-center gap-3 my-4 fs-6">
                <li><img src="/img/kinder_logo_bw.png" style="width: 240px;" /></li>
                <li><a href="<?=route_to('termOfUs')?>">이용약관</a></li>
                <li>|</li>
                <li><a href="<?=route_to('privacy')?>">개인정보처리방침</a></li>
            </ul>
            <ul class="d-flex align-items-center gap-2 fs-7 mb-2">
                <li>사업자등록번호 : 105-81-01773</li>
                <li>|</li>
                <li>통신판매업신고 : 제 2023-서울강남-01170호</li>
            </ul>
            <ul class="d-flex align-items-center gap-2 fs-7 mb-2">
                <li>업체명 : (주)꼬망세미디어</li>
                <li>|</li>
                <li>대표 : 최남호</li>
                <li>|</li>
                <li>[의료기기판매업 신고번호] 제 4816호</li>
            </ul>
            <ul class="d-flex align-items-center gap-2 fs-7 mb-2">
                <li>주소 : (06224) 서울 강남구 논현로 76길 27 (역삼동, 에이포스페이스빌딩) 5층</li>
            </ul>
            <ul class="d-flex align-items-center gap-3 fs-7 mb-2">
                <li>개인정보관리책임자 : 최훈</li>
                <li>|</li>
                <li>메일 : web@edupre.co.kr</li>
            </ul>
            <ul class="d-flex align-items-center gap-3 fs-8 mt-4">
                <li style="color:#aaa">Copyright(c) 1995-2024 (주)꼬망세미디어 All rights reserved.</li>
            </ul>
        </div>
        <div class="footer-r d-flex flex-column gap-4 mt-4 ">
            <ul>
                <li class="fs-6"><i class="fa-solid fa-phone-volume"></i>&nbsp;문의전화</li>
                <li class="fs-4">1588-1978</li>
            </ul>
            <!--
            <ul>
                <li class="fs-6"><i class="fa-solid fa-phone-volume"></i>&nbsp;광고문의</li>
                <li class="fs-4">02-324-6319</li>
            </ul>
            -->
            <div class="fs-7">평일 09:00 ~ 18:00</div>
            <div class="text-center">
                <a href="http://pf.kakao.com/_kFxjxhn" target="_blank"><img src="/img/kakao_channel_off.jpg" onmouseenter="this.src='/img/kakao_channel.jpg'" onmouseleave="this.src='/img/kakao_channel_off.jpg'" ></a>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript">
    function win_open(href){
        let win = window.open("","_blank");
        win.location.href = href;
    }
    $(document).on('click' , '.goCanvas' ,function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        win_open(href);
    })

    $(document).on('click' , '.goBack' ,function(e){
        e.preventDefault();
        history.back();
    })
    var paid_user = '<?=session('isPay') ? 'Y' : 'N' ?>';
</script>

<!-- 동적처리를 위한 iframe -->
<iframe name='hiddenFrame' id="hiddenFrame" width='0' height='0' style="display: none;"></iframe>
</body>
</html>
