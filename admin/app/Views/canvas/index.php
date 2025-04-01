<?php
/**
 * @var int $nCanvasWidth '기본가로사이즈'
 * @var int $nCanvasHeight '기본세로사이즈'
 * @var float $zoom '기본줌'
 * @var string $emRotate '기본형태( L | S | P )'
 * @var array $aInput '입력값'
 * @var array $aInfo '컨텐츠 기본정보'
 * @var int $per_page '페이지당 갯수'
 **/

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>킨더캔버스 - 관리자</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

    <!--  Reset Css  -->
    <link href="/canvas/css/reset.css" rel="stylesheet">
    <!--  Normalize Css  -->
    <link href="/canvas/css/normalize.css" rel="stylesheet">
    <!--  Bootstrap Css-->
    <link href="/canvas/css/bootstrap.min.css" rel="stylesheet">
    <!--  de canvas Css-->
    <?=link_src_html('/canvas/css/de_app.css' , 'css')?>

    <!--    -->
    <link href="/canvas/css/justifiedGallery.min.css" rel="stylesheet">
    <!-- jquery ui css -->
    <link href="/canvas/css/jquery-ui.theme.css" rel="stylesheet" type="text/css">
    <link href="/canvas/css/jquery-ui.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/canvas/css/jquery.contextMenu.min.css?t=<?=time()?>">

    <!-- jquery   -->
    <script type="text/javascript" src="/canvas/js/jquery-1.9.1.min.js"></script>
    <!--    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
    <script type="text/javascript" src="/canvas/js/jquery.contextMenu.js"></script>

    <!-- jquery ui  -->
    <script type="text/javascript" src="/canvas/js/jquery-ui-1.11.4.js"></script>
    <!--<script type="text/javascript" src="/js/common.js?dt=<?=time()?>"></script>-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>


    <!-- bootstrap Js  -->
    <script type="text/javascript" src="/canvas/js/bootstrap.min.js"></script>
    <!-- fontawesome icons -->
    <!-- font-awesome css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--    <script src="https://kit.fontawesome.com/a55104e283.js" crossorigin="anonymous"></script>-->


</head>

<body>
<div id="objLoading"></div>
<div class="wrapProgress" title="글씨체 불러오고 있어요!">
    <div class="progress-label">불러오기</div>
    <div id="progressbar"></div>
</div>

<header class="d-flex align-items-center border-bottom">
    <div class="flex-grow-0 d-flex align-items-center all-menu position-relative justify-content-center" >
        <img src="/images/favicon/favicon_32x32.png" alt="favicon-32x32" />
        <span class="d-none">전체메뉴</span>
    </div>

    <div class="d-flex justify-content-between flex-grow-1">
        <!-- 뒤/앞으로가기 >-->
        <div>
            <button class="btn header_btnbefore btnUnDo"><img src="/canvas/easycanvas/easycv_icon_before.png" alt></button>
            <button class="btn header_btnbefore btnReDo"><img src="/canvas/easycanvas/easycv_icon_after.png" alt></button>
        </div>

        <div class="d-flex align-items-center justify-content-center" style="width: 270px">
            <input type="text" class="form-control" value="<?=$aInfo['title']?>" name="top_title" title="" placeholder="제목을 입력해주세요." />
        </div>

        <div>
            <button class="btn btn-primary btnSave">저장하기</button>
            <button class="btn btn-info btnDownload">다운로드</button>
            <button class="btn btn-success btnSlide">슬라이드</button>
        </div>
    </div>
</header>

