<?php
/**
 * @var array $aList '템플릿 리스트'
 * @var array $aList2 '템플릿 리스트'
 * @var object $encrypter '인크립트'
 */

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<main class="container-fluid flex-column d-flex align-items-center px-0">
    <!-- section 1 -->
    <section class="d-flex  w-1560  w-100 align-items-center flex-column sec1 position-relative" >
        <div class="d-flex flex-column align-items-center">
            <a class="main-p-logo-wrap"><img src="/img/kinder_logo.png" alt="메인로고" /></a>
            <!-- for PC -->
            <div class="d-none d-lg-flex flex-column align-items-center gap-4 main-p-desc-wrap">
                <h1 class="fw-bold d-none d-lg-inline-block">우리 원에 필요한 모든 디자인</h1>
                <p class="m-0">놀이부터 환경구성, 행사까지 필요한 디자인을 편리하고 쉽게 준비해 보세요!</p>
            </div>
            <!-- for mobile -->
            <div class="d-flex d-lg-none flex-column align-items-center gap-2 main-p-desc-wrap">
                <h1 class="fw-bold text-center" style="line-height: 2.5rem">우리 원에 필요한 모든 디자인,<br>킨더캔버스</h1>
                <p class="m-0">놀이부터 환경구성, 행사까지<br>필요한 디자인을 편리하고 쉽게 준비해 보세요!</p>
            </div>
        </div>
        <div class="my-5 mb-lg-0 w-100 text-center main-p-btn-wrap d-flex flex-column justify-content-center align-items-center gap-3 d-lg-block">
            <a role="button" class="btn btn-black py-lg-3 px-lg-5 me-lg-5" href="<?=route_to('Canvas')?>">바로 디자인하기</a>
            <a class="position-sticky me-5 d-none d-lg-inline-block main-p-char3"><img src="/img/char3.png" alt="" /></a>
            <a role="button" class="btn btn-black py-lg-3 px-lg-5" href="<?=route_to('Category','month')?>">템플릿 구경하기</a>
        </div>
    </section>
    <!--  section 2 -->
    <?php /* @TODO '유/무료 마크 처리' */?>
    <section class="d-flex justify-content-center w-100 sec2 ">
        <div class="w-1560 w-100 d-flex flex-column justify-content-center"  >
            <h1 class="text-center py-lg-5 fw-bold my-5"><img src="/img/char1.png" style="width: 80px;" />이달의 추천 템플릿</h1>

            <div class="d-none d-lg-flex justify-content-center recommand-tempalte-wrap gap-5">
                <div class="justified-gallery template-list">
                    <?php foreach ($aList as $r) {
                        $strEnc = sprintf("%s_template__%s",date('YmdHis'),$r["template_id"]);
                        $sEnc = urlencode($encrypter->encrypt($strEnc));
                        ?>
                        <a href="/Canvas?e=<?=$sEnc?>" target="_blank" class="goCanvas img-thumbnail bg-white border-0">
                            <img src="<?=$r["thumb_file"]?>" alt="<?=$r["title"]?>"  />
                        </a>
                    <?php }?>
                </div>
                <div class="text-center main-p-char1">
                    <a class="position-sticky d-inline-block">
                        <img src="/img/char1.png" alt="" />
                    </a>
                </div>
                <div class="justified-gallery template-list">
                    <?php foreach ($aList2 as $r) {
                        $strEnc = sprintf("%s_template__%s",date('YmdHis'),$r["template_id"]);
                        $sEnc = urlencode($encrypter->encrypt($strEnc));
                        ?>
                        <a href="/Canvas?e=<?=$sEnc?>" target="_blank" class="goCanvas img-thumbnail bg-white border-0">
                            <img src="<?=$r["thumb_file"]?>" alt="<?=$r["title"]?>"  />
                        </a>
                    <?php }?>
                </div>
            </div>

            <div class="d-block d-lg-none">
                <!-- Swiper -->
                <div class="swiper mySwiper1 mb-5">
                    <div class="swiper-wrapper">
                        <?php foreach ($aList as $k => $r) {
                            $strEnc = sprintf("%s_template__%s",date('YmdHis'),$r["template_id"]);
                            $sEnc = urlencode($encrypter->encrypt($strEnc));
                            ?>
                            <a class="swiper-slide <?=$r['rotate']?>" href="/Canvas?e=<?=$sEnc?>" target="_blank">
                                <img src="<?=$r["thumb_file"]?>" alt="<?=$r["title"]?>" />
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <!-- Swiper -->
                <div class="swiper mySwiper2 mb-5">
                    <div class="swiper-wrapper">
                        <?php foreach ($aList2 as $k => $r) {
                            $strEnc = sprintf("%s_template__%s",date('YmdHis'),$r["template_id"]);
                            $sEnc = urlencode($encrypter->encrypt($strEnc));
                            ?>
                            <a class="swiper-slide <?=$r['rotate']?>" href="/Canvas?e=<?=$sEnc?>" target="_blank">
                                <img src="<?=$r["thumb_file"]?>" alt="<?=$r["title"]?>" />
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section 3 -->
    <section class="d-flex w-1560 w-100 justify-content-center sec3 position-relative">
        <div class="d-flex flex-column align-items-center">
            <h1 class="text-center py-lg-5 my-5 fw-bold"><img src="/img/char2.png" style="width: 40px;" />킨더's 템플릿</h1>
            <div class="d-flex flex-column flex-lg-row justify-content-center d-flex category-warp mb-5 mb-lg-0">
                <div class="d-flex flex-column category-list">
                    <div class="d-flex gap-2 flex-column align-items-center">
                        <a class="d-flex align-items-center px-3 category-img-warp"><img src="/img/main_event.png" class="w-100" alt="행사" /></a>
                        <h4 class="m-0 mt-2 fw-bold">행사</h4>
                        <span class="sec3-desc">원 내의 다양한 행사를 준비해 보세요.</span>
                        <a class="fw-bold" href="<?=route_to('Category','event')?>">템플릿 구경가기 &gt;</a>
                    </div>
                    <div class="d-flex gap-2 flex-column align-items-center">
                        <a class="d-flex align-items-center px-3 category-img-warp"><img src="/img/main_env.png" class="w-100" alt="환경구성" /></a>
                        <h4 class="m-0 mt-2 fw-bold">환경구성</h4>
                        <span class="sec3-desc">특별한 우리 교실을 꾸며 보세요.</span>
                        <a class="fw-bold" href="<?=route_to('Category','env')?>">템플릿 구경가기 &gt;</a>
                    </div>
                </div>
                <div class="d-none d-lg-block text-center main-p-char2">
                    <a class="position-sticky d-inline-block ">
                        <img src="/img/char2.png" alt="" />
                    </a>
                </div>
                <div class="d-flex flex-column category-list">
                    <div class="d-flex gap-2 flex-column align-items-center w-100">
                        <a class="d-flex align-items-center px-3 category-img-warp"><img src="/img/main_play.png" class="w-100" alt="놀이" /></a>
                        <h4 class="m-0 mt-2 fw-bold">놀이</h4>
                        <span class="sec3-desc" style="letter-spacing: -.1px;">직접 만든 풍부한 자료로 놀이해 보세요.</span>
                        <a class="fw-bold" href="<?=route_to('Category','play')?>">템플릿 구경가기 &gt;</a>
                    </div>
                    <div class="d-flex gap-2 flex-column align-items-center  w-100">
                        <a class="d-flex align-items-center px-3 category-img-warp"><img src="/img/main_noti.png" class="w-100" alt="행사" /></a>
                        <h4 class="m-0 mt-2 fw-bold">안내문</h4>
                        <span class="sec3-desc">상황에 따른 안내문을 작성해 보세요.</span>
                        <a class="fw-bold" href="<?=route_to('Category','notice')?>">템플릿 구경가기 &gt;</a>
                    </div>
                </div>
            </div>
            <div class="go-template-wrap"  style="">
                <img src="/img/char3.png" alt="" />
                <a role="button" href="<?=route_to('Category','month')?>" class="btn btn-black fs-5 py-lg-3 px-lg-5">템플릿 구경하기</a>
                <img src="/img/char1.png" alt=""  />
            </div>
        </div>
    </section>
</main>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script type="text/javascript">
    var setH = 200;
    $(() => {

        if(check_mobile()){
            <!-- Initialize Swiper -->
            var swiper1 = new Swiper(".mySwiper1", {
                slidesPerView: 3,
                spaceBetween: 30,
                speed: 10000,
                loop: true,
                autoplay: {
                    delay: 1,
                    disableOnInteraction: false,
                },
                pagination: {
                    // el: ".swiper-pagination",
                    clickable: true,
                },
            });
            var swiper2 = new Swiper(".mySwiper2", {
                slidesPerView: 3,
                spaceBetween: 30,
                speed: 10000,
                loop: true,
                autoplay: {
                    delay: 1,
                    disableOnInteraction: false,
                    reverseDirection : true,
                },
                pagination: {
                    // el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }

        if(!check_mobile()){//PC인 경우에만 JG사용
            var $jg = $('.justified-gallery');
            if($jg.length > 0){
                $jg.justifiedGallery({
                    rowHeight : setH,
                    lastRow : 'nojustify',
                    maxRowsCount : 5,
                    border : 2,
                    margins : 10
                });
            }
        }
    });
</script>


