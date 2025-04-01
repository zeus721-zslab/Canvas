<?php
/**
 * @var int $nCanvasWidth '기본가로사이즈'
 * @var int $nCanvasHeight '기본세로사이즈'
 * @var float $zoom '기본줌'
 * @var string $emRotate '기본형태( L | S | P )'
 * @var array $aInput '입력값'
 * @var array $aInfo '컨텐츠 기본정보'
 * @var int $per_page '페이지당 갯수'
 * @var string $act '페이지 실행 후 자동액션 : down'
 **/

$canvas_title = '';
if($aInput['type'] == 'my') $canvas_title = $aInfo['title'];

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>킨더캔버스</title>
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

    <!-- font css   -->
    <?=link_src_html('/css/font.css' , 'css')?>
    <!--  Reset Css  -->
    <?=link_src_html('/css/reset.css' , 'css')?>
    <!--  Normalize Css  -->
    <?=link_src_html('/css/normalize.css' , 'css')?>
    <!--  Bootstrap Css-->
    <?=link_src_html('/css/bootstrap.min.css' , 'css')?>
    <!--  de canvas Css-->
    <?=link_src_html('/css/de_app.css' , 'css')?>
    <!--  justifiedGallery css  -->
    <?=link_src_html('/css/justifiedGallery.min.css' , 'css')?>
    <!-- jquery ui css -->
    <?=link_src_html('/css/jquery-ui.theme.css' , 'css')?>
    <?=link_src_html('/css/jquery-ui.css' , 'css')?>
    <!-- contextMenu css -->
    <?=link_src_html('/css/jquery.contextMenu.min.css' , 'css')?>
    <!-- loader css-->
    <?=link_src_html('/css/loader.css','css')?>
    <!-- loader css-->
    <?=link_src_html('/js/webfont.js','js')?>
    <!-- font-awesome css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--  webfont -->
