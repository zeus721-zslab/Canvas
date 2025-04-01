<?php

/**
 * @var string $search_type '헤더 검색조건'
 * @var object $user '회원정보'
 * @var array $menu_list '검색필터(메뉴)'
 * @var string $search_text '검색단어'
 * @var string $type 'active 타입'
 * @var string $site_name '사이트명'
 **/

$menu_str = '전체';
if($search_type) $menu_str = $menu_list[$search_type];

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?=$site_name?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="keywords" content="킨더캔버스">
    <meta name="description" content="유치원/어린이집에 필요한 디자인을 찾으시나요? 행사부터 놀이, 환경구성, 안내문 등 원하는 디자인을 골라 편하고 쉽게 사용해 보세요!">
    <meta name="publisher" content="Commencer">
    <meta name="copyright" content="copyright@Commencer">
    <meta property="og:type" content="website">
    <meta property="og:title" content="킨더캔버스">
    <meta property="og:description" content="유치원/어린이집에 필요한 디자인을 찾으시나요? 행사부터 놀이, 환경구성, 안내문 등 원하는 디자인을 골라 편하고 쉽게 사용해 보세요!">
    <meta property="og:image" content="<?=base_url()?>/img/kinder_logo.png">
    <meta property="og:url" content="<?=base_url()?>">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="48x48" href="/images/favicon/favicon_48x48.png">
    <link rel="apple-touch-icon" sizes="64x64" href="/images/favicon/favicon_64x64.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/favicon_72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/favicon_76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/favicon_120x120.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/images/favicon/favicon_128x128.png">
    <link rel="apple-touch-icon" sizes="150x150" href="/images/favicon/favicon_150x150.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/favicon_180x180.png">
    <link rel="icon" type="image/png" sizes="196x196"  href="/images/favicon/favicon_196x196.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon_32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon_96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon_16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicon/favicon_150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script type="text/javascript">
        <?php if(!isTest()){?>
            document.oncontextmenu = () => { return false; }
        <?php } ?>
    </script>
    <!--  Reset Css  -->
    <?=link_src_html('/css/reset.css','css')?>
    <!--  Normalize Css  -->
    <?=link_src_html('/css/normalize.css','css')?>
    <!--  Bootstrap Css-->
    <?=link_src_html('/css/bootstrap.min.css','css')?>
    <!--  justifiedGallery Css-->
    <?=link_src_html('/css/justifiedGallery.min.css','css')?>
    <!--  de canvas Css-->
    <?=link_src_html('/css/de_canvas.new.css','css')?>
    <!-- loader css-->
    <?=link_src_html('/css/loader.css','css')?>

    <!-- jquery   -->
    <?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
    <!-- bootstrap Js  -->
    <?=link_src_html('/js/bootstrap.bundle.js','js')?>
    <!-- loader js-->
    <?=link_src_html('/js/loader.js','js')?>
    <!-- Custom js-->
    <?=link_src_html('/js/custom.js','js')?>
    <!-- fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--    <script src="//kit.fontawesome.com/a55104e283.js" crossorigin="anonymous"></script>-->
    <!-- masonry js -->
    <!--    <script src="http://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js" ></script>-->

    <!-- isotope js -->
    <script src="//unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>
    <!-- imagesloaded js -->
<!--    <script src="//unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>-->
    <!-- justifiedGallery js -->
    <?=link_src_html('/js/jquery.justifiedGallery.min.js','js')?>