<main class="contents-wrap position-relative" >

    <div class="left-menu d-flex flex-row flex-grow-0">

        <!-- icon menu-->
        <div class="icon-menu-wrap flex-grow-0 border-end d-flex flex-column">

            <ul class="d-flex flex-column icon-menu flex-grow-1">

                <li>
                    <div class="active" data-val="_template">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: rgb(67, 72, 86);"><path fill="evenodd" fill-rule="evenodd" d="M17 3a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h10Zm2.5 7.25V17a2.5 2.5 0 0 1-2.5 2.5h-6.75v-9.25h9.25Zm0-1.5V7A2.5 2.5 0 0 0 17 4.5H7A2.5 2.5 0 0 0 4.5 7v1.75h15Zm-15 1.5h4.25v9.25H7A2.5 2.5 0 0 1 4.5 17v-6.75Z" clip-rule="evenodd"></path><path fill="evenodd" fill-opacity="0.1" d="M19.5 17v-6.75h-9.25v9.25H17c1.379 0 2.5-1.12 2.5-2.5Z"></path></svg>
                        <span>탬플릿</span>
                    </div>
                </li>
                <li>
                    <div data-val="_upload">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: rgb(67, 72, 86);"><path fill="evenodd" fill-rule="evenodd" d="M10.5 4a5.502 5.502 0 0 1 5.316 4.082 5.5 5.5 0 0 1 1.433 10.907c-.411.056-.749-.285-.749-.7 0-.413.34-.742.746-.819a4.001 4.001 0 1 0-2.873-7.318c-.35.22-.82.21-1.102-.09-.284-.304-.27-.785.07-1.025a5.487 5.487 0 0 1 1.025-.568 4.002 4.002 0 1 0-7.485 2.738c.177.374.11.842-.225 1.085-.335.244-.808.172-1.004-.193a5.464 5.464 0 0 1-.434-1.062 3.501 3.501 0 0 0 1.038 6.433c.404.088.744.416.744.83s-.338.756-.747.694A5.001 5.001 0 0 1 4.862 9.53.632.632 0 0 1 5 9.482 5.5 5.5 0 0 1 10.5 4Zm.75 10.27v5.98a.75.75 0 0 0 1.5 0v-5.984l1.5 1.36a.75.75 0 1 0 1.008-1.11l-2.416-2.192a1.25 1.25 0 0 0-1.68 0l-2.415 2.191a.75.75 0 1 0 1.007 1.111l1.496-1.356Z" clip-rule="evenodd"></path><path fill="evenodd" fill-opacity="0.1" fill-rule="evenodd" d="M6.998 18.25h4.252v-3.98l-1.496 1.356a.75.75 0 1 1-1.007-1.11l2.416-2.192a1.25 1.25 0 0 1 1.68 0l2.415 2.191a.75.75 0 1 1-1.007 1.111l-1.5-1.36v3.984h3.75c.021-.395.351-.705.745-.78a4.001 4.001 0 1 0-2.873-7.318c-.35.22-.82.21-1.102-.09-.284-.304-.27-.785.07-1.025a5.487 5.487 0 0 1 1.025-.568 4.002 4.002 0 1 0-7.485 2.738c.177.374.11.842-.225 1.085-.335.244-.808.172-1.004-.193a5.464 5.464 0 0 1-.434-1.062 3.501 3.501 0 0 0 1.038 6.433c.388.085.716.39.742.78Z" clip-rule="evenodd"></path></svg>
                        <span>업로드</span>
                    </div>
                </li>
                <li>
                    <div data-val="_clip">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: rgb(67, 72, 86);"><path fill="evenodd" fill-rule="evenodd" d="M8.75 11.25a2.5 2.5 0 0 0 2.5-2.5V5.5A2.5 2.5 0 0 0 8.75 3H5.5A2.5 2.5 0 0 0 3 5.5v3.25a2.5 2.5 0 0 0 2.5 2.5h3.25ZM5.5 9.75h3.25a1 1 0 0 0 1-1V5.5a1 1 0 0 0-1-1H5.5a1 1 0 0 0-1 1v3.25a1 1 0 0 0 1 1ZM21 18.5a2.5 2.5 0 0 1-2.5 2.5h-3.25a2.5 2.5 0 0 1-2.5-2.5v-3.25a2.5 2.5 0 0 1 2.5-2.5h3.25a2.5 2.5 0 0 1 2.5 2.5v3.25Zm-2.5 1h-3.25a1 1 0 0 1-1-1v-3.25a1 1 0 0 1 1-1h3.25a1 1 0 0 1 1 1v3.25a1 1 0 0 1-1 1Zm-7.25-2.625a4.125 4.125 0 1 1-8.25 0 4.125 4.125 0 0 1 8.25 0ZM7.125 14.25a2.625 2.625 0 1 1 0 5.25 2.625 2.625 0 0 1 0-5.25Zm10.62-10.244a1 1 0 0 0-1.739 0l-3.124 5.5a1 1 0 0 0 .87 1.494H20a1 1 0 0 0 .87-1.494l-3.125-5.5ZM14.611 9.5l2.265-3.988L19.14 9.5h-4.53Z" clip-rule="evenodd"></path><path fill="evenodd" fill-opacity="0.1" fill-rule="evenodd" d="M5.5 9.75h3.25a1 1 0 0 0 1-1V5.5a1 1 0 0 0-1-1H5.5a1 1 0 0 0-1 1v3.25a1 1 0 0 0 1 1Zm13 9.75h-3.25a1 1 0 0 1-1-1v-3.25a1 1 0 0 1 1-1h3.25a1 1 0 0 1 1 1v3.25a1 1 0 0 1-1 1ZM7.125 14.25a2.625 2.625 0 1 1 0 5.25 2.625 2.625 0 0 1 0-5.25Z" clip-rule="evenodd"></path></svg>
                        <span>요소</span>
                    </div>
                </li>
                <li>
                    <div data-val="_text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: rgb(67, 72, 86);"><path fill="evenodd" d="M8.75 7.998v.48a.75.75 0 1 1-1.5 0v-1.13c0-.47.38-.85.85-.85h7.55c.47 0 .85.38.85.85v1.13a.75.75 0 0 1-1.5 0v-.48h-2.374v8.004h.927a.75.75 0 0 1 0 1.5H10.2a.75.75 0 1 1 0-1.5h.926V7.998H8.75Z"></path><path fill="evenodd" fill-rule="evenodd" d="M3 7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7Zm4-2.5h10A2.5 2.5 0 0 1 19.5 7v10a2.5 2.5 0 0 1-2.5 2.5H7A2.5 2.5 0 0 1 4.5 17V7A2.5 2.5 0 0 1 7 4.5Z" clip-rule="evenodd"></path><path fill="evenodd" fill-opacity="0.1" d="M4.5 13.828V17A2.5 2.5 0 0 0 7 19.5h10a2.5 2.5 0 0 0 2.5-2.5v-3.172h-6.874v2.174h.927a.75.75 0 0 1 0 1.5H10.2a.75.75 0 1 1 0-1.5h.926v-2.174H4.5Z"></path></svg>
                        <span>텍스트</span>
                    </div>
                </li>
                <li>
                    <div data-val="_bg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: rgb(67, 72, 86);"><path fill="evenodd" fill-rule="evenodd" d="M20.61 5.275A3.988 3.988 0 0 1 21 7v10a4 4 0 0 1-4 4H7c-.618 0-1.202-.14-1.725-.39a4.016 4.016 0 0 1-1.96-2.053A3.988 3.988 0 0 1 3 17V7a4 4 0 0 1 4-4h10c.592 0 1.154.129 1.66.36a4.016 4.016 0 0 1 1.95 1.915Zm-3.135-.73-12.93 12.93c.187.973.94 1.746 1.902 1.964L19.439 6.447a2.503 2.503 0 0 0-1.964-1.902ZM9.412 4.5H7A2.5 2.5 0 0 0 4.5 7v2.412L9.412 4.5ZM4.5 11.533 11.533 4.5H15.4L4.5 15.399v-3.866ZM8.507 19.5h3.866l7.127-7.127V8.507L8.507 19.5ZM19.5 14.494 14.494 19.5H17a2.5 2.5 0 0 0 2.5-2.5v-2.506Z" clip-rule="evenodd"></path><path fill="evenodd" fill-opacity="0.1" fill-rule="evenodd" d="m4.545 17.475 12.93-12.93c.973.187 1.746.94 1.964 1.902L6.447 19.439a2.503 2.503 0 0 1-1.902-1.964ZM7 4.5h2.412L4.5 9.412V7A2.5 2.5 0 0 1 7 4.5Zm4.533 0L4.5 11.533V15.4L15.399 4.5h-3.866Zm.84 15H8.507L19.5 8.507v3.866L12.373 19.5Zm2.12 0 5.007-5.006V17a2.5 2.5 0 0 1-2.5 2.5h-2.506Z" clip-rule="evenodd"></path></svg>
                        <span>배경</span>
                    </div>
                </li>

            </ul>
            <ul class="d-flex flex-column icon-menu flex-grow-0">
                <li>
                    <div class="hide-contents-wrap">
                        <button class="btn btn-secondary hide-contents">
                            <i class="fa-solid fa-chevron-left"></i><i class="fa-solid fa-chevron-left"></i>
                        </button>
                    </div>
                </li>
            </ul>

        </div>

        <!-- contents menu  -->
        <div class="d-flex flex-column flex-grow-1 contents-menu-wrap px-3 border-end" style="overflow-y:auto"> </div>

        <!-- object menu  -->
        <div class="d-none flex-column flex-grow-1 object-wrap px-3 border-end gap-3 mt-4" style="width: 380px">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">요소 조정</h4>
                <button class="btn close-object-wrap"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="d-flex flex-row gap-3">

                <div class="flex-grow-1 d-flex flex-column gap-3">
                    <div class="d-flex justify-content-center oject-menu-title">정렬</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="left"> <i><img alt="" src="/canvas/easycanvas/easycv_icon_left.png" /></i>왼쪽 맞춤</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="center"> <i><img alt="" src="/canvas/easycanvas/easycv_icon_center.png" /></i>가운데 맞춤</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="right"> <i><img alt="" src="/canvas/easycanvas/easycv_icon_right.png" /></i>오른쪽 맞춤</div>
                </div>
                <div class="flex-grow-1 d-flex flex-column gap-3">
                    <div class="d-flex justify-content-center oject-menu-title">순서</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val='forward'> <i><img alt="" src="/canvas/easycanvas/easycv_icon_front.png" /></i>앞으로</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val='backward'> <i><img alt="" src="/canvas/easycanvas/easycv_icon_back.png" /></i>뒤로</div>
                </div>
            </div>
            <div class="d-flex flex-column gap-3 mt-3">
                <div class="d-flex justify-content-center oject-menu-title">효과</div>
                <div class="d-flex justify-content-center flex-row gap-3">
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='flipX'><i><img alt="" src="/canvas/easycanvas/easycv_icon_revers.png" /></i>좌우 반전</div>
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='flipY'><i><img alt="" src="/canvas/easycanvas/easycv_icon_invers.png" /></i>상하 반전</div>
                </div>
                <div class="d-flex justify-content-center flex-row gap-3">
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='rotate90'><i><img alt="" src="/canvas/easycanvas/easycv_icon_ro90.png" /></i>90도 회전</div>
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='rotate180'><i><img alt="" src="/canvas/easycanvas/easycv_icon_ro180.png" /></i>180도 회전</div>
                </div>
            </div>
        </div>
    </div>

    <div class="canvas-container d-flex align-items-center flex-grow-1 flex-column" style="height: calc(100vh - 64px);background-color: #f0f0f0;">
        <div class="canvas-scroll d-flex align-items-center flex-column pb-4" style="overflow-y:auto;width: 100%;height: 100%">
            <div class="canvas-wrap d-flex align-items-center justify-content-between flex-column " >
                <div class="canvas-page d-flex flex-column mt-3 position-relative" data-idx="0">
                    <div class="d-flex flex-row align-items-center justify-content-between mb-2 contents-wrap-header">

                        <div class="d-flex align-items-center justify-content-center" style="padding-bottom: 1px;">
                            <span style="width: 70px;">1&nbsp;페이지</span>
                        </div>
                        <div class="icon-group d-flex flex-row">
                            <!--                        <button class="btn btn-xs"> <i class="fa-solid fa-plus"></i> </button>-->
                            <button class="btn btn-xs btnPageCopy" data-idx="0"> <i class="fa-regular fa-copy"></i> </button>
                            <button class="btn btn-xs"> <i class="fa-solid fa-arrow-up"></i> </button>
                            <button class="btn btn-xs mvScroll" data-act="down" data-idx="0" > <i class="fa-solid fa-arrow-down"></i> </button>
                            <button class="btn btn-xs btnPageDel" data-idx="0"> <i class="fa-solid fa-trash"></i> </button>
                        </div>
                    </div>
                    <div class="wrapCanvas mb-2" style="background-color: #fff;">
                        <canvas id="cvBase0" class="cvBase" style="width: <?=$nCanvasWidth*($zoom/2)?>px;height: <?=$nCanvasHeight*($zoom/2)?>px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center" style="width: <?=$nCanvasWidth*($zoom/2)?>px;">
                <button class="btn btn-secondary w-100 canvas-add-page" onclick="addPage();"> <i class="fa-solid fa-plus"></i> 페이지 추가 </button>
            </div>
        </div>

        <!-- 하단 fixed -->
        <div class="w-100">

            <div class="d-flex bg-white border-top py-2 shadow-lg justify-content-between px-5">

                <div class="d-flex flex-row">
                    <label class="d-flex align-items-center px-3">사이즈 조절</label>
                    <div class="d-flex flex-row">
                        <button class="btn btn-xs emRotate flex-grow-1 d-flex align-items-center <?php if($emRotate == 'L'){?> active <?php }?>" data-val="L" title="가로 형태">
                            <span class="d-inline-block" style="border: 1px #333 solid;background-color: #f8f8f8;width: 22px;height: 15px;">&nbsp;</span>
                        </button>
                        <button class="btn btn-xs emRotate flex-grow-1 d-flex align-items-center <?php if($emRotate == 'P'){?> active <?php }?>" data-val="P" title="세로 형태">
                            <span class="d-inline-block" style="border: 1px #333 solid;background-color: #f8f8f8;width: 15px;height: 22px;">&nbsp;</span>
                        </button>
                        <button class="btn btn-xs emRotate flex-grow-1 d-flex align-items-center <?php if($emRotate == 'S'){?> active <?php }?>" data-val="S" title="정사각 형태">
                            <span class="d-inline-block" style="border: 1px #333 solid;background-color: #f8f8f8; width: 22px;height: 22px;">&nbsp;</span>
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-row">
                    <div class="input-group justify-content-end">
                        <button class="btn btn-xs" onclick="procZoom(<?=$zoom?>)"><i class="fa-solid fa-expand"></i></button>
                        <button class="btn btn-xs btnZoomOut"><i class="fa-solid fa-minus"></i></button>
                        <div class="position-relative" style="width: 25%">
                            <input type="text" value="" class="btnZoomScale form-control text-center" name="btnZoomScale" title="btnZoomScale" style="padding-right: 1.5rem" />
                            <i class="fa-solid fa-percent position-absolute" style="top: 9.5px;right:11px;color: #777;"></i>
                        </div>
                        <button class="btn btn-xs btnZoomIn"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</main>