<!--    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" async></script>-->

    <style>
         .contents-list-wrap img.paid-mark
        ,.result-list-wrap img.paid-mark{width: 30px!important;top: 5px;right:5px;z-index: 9}
         .btnSave.disabled{border-color: #f09090;}
    </style>
</head>

<body>
<div id="objLoading"></div>
<div class="wrapProgress" title="글씨체 불러오고 있어요!">
    <div class="progress-label">불러오기</div>
    <div id="progressbar"></div>
</div>
<header class="d-flex align-items-center border-bottom">
    <div class="flex-grow-0 d-flex align-items-center all-menu position-relative justify-content-center" >
        <a href="<?=route_to('Category','month')?>"><img src="/img/simbol.png" alt="simbol" style="width: 32px;" /></a>
        <span class="d-none">전체메뉴</span>
    </div>

    <div class="d-flex justify-content-between flex-grow-1 flex-column flex-lg-row py-2 gap-2 py-lg-0 gap-lg-0">
        <!-- 뒤/앞으로가기 >-->
        <div class="d-none d-lg-flex" style="width: 84px">
            <button class="btn btnUnDo"><i class="fa-solid fa-rotate-left" style="color:#211714"></i></button>
            <button class="btn btnReDo"><i class="fa-solid fa-rotate-right" style="color:#211714"></i></button>
        </div>

        <div class="d-flex align-items-center justify-content-center" style="width: 270px">
            <input type="text" class="form-control" value="<?=$canvas_title?>" name="top_title" title="" placeholder="제목을 입력해주세요." />
        </div>
        <div class="d-flex gap-2">
            <button class="btn btnSave" style="background-color: #f09090;">저장하기</button>
            <button class="btn btnDownload" style="background-color: #faeaab;">다운로드</button>
            <button class="btn btnSlide" style="background-color: #abd5f2;">슬라이드</button>
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
                        <i class="fa-solid fa-table-columns"></i>
                        <span>템플릿</span>
                    </div>
                </li>
                <li>
                    <div data-val="_upload">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>업로드</span>
                    </div>
                </li>
                <li>
                    <div data-val="_clip">
                        <i class="fa-solid fa-shapes"></i>
                        <span>요소</span>
                    </div>
                </li>
                <li>
                    <div data-val="_text">
                        <i class="fa-solid fa-t"></i>
                        <span>텍스트</span>
                    </div>
                </li>
                <li>
                    <div data-val="_bg">
                        <i class="fa-regular fa-square"></i>
                        <span>배경</span>
                    </div>
                </li>
            </ul>
            <!-- LEFT 메뉴 닫기 버튼 -->
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
        <div oncontextmenu="return false;" class="d-flex flex-column flex-grow-1 contents-menu-wrap px-3 border-end" style="overflow-y:auto"> </div>

        <!-- object menu  -->
        <div class="d-none flex-column flex-grow-1 object-wrap px-3 border-end gap-3 mt-4" style="width: 380px">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">요소 조정</h4>
                <button class="btn close-object-wrap"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="d-flex flex-row gap-3">
                <div class="flex-grow-1 d-flex flex-column gap-3">
                    <div class="d-flex justify-content-center oject-menu-title">정렬</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="left"> <i><img alt="" src="/images/easycanvas/easycv_icon_left.png" /></i>왼쪽 맞춤</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="center"> <i><img alt="" src="/images/easycanvas/easycv_icon_center.png" /></i>가운데 맞춤</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val="right"> <i><img alt="" src="/images/easycanvas/easycv_icon_right.png" /></i>오른쪽 맞춤</div>
                </div>
                <div class="flex-grow-1 d-flex flex-column gap-3">
                    <div class="d-flex justify-content-center oject-menu-title">순서</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val='forward'> <i><img alt="" src="/images/easycanvas/easycv_icon_front.png" /></i>앞으로</div>
                    <div class="d-flex justify-content-center align-items-center btnAlign" data-val='backward'> <i><img alt="" src="/images/easycanvas/easycv_icon_back.png" /></i>뒤로</div>
                </div>
            </div>

            <div class="d-flex flex-column gap-3 mt-3">
                <div class="d-flex justify-content-center oject-menu-title">효과</div>
                <div class="d-flex justify-content-center flex-row gap-3">
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='flipX'><i><img alt="" src="/images/easycanvas/easycv_icon_revers.png" /></i>좌우 반전</div>
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='flipY'><i><img alt="" src="/images/easycanvas/easycv_icon_invers.png" /></i>상하 반전</div>
                </div>
                <div class="d-flex justify-content-center flex-row gap-3">
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='rotate90'><i><img alt="" src="/images/easycanvas/easycv_icon_ro90.png" /></i>90도 회전</div>
                    <div class="d-flex align-items-center justify-content-center btnAlign" data-val='rotate180'><i><img alt="" src="/images/easycanvas/easycv_icon_ro180.png" /></i>180도 회전</div>
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

<div id="alert-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="paid-form" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<!-- 우클릭 메뉴 -->
<div class='objPopMenu'>
    <div class='btnCT btnObject' cmd='copy'><img alt="" src='/images/easycanvas/easycv_icon_copy.png'>복사하기</div>
    <div class='btnCT' cmd='paste'><img alt="" src='/images/easycanvas/easycv_icon_paste.png'>붙여넣기</div>
    <div class='btnCT btnObject' cmd='forward'><img alt="" src='/images/easycanvas/easycv_icon_front.png'>앞으로 가져오기</div>
    <div class='btnCT btnObject' cmd='forwardFirst'><img alt="" src='/images/easycanvas/easycv_icon_frontfirst.png' style='margin:6px 6px 7px 7px;'>맨 앞으로 가져오기</div>
    <div class='btnCT btnObject' cmd='backward'><img alt="" src='/images/easycanvas/easycv_icon_back.png'>뒤로 보내기</div>
    <div class='btnCT btnObject' cmd='backwardLast'><img alt="" src='/images/easycanvas/easycv_icon_backlast.png' style='margin:6px 6px 7px 7px;'>맨 뒤로 보내기</div>
    <div class='btnCT btnObject' cmd='flipX'><img alt="" src='/images/easycanvas/easycv_icon_revers.png'>좌우반전</div>
    <div class='btnCT btnObject' cmd='flipY'><img alt="" src='/images/easycanvas/easycv_icon_invers.png'>상하반전</div>
    <div class='btnCT btnObject' cmd='rotate90'><img alt="" src='/images/easycanvas/easycv_icon_ro90.png'>90도 회전</div>
    <div class='btnCT btnObject' cmd='rotate180'><img alt="" src='/images/easycanvas/easycv_icon_ro180.png'>180도 회전</div>
    <div class='btnCT btnObject btnGroup' cmd='group'><img alt="" src='/images/easycanvas/easycv_icon_group.png'>그룹으로 묶기</div>
    <div class='btnCT btnObject btnUnGroup' cmd='ungroup'><img alt="" src='/images/easycanvas/easycv_icon_ungroup.png'>그룹해제</div>
</div>

<!-- 페이지 load시 load할 템플릿정보-->
<input type="hidden" value="<?=$aInput['template_id']?>" name="nLoadIdx" id="nLoadIdx"/>
<input type="hidden" value="<?=$aInput['type']?>" name="loadType" id="loadType"/>
<input type='hidden' value="<?=$aInput["my_canvas_id"]?>" name='nIdx' id='nDataIdx'>

<!-- 동적처리를 위한 iframe -->
<iframe name='hiddenFrame' width='0' height='0' style="display: none;"></iframe>

<!-- 다운로드 form -->
<FORM name='frmDown' id='frmDown' method='post' target='hiddenFrame' action='/Canvas/download'>
    <input type='hidden' name='aImgData' id='aImgData'>
    <input type='hidden' name='commitType' value='saveImg'>
    <input type='hidden' name='vcSaveTitle' id='vcSaveTitle' value=''>
</FORM>

<!-- 저장하기 form -->
<FORM name='frmSave' id='frmSave' method='post' action='/Canvas/upsert'>
    <input type='hidden' name='save_type' id='save_type' value="<?=$aInput["type"]?>">
    <input type='hidden' name='my_canvas_id' id='my_canvas_id' value="<?=$aInput["my_canvas_id"]?>">
    <input type='hidden' name='title' id='title' value="">
    <input type='hidden' name='page' id='page' value=''>
    <input type='hidden' name='rotate' id='rotate' value="">
    <input type='hidden' name='thumb_file' id='thumb_file' value=''>
    <input type='hidden' name='blob_data' id='blob_data' value=''>
    <input type='hidden' name='last_modified' id="last_modified" value='<?=$aInfo['mod_date']?:$aInfo['reg_date']?>'>
    <input type='hidden' name='bg_save' id="bg_save" value=''>
</FORM>

<!-- 슬라이드 form -->
<FORM name='frmSlide' id='frmSlide' method='post'>
    <input type='hidden' name='aSlideData' id='aSlideData'>
</FORM>

<script type="text/javascript">
    var nCanvasWidth = <?=$nCanvasWidth?>; //캔버스 사이즈 W
    var nCanvasHeight = <?=$nCanvasHeight?>; // 캔버스 사이즈 H
    var init_zoom = '<?=$zoom?>';
    var per_page = '<?=$per_page?>'; //페이지당
    var act = '<?=$act?>'; //페이지 실행 후 자동액션
    var paid_user = '<?=session('isPay') ? 'Y' : 'N' ?>';
</script>
<!-- fontawesome icons -->
<!--<script src="https://kit.fontawesome.com/a55104e283.js" crossorigin="anonymous"></script>-->
<!-- jquery  -->
<?=link_src_html('/js/jquery-1.9.1.min.js' , 'js')?>
<!-- contextMenu js  -->
<?=link_src_html('/js/jquery.contextMenu.js' , 'js')?>
<!-- jquery ui  -->
<?=link_src_html('/js/jquery-ui-1.11.4.js' , 'js')?>
<!-- bootstrap Js  -->
<?=link_src_html('/js/bootstrap.min.js' , 'js')?>
<!-- loader js-->
<?=link_src_html('/js/loader.js','js')?>
<!-- justifiedGallery js -->
<?=link_src_html('/js/jquery.justifiedGallery.min.js','js') ?>
<!-- fabric js -->
<?=link_src_html('/js/ezcvs.min.js','js') ?>
<!-- fabric js handler -->
<?php if(isTest()){?>
    <?=link_src_html('/js/ezcvsc_dev.js','js') ?>
<!--    --><?php //=link_src_html('/js/ez.min.js','js') ?>
<?php }else {?>
    <?=link_src_html('/js/ez.min.js','js') ?>
<?php }?>
<!-- JS Form -->
<?=link_src_html('/js/jquery.form.js','js') ?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>

<img src="" class="dummy_img" alt="dummy_img" style="visibility: hidden;position: absolute;top: 0;left: 0;z-index: -1;max-width: 100dvw;" />
<?=csrf_field()?>
</body>

</html>