</head>
<body <?php if(!isTest()){?>oncontextmenu="return false;"<?php } ?> >
<header>
    <!-- top header -->
    <div class="container-fluid border-bottom d-flex justify-content-center header-top">
        <div class="d-none d-lg-flex w-1560 w-100 d-flex justify-content-lg-between justify-content-end py-3 pt-lg-3 pb-lg-0">
            <div>
                <ul class="d-flex gap-5 align-items-center">
                    <li><a class="d-inline-block w-100 logo" href="<?=route_to('/')?>"><img src="/img/simbol.png" alt="" style="width: 80px" /></a></li>
                    <li><a class="d-inline-block w-100" href="https://www.edupre.co.kr/" target="_blank">꼬망세</a></li>
                    <li><a class="d-inline-block w-100" href="https://store.edupre.co.kr/" target="_blank">꼬망세몰</a></li>
                    <li><a class="d-inline-block w-100" href="<?=route_to('Category','month')?>">템플릿</a></li>
                    <li><a class="d-inline-block w-100" href="<?=route_to('Payment::upsertForm')?>">요금제</a></li>
                    <li><a class="d-inline-block w-100" href="<?=route_to('Common::userGuide')?>">사용가이드</a></li>
                    <li class="position-relative board-wrap">
                        <a class="d-inline-block w-100" href="#">게시판</a>
                        <ul class="board flex-column">
                            <li><a class="d-inline-block py-2 px-3 w-100" href="<?=route_to('Common::notice')?>">공지사항</a></li>
                            <li><a class="d-inline-block py-2 px-3 w-100" href="<?=route_to('Qna::index')?>">1:1문의</a></li>
                        </ul>
                        <!--                        <a class="d-inline-block w-100" href="--><?php //=route_to('Common::notice')?><!--">공지사항</a>-->
                    </li>
                </ul>
            </div>
            <div>
                <ul class="d-flex gap-5 align-items-center h-100">
                    <?php if(isset($user->id)){?>
                        <li class="position-relative user-detail-wrap">
                            <a class="d-inline-block w-100" href="#"><?=$user->username?> 님</a>
                            <ul class="user-detail flex-column">
                                <li><a class="d-inline-block py-2 px-3 w-100" href="<?=route_to('My')?>">내 보관함</a></li>
                                <li><a class="d-inline-block py-2 px-3 w-100" href="<?=route_to('My::index','history')?>">내 정보</a></li>
                                <li><a class="d-inline-block py-2 px-3 w-100" href="<?=route_to('logout')?>">로그아웃</a></li>
                            </ul>
                        </li>
                    <?php } else {?>
                        <li><a class="d-inline-block w-100" href="<?=route_to('login')?>">로그인</a></li>
                        <li><a class="d-inline-block w-100" href="<?=route_to('RegisterController::guide_register')?>">회원가입</a></li>
                    <?php }?>
                    <?php if(isset($user->id)){?>
                        <li><a role="button" class="btn btn-black goCanvas" href="<?=route_to('Canvas::index')?>" target="_blank">새로 만들기</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- for MOBILE -->
        <nav class="navbar d-lg-none fixed-top p-0 border-bottom">
            <div class="container-fluid px-0">
                <div class="w-100 p-2 d-flex align-items-center justify-content-between" style="transition: .2s ease-in-out; max-height: 60px; height: 60px;  -webkit-backdrop-filter: blur(1.5rem);backdrop-filter: blur(1.5rem);background-color: rgba(255,255,255,0.1)">
                    <div style="width: 34px;"></div>
                    <a href="<?=base_url()?>"><img src="/img/kinder_logo.png" alt="logo" style="width: 180px;"></a>
                    <button class="navbar-toggler p-2" style="line-height: 0;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon" style="width: 1rem;height: 1rem;"></span>
                    </button>
                </div>
                <!-- side AREA -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">

                        <ul class="navbar-nav justify-content-start flex-grow-1 d-flex gap-2" style="height: calc(100% - 40px)">
                            <?php if(isset($user->id)){?>
                                <li class="nav-item d-flex gap-2 justify-content-between">
                                    <?php
                                    switch (rand(1,3)){
                                        case 1: $user_color='--logo-red';break;
                                        case 2: $user_color='--logo-yellow';break;
                                        case 3: $user_color='--logo-blue';break;
                                    }

                                    ?>
                                    <div class="d-flex align-items-center justify-content-center fs-7" style="border-radius: 100%;width: 48px; height: 48px;background-color: var(<?=$user_color?>);color: #fff; "><?=mb_substr($user->username, 0, 2)?></div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold"><?=$user->username?></div>
                                        <div class="fs-7"><?=$user->user_email?></div>
                                    </div>
                                    <a role="button" class="btn" href="<?=route_to('logout')?>" style="color:#777;">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    </a>
                                </li>

                                <li class="nav-item d-flex gap-3">
                                    <a role="button" href="<?=route_to('My::index','history')?>" class="btn btn-black w-50">내 정보</a>
                                    <a role="button" href="<?=route_to('My')?>" class="btn btn-black w-50">내 보관함</a>
                                </li>
                                <hr />
                            <?php } else {?>
                                <li class="nav-item"><a class="btn nav-link active text-center" style="color:#333;background-color: var(--bg-color);border-radius: 0;" href="<?=route_to('login')?>" role="button" >로그인하기</a></li>
                                <li class="nav-item"><a class="btn nav-link active text-center" style="color:#333;background-color: var(--bg-color);border-radius: 0;" href="<?=route_to('register')?>" role="button" >회원가입하기</a></li>
                            <?php }?>
                            <li class="nav-item"><a class="nav-link active d-flex gap-2 align-items-center" href="<?=route_to('Category::index','month')?>">월별 디자인</a></li>
                            <li class="nav-item"><a class="nav-link active d-flex gap-2 align-items-center" href="<?=route_to('Category::index','event')?>">행사</a></li>
                            <li class="nav-item"><a class="nav-link active d-flex gap-2 align-items-center" href="<?=route_to('Category::index','play')?>">놀이</a></li>
                            <li class="nav-item"><a class="nav-link active d-flex gap-2 align-items-center" href="<?=route_to('Category::index','env')?>">환경구성</a></li>
                            <li class="nav-item"><a class="nav-link active d-flex gap-2 align-items-center" href="<?=route_to('Category::index','notice')?>">안내문</a></li>
                            <hr />
                            <li class="nav-item"><a href="<?=route_to('Common::userGuide')?>" class="nav-link active d-flex gap-2 align-items-center"> <span>사용가이드</span> </a></li>
                            <li class="nav-item"><a href="<?=route_to('Common::notice')?>" class="nav-link active d-flex gap-2 align-items-center"> <span>공지사항</span></a></li>
                            <li class="nav-item"><a href="<?=route_to('Qna::index')?>" class="nav-link active d-flex gap-2 align-items-center"> <span>1:1문의</span></a></li>
                            <hr />
                            <li class="nav-item"><a href="https://www.edupre.co.kr" target="_blank" class="nav-link active d-flex gap-2 align-items-center"> <span>꼬망세</span> </a></li>
                            <li class="nav-item"><a href="https://store.edupre.co.kr" target="_blank" class="nav-link active d-flex gap-2 align-items-center"> <span>꼬망세 쇼핑몰</span></a></li>
                        </ul>
                        <?php if(isset($user->id)){?>
                            <ul class="navbar-nav justify-content-end flex-grow-1 d-flex gap-2">
                                <li class="nav-item  w-100"><a class="btn btn-black nav-link active text-center text-white" href="/Payment/upsertForm" role="button" >요금제</a></li>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- main logo -->
    <div class="container-fluid d-none d-lg-flex justify-content-center logo-wrap">
        <img src="/img/kinder_logo.png" alt="logo" />
    </div>
    <!-- category -->
    <div class="d-flex justify-content-center header-category-wrap">
        <ul class="w-1560 w-100 d-flex justify-content-center header-category">
            <li class="d-flex align-items-center <?=$type === 'month' ? 'active' : ''?>"><a class="w-100 d-inline-block py-2" href="<?=route_to('Category','month')?>">월별 디자인</a></li>
            <li class="d-flex align-items-center <?=$type === 'event' ? 'active' : ''?>"><a class="w-100 d-inline-block py-2" href="<?=route_to('Category','event')?>">행사</a></li>
            <li class="d-flex align-items-center <?=$type === 'play' ? 'active' : ''?>"><a class="w-100 d-inline-block py-2" href="<?=route_to('Category','play')?>">놀이</a></li>
            <li class="d-flex align-items-center <?=$type === 'env' ? 'active' : ''?>"><a class="w-100 d-inline-block py-2" href="<?=route_to('Category','env')?>">환경구성</a></li>
            <li class="d-flex align-items-center <?=$type === 'notice' ? 'active' : ''?>"><a class="w-100 d-inline-block py-2" href="<?=route_to('Category','notice')?>">안내문</a></li>
        </ul>
    </div>

    <!-- search -->
    <div class="d-flex justify-content-center my-4 my-lg-5 py-lg-3 header-search">
        <form class="header_search_form" name="header_search_form" method="get" action="/Search">
            <input type="hidden" name="q" value="" />
            <input type="hidden" name="t" value="" />
        </form>
        <div class="w-1560 d-flex justify-content-center">
            <div class="input-group position-relative">
                <button class="btn btn-lightgray-outline dropdown-toggle position-relative fs-6 border-end-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 111px;border-radius: 0;">
                    <span style="display: inline-block; min-width: 80%;text-align: center"><?=$menu_str?></span>
                </button>
                <ul class="dropdown-menu shadow-lg" style="border-color: #f3f0eb;box-shadow: #f3f0eb">
                    <li class="dropdown-item zs-cp" data-for="search_type_all">
                        <div class="main-checkbox-ol sm">
                            <div class="square">
                                <input type="radio" name="search_type" class="search_type" id="search_type_all" value="" title="" checked="">
                                <label for="search_type_all"></label>
                            </div>
                            <label class="fs-6 fw-normal">전체</label>
                        </div>
                    </li>
                    <?php foreach ($menu_list as $k => $v) {?>
                        <li class="dropdown-item zs-cp" data-for="search_type_<?=$k?>">
                            <div class="main-checkbox-ol sm">
                                <div class="square zs-cp">
                                    <input type="radio" name="search_type" id="search_type_<?=$k?>" value="<?=$k?>" class="search_type"  title="" <?=$search_type == $k ? 'checked' : ''?>>
                                    <label for="search_type_<?=$k?>"></label>
                                </div>
                                <label class="fs-6 fw-normal"><?=$v?></label>
                            </div>
                        </li>
                    <?php } ?>
                </ul>

                <input type="text" class="form-control search-text-input" name="header_search_text" style="border-color: #f3f0eb;border-radius: 0;" value="<?=$search_text?>" placeholder="필요한 템플릿을 검색해 보세요!" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass position-absolute icon-magnifying zs-cp" style="z-index: 5;color:#f3f0eb;right:8px;top: 12px;"></i>

                <?php /* @TODO 돋보기 */?>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $('.header-search .dropdown-item').on('click',function(){
                var id = $(this).data('for');
                var val = $(this).find('label:not([for="'+id+'"])').text();
                //체크처리
                $('.header-search #'+id).prop('checked',true);
                //text 반영
                $('.header-search button.dropdown-toggle').html('<span style="display: inline-block; min-width: 80%;text-align: center">'+val+'</span>');
            })
        })
    </script>


</header>

<?=link_src_html('/js/header.js','js')?>