<!-- 우클릭 메뉴 -->
<div class='objPopMenu'>
    <div class='btnCT btnObject' cmd='copy'><img alt="" src='/canvas/easycanvas/easycv_icon_copy.png'>복사하기</div>
    <div class='btnCT' cmd='paste'><img alt="" src='/canvas/easycanvas/easycv_icon_paste.png'>붙여넣기</div>
    <div class='btnCT btnObject' cmd='forward'><img alt="" src='/canvas/easycanvas/easycv_icon_front.png'>앞으로 가져오기</div>
    <div class='btnCT btnObject' cmd='forwardFirst'><img alt="" src='/canvas/easycanvas/easycv_icon_frontfirst.png' style='margin:6px 6px 7px 7px;'>맨 앞으로 가져오기</div>
    <div class='btnCT btnObject' cmd='backward'><img alt="" src='/canvas/easycanvas/easycv_icon_back.png'>뒤로 보내기</div>
    <div class='btnCT btnObject' cmd='backwardLast'><img alt="" src='/canvas/easycanvas/easycv_icon_backlast.png' style='margin:6px 6px 7px 7px;'>맨 뒤로 보내기</div>
    <div class='btnCT btnObject' cmd='flipX'><img alt="" src='/canvas/easycanvas/easycv_icon_revers.png'>좌우반전</div>
    <div class='btnCT btnObject' cmd='flipY'><img alt="" src='/canvas/easycanvas/easycv_icon_invers.png'>상하반전</div>
    <div class='btnCT btnObject' cmd='rotate90'><img alt="" src='/canvas/easycanvas/easycv_icon_ro90.png'>90도 회전</div>
    <div class='btnCT btnObject' cmd='rotate180'><img alt="" src='/canvas/easycanvas/easycv_icon_ro180.png'>180도 회전</div>
    <div class='btnCT btnObject btnGroup' cmd='group'><img alt="" src='/canvas/easycanvas/easycv_icon_group.png'>그룹으로 묶기</div>
    <div class='btnCT btnObject btnUnGroup' cmd='ungroup'><img alt="" src='/canvas/easycanvas/easycv_icon_ungroup.png'>그룹해제</div>
