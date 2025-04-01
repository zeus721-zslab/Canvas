<?php
/**
 * @var string $active_menu '활성화메뉴'
 */

?>

<!DOCTYPE html>
<html lang="ko"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>킨더 캔버스 관리자 | Dashboard</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="디자인 캔버스 관리자 | Dashboard">
    <meta name="author" content="Commancer">
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--    <script src="https://kit.fontawesome.com/a55104e283.js" crossorigin="anonymous"></script>-->

    <!--<?=link_src_html('/plugins/fontawesome-free/css/all.min.css','css') ?>-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <!-- AdminLTE 4.x -->
    <?=link_src_html('/css/adminlte.css','css') ?>
    <!-- custom css -->
    <?=link_src_html('/css/custom.css','css') ?>

    <!--  require js -->
    <?=link_src_html('/js/jquery-3.7.1.min.js' , 'js')?>
    <!-- jQuery UI 1.11.4 -->
    <?=link_src_html('/plugins/jquery-ui/jquery-ui.min.js','js') ?>
    <!-- support by bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <?=link_src_html('/dist/js/bootstrap.js','js') ?>
    <!-- CUSTOM JS -->
    <?=link_src_html('/js/custom.js','js') ?>

</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
<div class="app-wrapper"> <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Start Navbar Links-->
            <ul class="navbar-nav">
                <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
            <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
<!--                <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> -->
                <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
                <li class="nav-item"> <a class="nav-link" href="/logout"> <i class="bi bi-box-arrow-right"></i> </a> </li>
            </ul> <!--end::End Navbar Links-->
        </div> <!--end::Container-->
    </nav> <!--end::Header--> <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
        <div class="sidebar-brand justify-content-start ps-4"> <!--begin::Brand Link-->
            <a href="/" class="brand-link"> <!--begin::Brand Image-->
                <img src="/images/favicon/favicon_32x32.png" alt="Kinder Canvas Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image--> <!--begin::Brand Text-->
                <span class="brand-text fw-light">Kinder Canvas</span> <!--end::Brand Text-->
            </a> <!--end::Brand Link-->
        </div> <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
            <nav class="mt-2"> <!--begin::Sidebar Menu-->
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                    <li class="nav-header">DashBoard</li>
                    <li class="nav-item">
                        <a href="/DashBoard" class="nav-link">
                            <i class="nav-icon bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">Contents</li>

                    <li class="nav-item">
                        <a href="/GroupManagement" data-alias="/GroupManagement/sort" class="nav-link">
                            <i class="nav-icon bi bi-collection"></i>
                            <p>그룹 관리</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/TemplateManagement" class="nav-link">
                            <i class="nav-icon bi bi-tag"></i>
                            <p>템플릿 관리</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/ClipManagement" class="nav-link">
                            <i class="nav-icon bi bi-image"></i>
                            <p>요소 관리</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/UploadManagement" class="nav-link">
                            <i class="nav-icon bi bi-upload"></i>
                            <p>업로드 관리</p>
                        </a>
                    </li>

                    <li class="nav-header">Member</li>

                    <li class="nav-item">
                        <a href="/PaymentManagement" class="nav-link">
                            <i class="nav-icon fa-solid fa-money-check" aria-hidden="true"></i>
                            <p>결제 관리</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/PaymentManagement/reqCancel" class="nav-link ps-4">
                            <i class="fa-solid fa-arrow-turn-up" style="transform: rotate(90deg);width: 24px;margin-top: 8px;"></i>
                            <p class="d-flex align-items-center gap-2">취소 요청<span class="badge bg-danger reqCancelBadge"></span></p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/UserManagement" class="nav-link">
                            <i class="nav-icon bi bi-person"></i>
                            <p>회원 관리</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/AdminManagement" class="nav-link">
                            <i class="nav-icon bi bi-person-lines-fill"></i>
                            <p>관리자 관리</p>
                        </a>
                    </li>

                    <li class="nav-header">Board</li>
                    <li class="nav-item">
                        <a href="/BoardManagement" class="nav-link">
                            <i class="nav-icon fa-solid fa-bullhorn" aria-hidden="true"></i>
                            <p>공지사항</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/QnaManagement" class="nav-link">
                            <i class="fa-solid fa-person-circle-question"></i>
                            <p class="d-flex align-items-center gap-2">1:1 문의<span class="badge bg-danger reqQnaBadge"></span></p>
                        </a>
                    </li>

                </ul> <!--end::Sidebar Menu-->
            </nav>
        </div> <!--end::Sidebar Wrapper-->
    </aside> <!--end::Sidebar--> <!--begin::App Main-->

    <script type="text/javascript">

        function chkReqCancel(){

            $.ajax({
                url: "/PaymentManagement/chkReqCancelCnt/",
                data: { _csrf : $('input[name="_csrf"]').val() },
                method: "post",
                dataType: "json",
                success: function (result) {
                    if(parseInt(result.cnt) > 0) $('.reqCancelBadge').html(result.cnt);
                    else $('.reqCancelBadge').html('');
                }
            });

        }

        function chkReqQna(){

            $.ajax({
                url: "/QnaManagement/chkReqQnaCnt/",
                data: { _csrf : $('input[name="_csrf"]').val() },
                method: "post",
                dataType: "json",
                success: function (result) {
                    if(parseInt(result.cnt) > 0) $('.reqQnaBadge').html(result.cnt);
                    else $('.reqQnaBadge').html('');
                }
            });

        }

        $(function(){

            chkReqQna();
            chkReqCancel();

            var active_menu = '<?=$active_menu?>';
            var aMenu = active_menu.split(':');
            var href = aMenu[1] ? '/'+aMenu[0]+'/'+aMenu[1] : '/'+aMenu[0];

            if(    aMenu[0] === 'GroupManagement'
                || aMenu[0] === 'TemplateManagement'
                || aMenu[0] === 'ClipManagement'
                || aMenu[0] === 'BgManagement'
                || aMenu[0] === 'UploadManagement'
            ){//킨더캔버스 계열
                $('.sidebar-menu').find('[href="/'+aMenu[0]+'"]').addClass('active');
            }
            $('.sidebar-menu').find('[href="'+href+'"]').addClass('active');
            $('.sidebar-menu').find('[data-alias="'+href+'"]').addClass('active')
        })
    </script>