<?php
/**
 * @var array $aInfo '회원정보'
 * @var array $aList '주문리스트'
 * @var array $isAbleSSO 'SSO 가능여부'
 *
 */

$user_info = $aInfo['login_id'].'&nbsp;('.$aInfo['username'].')';

if($aInfo['sns_site'] == 1){
    $user_info = '<button class="btn btn-xs btn-warning">카카오 간편가입</button>&nbsp;('.$aInfo['username'].')';
}else if($aInfo['sns_site'] == 2){
    $user_info = '<button class="btn btn-xs btn-success">네이버 간편가입</button>&nbsp;('.$aInfo['username'].')';
}

?>
<!DOCTYPE html>
<html lang="ko"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>킨더 캔버스 관리자 | 회원정보 팝업</title><!--begin::Primary Meta Tags-->
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
    <script src="https://kit.fontawesome.com/a55104e283.js" crossorigin="anonymous"></script>
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
    <style>
        ul.--pop-memberinfo-tab {}
        ul.--pop-memberinfo-tab li{width: 25%;}
        ul.--pop-memberinfo-tab li a {display: inline-block;width: 100%;text-align: center;padding: .75rem 0;border: 1px solid #ccc;border-left: 0;box-sizing: border-box}
        ul.--pop-memberinfo-tab li:first-child a{border-left: 1px solid #ccc;}
        ul.--pop-memberinfo-tab li a.active{background-color: #f8f8f8;border-bottom: 0;}
    </style>

</head> <!--end::Head--> <!--begin::Body-->

<body> <!--begin::App Wrapper-->

    <div class="d-flex flex-column w-100 p-3">
        <div class="d-flex justify-content-between mb-3">
            <span class="fs-5 d-flex align-items-center">■&nbsp;ID&nbsp;:&nbsp;<?=$user_info?></span>
            <?php if($isAbleSSO){?>
                <a role="button" class="btn btn-xs btn-danger" href="https://www.kindercanvas.co.kr/auth/a/verify?login_id=<?=$aInfo['login_id']?>" target="_blank" >로그인</a>
            <?php }?>
        </div>
        <ul class="w-100 d-flex list-unstyled --pop-memberinfo-tab">
            <li><a class="text-decoration-none" role="button" href="/UserManagement/member_info_pop?id=<?=$aInfo['id']?>">회원정보</a></li>
            <li><a class="active text-decoration-none" href="/UserManagement/order_info_pop?id=<?=$aInfo['id']?>">주문내역</a></li>
            <li><a class="text-decoration-none" href="/UserManagement/qna_info_pop?id=<?=$aInfo['id']?>">1:1문의</a></li>
            <li><a class="text-decoration-none" href="/UserManagement/login_info_pop?id=<?=$aInfo['id']?>">로그인내역</a></li>
        </ul>
        <div class="container-fluid">
            <div class="row">
                <table class="table table-bordered my-3">

                    <thead>
                    <tr>
                        <th class="bg-light text-center">VNO</th>
                        <th class="bg-light text-center">주문번호</th>
                        <th class="bg-light text-center">결제정보</th>
                        <th class="bg-light text-center">이용기간</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($aList as $k => $r) {
                        //card:신용카드 / vcnt:가상계좌 / fixed_vacc:고정계좌 / phone:휴대폰결제
                        $paymethod = '';
                        if($r['o_paymethod'] == 'card'){
                            $paymethod = '&nbsp;<span class="px-1 bg-primary d-flex align-items-center" style="font-size: .75rem;color:#fff;border-radius: 2px;">Card</span>';
                        }else if($r['o_paymethod'] == 'vcnt'){
                            $paymethod = '&nbsp;<span class="px-1 bg-success d-flex align-items-center" style="font-size: .75rem;color:#fff;border-radius: 2px;">가상계좌</span>';
                        }else if($r['o_paymethod'] == 'phone') {
                            $paymethod = '&nbsp;<span class="px-1 bg-info d-flex align-items-center" style="font-size: .75rem;color:#fff;border-radius: 2px;">휴대폰</span>';
                        }else if($r['o_paymethod'] == 'fixed_vacc') {
                            $paymethod = '&nbsp;<span class="px-1 bg-warning d-flex align-items-center" style="font-size: .75rem;color:#fff;border-radius: 2px;">고정계좌</span>';
                        }
                    ?>

                        <tr>
                            <td class="text-center"><?=$k+1?></td>
                            <td class="text-center"><?=$r['order_id']?></td>
                            <td class="text-center">
                                <?php if($r['pay_flag'] == 'R'){?>
                                    <span class="d-flex align-items-center justify-content-center">사전 데이터<?=$paymethod?></span>
                                <?php } else if($r['pay_flag'] == 'W'){?>
                                    <span class="d-flex align-items-center justify-content-center">입금 전<?=$paymethod?></span>
                                <?php } else if($r['pay_flag'] == 'C'){?>
                                    <span class="d-flex align-items-center justify-content-center">결제취소<?=$paymethod?></span>
                                <?php } else if($r['pay_flag'] == 'Y'){?>
                                    <span class="d-flex align-items-center justify-content-center">결제완료<?=$paymethod?></span>
                                    <span>( <?=view_date_format($r['pay_date'])?> )</span>
                                <?php }?>
                            </td>

                            <td class="text-center">
                                <?php if($r['pay_flag'] == 'Y'){?>
                                    <span><?=view_date_format($r['s_use_date'],5)?> ~ <?=view_date_format($r['e_use_date'],5)?></span>
                                <?php } else {?>

                                <?php }?>
                            </td>
                        </tr>

                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>