</div>

<!-- 페이지 load시 load할 템플릿정보-->
<input type="hidden" value="<?=$aInput['template_id']?>" name="nLoadIdx" id="nLoadIdx"/>
<input type="hidden" value="<?=$aInput['type']?>" name="loadType" id="loadType"/>

<!-- 동적처리를 위한 iframe -->
<iframe name='hiddenFrame' width='0' height='0' style="display: none;"></iframe>

<!-- 다운로드 form -->
<FORM name='frmDown' id='frmDown' method='post' target='hiddenFrame' action='/Canvas/download'>
    <input type='hidden' name='aImgData' id='aImgData'>
    <input type='hidden' name='commitType' value='saveImg'>
    <input type='hidden' name='vcSaveTitle' id='vcSaveTitle' value=''>
</FORM>

<!-- 저장하기 form -->
<FORM name='frmSave' id='frmSave' method='post' action='/TemplateManagement/upsert'>
    <input type='hidden' name='save_type' id='save_type' value="<?=$aInput["type"]?>">
    <input type='hidden' name='template_id' id='template_id' value="<?=$aInput["template_id"]?>">
    <input type='hidden' name='title' id='title' value="">
    <input type='hidden' name='page' id='page' value=''>
    <input type='hidden' name='rotate' id='rotate' value="">
    <input type='hidden' name='use_flag' id='use_flag' value="I">
    <input type='hidden' name='thumb_file' id='thumb_file' value=''>
    <input type='hidden' name='blob_data' id='blob_data' value=''>
</FORM>

<!-- 슬라이드 form -->
<FORM name='frmSlide' id='frmSlide' method='post'>
    <input type='hidden' name='aSlideData' id='aSlideData'>
</FORM>

<script type="text/javascript" src="/canvas/js/jquery.justifiedGallery.min.js"></script>
<script type="text/javascript" src="/canvas/js/ezcvs.min.js"></script>
<script type="text/javascript" src="/canvas/js/ezcvsc_dev.js?<?=time()?>"></script>
<!-- JS Form -->
<?=link_src_html('/js/jquery.form.js','js') ?>

<script type="text/javascript">
    var nCanvasWidth = <?=$nCanvasWidth?>; //캔버스 사이즈 W
    var nCanvasHeight = <?=$nCanvasHeight?>; // 캔버스 사이즈 H
    var init_zoom = '<?=$zoom?>';
    var per_page = '<?=$per_page?>'; //페이지당
</script>

<img src="" class="dummy_img" style="visibility: hidden;position: absolute;top: 0;left: 0;z-index: -1;" />
<?=csrf_field()?>
</body>


<script>
</script>


</html>
