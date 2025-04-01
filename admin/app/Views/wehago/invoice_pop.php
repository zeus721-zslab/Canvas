<?php

/**
 * @var array $aInfo '주문정보'
 **/

//zsView($aInfo);

?>
<!DOCTYPE html>
<html lang="ko"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>킨더 캔버스 관리자 | 세금계산서 발급</title><!--begin::Primary Meta Tags-->
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
    <!--  require js -->
    <?=link_src_html('/js/jquery.cookie.js' , 'js')?>
    <!--  wehago_globals  -->
    <?=link_src_html('/js/wehago_globals.js' , 'js')?>
    <!-- JS Form -->
    <?=link_src_html('/js/jquery.form.js','js') ?>

    <script type="text/javascript" src="https://static.wehago.com/support/wehago.0.1.6.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://static.wehago.com/support/wehagoLogin-1.1.7.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://static.wehago.com/support/service/common/wehagoCommon-0.3.1.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://static.wehago.com/support/service/invoice/wehagoInvoice-0.1.0.js" charset="utf-8"></script>


</head> <!--end::Head--> <!--begin::Body-->

<body> <!--begin::App Wrapper-->

    <div class="d-flex w-100 p-3">

        <div class="card w-100">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span class="d-flex align-items-center">세금계산서</span>

                    <?php if($aInfo['eTaxType'] != 'P'){ ?>
                    <span class="d-flex align-items-center">
                        <button class="btn btn-success" id="btnSave" type="button">세금계산서 발행하기</button>
                    </span>
                    <?php } ?>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-bordered w-100 mb-4 fs-7">
                    <tr>
                        <td colspan="4" class="bg-secondary text-white fs-6 py-2">기본 주문정보</td>
                    </tr>
                    <tr>
                        <th class="bg-light">주문번호</th>
                        <td><?=$aInfo['order_id']?></td>
                        <th class="bg-light">상품명</th>
                        <td><?=$aInfo['good_name']?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">주문자</th>
                        <td><?=$aInfo['o_name']?></td>
                        <th class="bg-light">연락처</th>
                        <td><?=$aInfo['o_celltel']?></td>
                    </tr>
                    <tr>
                        <th class="bg-light">결제방법</th>
                        <td>
                            <?php if($aInfo['o_paymethod'] == 'card'){?>
                                <b class="text-danger">카드</b>
                            <?php }else if($aInfo['o_paymethod'] == 'vcnt'){?>
                                <b class="text-primary">가상계좌</b>
                            <?php }else if($aInfo['o_paymethod'] == 'fixed_vacc'){?>
                                <b class="text-primary">고정계좌</b>
                            <?php }else if($aInfo['o_paymethod'] == 'phone'){?>
                                <b class="text-primary">휴대폰</b>
                            <?php } ?>
                        </td>
                        <th class="bg-light">결제금액</th>
                        <td><?=number_format($aInfo['amount'])?>원</td>
                    </tr>
                    <tr>
                        <th class="bg-light">결제완료 여부</th>
                        <td>
                            <?php if($aInfo['pay_flag'] == 'Y'){?>
                                <b class="text-primary">결제완료</b>
                            <?php } else {?>
                                <b class="text-danger">결제안됨</b>
                            <?php } ?>
                        </td>

                        <th class="bg-light">계산서 발행처리여부</th>
                        <td colspan="3">
                            <?php if($aInfo['eTaxType'] == 'N'){?>
                                <button class="btn btn-xs btn-warning">발행 전</button>
                            <?php } else if($aInfo['eTaxType'] == 'P'){?>
                                <button class="btn btn-xs btn-primary">발행완료</button>
                            <?php } else if($aInfo['eTaxType'] == 'C'){?>
                                <button class="btn btn-xs btn-danger">발행취소</button>
                            <?php } else {?>
                                <button class="btn btn-xs btn-danger">ERROR</button>
                            <?php } ?>
                        </td>
                    </tr>
                </table>

                <form name="frmInvoice" id="frmInvoice" method="post" action="/Wehago/taxUpsert">
                    <input type="hidden" name="nIdx" value="<?=$aInfo['nIdx']?>">
                    <input type="hidden" name="nOrdIdx" value="<?=$aInfo['order_id']?>">
                    <input type="hidden" name="eState" value="<?=$aInfo['eState']?>">
                    <input type="hidden" name="eTaxType" value="<?=$aInfo['eTaxType']?>">
                    <input type="hidden" name="bizNoStatus" id="bizNoStatus" value="N">
                    <input type="hidden" name="wcNo" value="">

                    <table class="table table-bordered w-100 fs-7">
                        <tr>
                            <td colspan="4" class="bg-secondary text-white  fs-6 py-2">세금 계산서 발행 정보</td>
                        </tr>

                        <tr>
                            <th class="bg-light">계산서 발행 주체</th>
                            <td colspan="3">(주)꼬망세미디어</td>
                        </tr>
                        <tr>
                            <th class="bg-light">상호명</th>
                            <td> <input type="text" name="wTaxCompany" value="<?=$aInfo['cash_name']?>" title="" class="form-control" /> </td>
                            <th class="bg-light">대표자</th>
                            <td> <input type="text" name="wTaxCEO" value="<?=$aInfo['cash_ceo']?>" title="" class="form-control" /> </td>
                        </tr>
                        <tr>
                            <th class="bg-light">연락처</th>
                            <td> <input type="text" name="wTaxMobile" value="<?=$aInfo['o_celltel']?>" title="" class="form-control" /> </td>
                            <th class="bg-light">이메일</th>
                            <td> <input type="text" name="wTaxEmail" value="<?=$aInfo['cash_email']?>" title="" class="form-control" /> </td>
                        </tr>
                        <tr>
                            <th class="bg-light">사업자번호</th>
                            <td colspan="3">
                                <div class="input-group mb-2">
                                    <input type="text" name="wTaxCompNo" value="<?=$aInfo['cash_no']?>" title="" class="form-control" />
                                    <button class="btn btn-xs btn-danger" type="button" onclick="bizStatus();">사업자번호진위확인</button>
                                </div>
                                <label class="d-flex align-items-center">
                                    <span id="bizResult"></span>
                                    <input type="checkbox" name="bizResultPass" value="1" />&nbsp;<span class="fs-7">사업자번호진위확인패스</span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">주소</th>
                            <td colspan="3"> <input type="text" name="wTaxAddr" value="<?=$aInfo['cash_address']?>" title="" class="form-control" /> </td>
                        </tr>

                        <tr>
                            <th class="bg-light">청구유형</th>
                            <td>
                                <div class="d-flex gap-3 align-items-center">
                                    <label><input type="radio" name="eFgBill" value="2" <?=$aInfo['eFgBill'] == 2 ? 'checked' : '' ?> />&nbsp;영수</label>
                                    <label><input type="radio" name="eFgBill" value="1" <?=$aInfo['eFgBill'] == 1 ? 'checked' : '' ?> />&nbsp;청구</label>
                                </div>
                            </td>
                            <th class="bg-light">작성월일</th>
                            <td>
                                <div class="d-flex gap-3">
                                    <div class="d-flex align-items-center"><input type="text" name="vcMmWrite" value="<?=date('m')?>" class="form-control" style="width: 60px;">&nbsp;월</div>
                                    <div class="d-flex align-items-center"><input type="text" name="vcDdWrite" value="<?=date('d')?>" class="form-control" style="width: 60px;">&nbsp;일</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th class="bg-light">품명</th>
                            <td> <input type="text" name="wNmItem" value="<?=$aInfo['good_name']?>" title="" class="form-control" /> </td>
                            <th class="bg-light">공급가액</th>
                            <td> <input type="text" name="wAm" value="<?=$aInfo['supply_amount']?>" title="" class="form-control" /> </td>
                        </tr>


                        <tr>
                            <th class="bg-light">부가세액</th>
                            <td> <input type="text" name="wAmVat" value="<?=$aInfo['vat_amount']?>" title="" class="form-control" /> </td>
                            <th class="bg-light">합계금액</th>
                            <td> <input type="text" name="wAmt" value="<?=$aInfo['amount']?>" title="" class="form-control" /> </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <textarea name="wAdminMemo"  rows="4" class="form-control"><?=$aInfo['wAdminMemo']?></textarea>
                            </td>
                        </tr>

                    </table>

                    <div class="d-flex flex-column log-area gap-1">
                        <label class="d-flex align-items-center"><span class="d-flex" style="width: 120px;">CNO :</span> <input type="text" id="log_cno" value="" disabled class="form-control" /></label>
                        <label class="d-flex align-items-center"><span class="d-flex" style="width: 120px;">access_token :</span> <input type="text" id="log_access_token" value="" disabled class="form-control"  /></label>
                        <label class="d-flex align-items-center"><span class="d-flex" style="width: 120px;">wehago_id :</span> <input type="text" id="log_wehago_id" value="" disabled class="form-control" /></label>
                        <label class="d-flex align-items-center"><span class="d-flex" style="width: 120px;">service_token :</span> <input type="text" id="log_service_token" value="" disabled class="form-control" /></label>
                    </div>

                </form>

            </div>

        </div>

    </div>

<script type="text/javascript">
    var defaultInfo = {};
    <?php if(0) { ?>
    defaultInfo = {
        "FG_FINAL": "1",
        "FG_IO": "1",
        "FG_PC": "1",
        "FG_VAT": "1",
        "YN_CSMT" : "N",
        "YN_TURN" : "Y",
        "YN_CERT": "Y",
        "CD_SVC":keyInfo.service_code,
        "TB_SERVICE_CD_SVC":"100W",
        "cno" : setting.test.CNO,
        "SELL_NO_BIZ": setting.test.SELL_NO_BIZ,
    };
    <?php } else { ?>
    defaultInfo = {
        "FG_FINAL": "1",
        "FG_IO": "1",
        "FG_PC": "1",
        "FG_VAT": "1",
        "YN_CSMT" : "N",
        "YN_TURN" : "Y",
        "YN_CERT": "Y",
        "CD_SVC":keyInfo.service_code,
        "TB_SERVICE_CD_SVC":"100W",
        "cno" : setting.edupre.CNO,
        "SELL_NO_BIZ": setting.edupre.SELL_NO_BIZ,
    };
    <?php } ?>

    var companyInfo = {
        "NM_SENDER_SYS": "WEHAGO_edupre_media_content",
        "SELL_ADDR1": "서울특별시 강남구 논현로76길27 에이포스페이스 5층",
        "SELL_ADDR2": "(역삼동 에이포스페이스)",
        "SELL_DAM_DEPT": "경영지원실",
        "SELL_DAM_EMAIL": "dcom8440@bill36524.com",
        "SELL_NM_CEO": "최남호",
        "SELL_NM_CORP": "(주)꼬망세미디어",
        "SELL_NO_BIZ": defaultInfo.SELL_NO_BIZ,
        "SELL_BIZ_STATUS": "제조",
        "SELL_BIZ_TYPE": "정기간행물",
    };

    var wehago_id_login = new wehago_id_login({
        app_key: keyInfo.app_key,  // AppKey
        service_code: keyInfo.service_code,  // ServiceCode
        mode: keyInfo.mode,  // dev-개발, live-운영 (기본값=live, 운영 반영시 생략 가능합니다.)
    });

    var clientInfo = {}
    var itemSum = {}
    var itemList = [];

    var c_service_token = $.cookie(wehago_id_login.service_code + "_token");
    var c_cno = $.cookie(wehago_id_login.service_code + "_selected_company_no");
    var c_access_token = $.cookie(wehago_id_login.service_code + "_access_token");
    var access_token = wehago_id_login.getAccessToken();

    var wehago_common = new wehago_common({
        app_key: keyInfo.app_key,  // AppKey
        service_code: keyInfo.service_code,  // ServiceCode
        mode: keyInfo.mode,  // dev-개발, live-운영 (기본값=live, 운영 반영시 생략 가능합니다.)
        access_token : access_token,
    });

    var wehago_invoice = new wehago_invoice({
        app_key: keyInfo.app_key,  // AppKey
        service_code: keyInfo.service_code,  // ServiceCode
        mode: keyInfo.mode,  // dev-개발, live-운영 (기본값=live, 운영 반영시 생략 가능합니다.)
        access_token : access_token,
    });

    function WehagoMakeDataSet(info) {

        parsingMobile = info.wTaxMobile.split("-");

        if(defaultInfo.cno === "1731201") {
            biznum = "0007777777";
        } else {
            biznum = info.wTaxCompNo.replace(/-/g,"");
        }
        // 발송용 데이터를 만든다.
        clientInfo = {
            "wIdx": info.nIdx,
            "BUY_ADDR1": info.wTaxAddr,
            "BUY_ADDR2": "",
            "BUY_DAM_EMAIL": info.wTaxEmail,
            "BUY_DAM_MOBIL1":parsingMobile[0],
            "BUY_DAM_MOBIL2":parsingMobile[1],
            "BUY_DAM_MOBIL3":parsingMobile[2],
            "BUY_NM_CEO": info.wTaxCEO,
            "BUY_NM_CORP":info.wTaxCompany,
            "BUY_NO_BIZ":biznum,
            "FG_BILL":info.eFgBill,
            "NO_SENDER_PK":info.nOrdIdx,

        };
        itemSum = {
            "AM": info.wAm,
            "AM_VAT": info.wAmVat,
            "AMT": info.wAmt,
            "YMD_WRITE":<?=date("Ymd")?>
        }
        itemList = [{
            "MM_WRITE":info.vcMmWrite,
            "DD_WRITE":info.vcDdWrite,
            "NM_ITEM":info.wNmItem,
            "AM":info.wAm,
            "AM_VAT":info.wAmVat,
            "AMT":info.wAmt,
            "ITEM_STD":"",
            "QTY":"",
            "UM":"",
            "DC_RMK":""
        }];

        var param = {
            "TB_TAX": {
                "DC_RMK": "",
                "DC_RMK2": "",
                "DC_RMK3": "",
                "FG_VAT": defaultInfo.FG_VAT,
                "YN_TURN": defaultInfo.YN_TURN,
                "FG_IO": defaultInfo.FG_IO,
                "FG_PC": defaultInfo.FG_PC,
                "FG_BILL": clientInfo.FG_BILL,
                "SELL_NO_BIZ": companyInfo.SELL_NO_BIZ,
                "SELL_NM_CORP": companyInfo.SELL_NM_CORP,
                "SELL_NM_CEO": companyInfo.SELL_NM_CEO,
                "SELL_ADDR1": companyInfo.SELL_ADDR1,
                "SELL_ADDR2": companyInfo.SELL_ADDR2,
                "SELL_BIZ_STATUS": companyInfo.SELL_BIZ_STATUS,
                "SELL_BIZ_TYPE": companyInfo.SELL_BIZ_TYPE,
                "SELL_DAM_DEPT": companyInfo.SELL_DAM_DEPT,
                "SELL_DAM_EMAIL": companyInfo.SELL_DAM_EMAIL,
                "SELL_DAM_NM": "",
                "SELL_DAM_TEL1": "",
                "SELL_DAM_TEL2": "",
                "SELL_DAM_TEL3": "",
                "SELL_DAM_MOBIL1": "",
                "SELL_DAM_MOBIL2": "",
                "SELL_DAM_MOBIL3": "",
                "BUY_DAM_TEL1": "",
                "BUY_DAM_TEL2": "",
                "BUY_DAM_TEL3": "",
                "BUY_DAM_MOBIL1": clientInfo.BUY_DAM_MOBIL1,
                "BUY_DAM_MOBIL2": clientInfo.BUY_DAM_MOBIL2,
                "BUY_DAM_MOBIL3": clientInfo.BUY_DAM_MOBIL3,
                "BUY_NO_BIZ": clientInfo.BUY_NO_BIZ,
                "BUY_NM_CORP":  clientInfo.BUY_NM_CORP,
                "BUY_NM_CEO":  clientInfo.BUY_NM_CEO,
                "BUY_ADDR1":  clientInfo.BUY_ADDR1,
                "BUY_ADDR2":  clientInfo.BUY_ADDR2,
                "BUY_BIZ_STATUS": "",
                "BUY_BIZ_TYPE": "",
                "BUY_DAM_DEPT": "",
                "BUY_DAM_NM": "",
                "SELL_REG_ID": "",
                "BUY_REG_ID": "",
                "BUY_DAM_EMAIL": clientInfo.BUY_DAM_EMAIL,
                "AMT": itemSum.AMT,
                "AMT_CASH": itemSum.AMT,
                "AMT_CHECK":0,
                "AMT_NOTE": 0,
                "AMT_AR":0,
                "AM": itemSum.AM,
                "AM_VAT": itemSum.AM_VAT,
                "YMD_WRITE": itemSum.YMD_WRITE,
                "NO_ISSUE": "",
                "NO_VOL": "",
                "NO_SERIAL": "",
                "CD_SVC": defaultInfo.CD_SVC,
                "SEND_RMK": "",
                "FG_TURN": "",
                "FG_FINAL": defaultInfo.FG_FINAL,
                "NM_SENDER_SYS": companyInfo.NM_SENDER_SYS,
                "NO_SENDER_PK": clientInfo.NO_SENDER_PK,
            },
            "TB_TAX_LINE_LIST": itemList,
            "TB_SERVICE": {
                // 과금코드
                "CD_SVC": defaultInfo.TB_SERVICE_CD_SVC
            },
            "YN_MGMT": "N",
            "CERT_INFO": {},
            "YN_CERT": "Y",
            "ccode": "",
            "cno":defaultInfo.cno
        };

        // console.log('------------- WehagoMakeDataSet')
        // console.log(clientInfo);
        // console.log(itemSum);
        // console.log(itemList);
        //
        // console.log("------------- get_invoice_sendtax");
        // console.log(param);

        wehago_invoice.get_invoice_sendtax(callback_get_invoice_sendtax, callback_get_invoice_sendtax_error, param);
        // callback_get_invoice_sendtax({"resultCode":200,"resultMsg":"success","resultData":{ "TB_TAX":{ "tbTaxUp":{ "am":5000, "am_VAT":500, "amt":5500, "amt_AR":0, "amt_CASH":5500, "amt_CHECK":0, "amt_NOTE":0, "no_BLK":9, "sell_NO_BIZ":"2222222227", "buy_ADDR1":" ", "buy_ADDR2":"17-5-33", "buy_BIZ_STATUS":"", "buy_BIZ_TYPE":"", "buy_DAM_DEPT":null, "buy_DAM_EMAIL":"billtest01@duzon.com", "buy_DAM_MOBIL1":null, "buy_DAM_MOBIL2":null, "buy_DAM_MOBIL3":null, "buy_DAM_NM":null, "buy_DAM_TEL1":null, "buy_DAM_TEL2":null, "buy_DAM_TEL3":null, "buy_NM_CEO":"", "buy_NM_CORP":"0001", "buy_NO_BIZ":"1111111119", "dc_RMK":null, "fg_BILL":"2", "fg_IO":"1", "fg_PC":"1", "fg_VAT":"1", "no_ISSUE":null, "no_SERIAL":null, "no_TAX":"TX2018045684868", "no_VOL":null, "sell_ADDR1":"", "sell_ADDR2":"749 IT", "sell_BIZ_STATUS":"", "sell_BIZ_TYPE":" ", "sell_DAM_DEPT":null, "sell_DAM_EMAIL":"billtest02@duzon.com", "sell_DAM_MOBIL1":"010", "sell_DAM_MOBIL2":"5143", "sell_DAM_MOBIL3":"6051", "sell_DAM_NM":"", "sell_DAM_TEL1":"02", "sell_DAM_TEL2":"6233", "sell_DAM_TEL3":"3000", "sell_NM_CEO":" ", "sell_NM_CORP":"22227", "ymd_WRITE":"20180419", "dt_ENTER":"20180419145018", "enter_USER":"201709001326", "dt_UPDATE":null, "update_USER":null, "send_RMK":null, "cd_RESULT":null, "msg_RESULT":null, "nm_SENDER_SYS":null, "no_SENDER_PK":null, "no_UP":null }, "update_USER":null, "NO_CUST":"0000011", "NO_USER":"201709001326", "AM":5000, "AM_VAT":500, "AMT":5500, "AMT_AR":0, "AMT_CASH":5500, "AMT_CHECK":0, "AMT_NOTE":0, "NO_BLK":9, "SELL_NO_BIZ":"2222222227", "APP_NO_USER":null, "BUY_ADDR1":" ", "BUY_ADDR2":"17-5-33", "BUY_BIZ_STATUS":"", "BUY_BIZ_TYPE":"", "BUY_DAM_DEPT":null, "BUY_DAM_EMAIL":"billtest01@duzon.com", "BUY_DAM_MOBIL1":null, "BUY_DAM_MOBIL2":null, "BUY_DAM_MOBIL3":null, "BUY_DAM_NM":null, "BUY_DAM_TEL1":null, "BUY_DAM_TEL2":null, "BUY_DAM_TEL3":null, "BUY_NM_CEO":"", "BUY_NM_CORP":"0001", "BUY_NO_BIZ":"1111111119", "DC_RMK":null, "DC_RMK2":null, "DC_RMK3":null, "FG_BILL":"2", "FG_FINAL":"1", "FG_IO":"1", "FG_PC":"1", "FG_VAT":"1", "IP_APP":null, "NM_SENDER_PK":"API", "NM_SENDER_SYS":"WEHAGO", "NO_ISSUE":null, "NO_SENDER_PK":null, "NO_SERIAL":null, "NO_STARTDAY":null, "NO_TAX":"TX2018045684868", "NO_VOL":null, "SELL_ADDR1":"", "SELL_ADDR2":"749 IT", "SELL_BIZ_STATUS":"", "SELL_BIZ_TYPE":" ", "SELL_DAM_DEPT":null, "SELL_DAM_EMAIL":"billtest02@duzon.com", "SELL_DAM_MOBIL1":"010", "SELL_DAM_MOBIL2":"5143", "SELL_DAM_MOBIL3":"6051", "SELL_DAM_NM":"", "SELL_DAM_TEL1":"02", "SELL_DAM_TEL2":"6233", "SELL_DAM_TEL3":"3000", "SELL_NM_CEO":" ", "SELL_NM_CORP":"22227", "YMD_WRITE":"20180419", "YN_CSMT":"N", "YN_ISS":"0", "YN_TURN":"Y", "TP_FX":"Y", "NO_ISS_SRC":null, "FG_EXPRESS":null, "SELL_REG_ID":null, "BUY_REG_ID":null, "DT_ENTER":"20180419145018", "ENTER_USER":"201709001326", "FG_TURN":"00", "YN_DLV_ISS":"N", "YN_PAPER":null, "DT_UPDATE":null, "NO_ENDDAY":null, "NO_HISTORY":null, "NO_ISS":"201804194100009693313041", "NO_PIN":null, "YMD_ISS":null, "YN_DEL":null, "YN_MAGAM":null, "YN_SIGNS":null, "CD_FX":null, "NO_TX_SRC":null, "YN_FX":"N", "CD_COWK":null, "NO_FX":null, "BUY_DAM2_EMAIL":null, "BUY_DAM2_DEPT":null, "NEW_YMD_WRITE":null, "NO_ISS_SUB":null, "BUY_DAM2_MOBIL1":null, "BUY_DAM2_MOBIL2":null, "BUY_DAM2_MOBIL3":null, "BUY_DAM2_NM":null, "BUY_DAM2_TEL1":null, "BUY_DAM2_TEL2":null, "BUY_DAM2_TEL3":null, "SELL_DAM2_DEPT":null, "SELL_DAM2_EMAIL":null, "SELL_DAM2_MOBIL1":null, "SELL_DAM2_MOBIL2":null, "SELL_DAM2_MOBIL3":null, "SELL_DAM2_NM":null, "SELL_DAM2_TEL1":null, "SELL_DAM2_TEL2":null, "SELL_DAM2_TEL3":null, "YMD_MAGAM":null, "YN_OTHER_SYS":null }, "TB_TAX_LINE_LIST":[ { "AM":5000, "AM_VAT":500, "AMT":5500, "DC_RMK":null, "DT_ENTER":"20180419145018", "ENTER_USER":"ZZ1105785725", "DT_UPDATE":null, "UPDATE_USER":null, "UM":5000, "QTY":1, "ITEM_STD":"EA", "NM_ITEM":"1", "MM_WRITE":"04", "DD_WRITE":"19", "NO_ITEM":"0724746123888", "NO_TAX":"TX2018045684868", "NO_LINE":1 } ], "TB_FX":null, "TB_SERVICE":{ "DT_ENTER":"20170803000000", "ENTER_USER":"SYSTEM", "FG_TURN":null, "DT_UPDATE":null, "UPDATE_USER":null, "CD_SVC":"100W", "UNIT_POINT":0, "DAY_SVC":0, "NM_SVC":" (Email+SMS)", "SC_DATE_ED":null, "SC_DATE_ST":null, "TOTALCNT":null }, "RESULT":"00000", "RESULT_MSG":"" }});;
    }


    //success callback
    function callback_get_invoice_sendtax(response){

        var data        = response.resultData ;
        var resultCode  = data.RESULT;
        var wNoTax      = '';

        if( resultCode === "00000") {
            wNoTax = data.TB_TAX.NO_TAX;
            updateWehagoInfo(clientInfo.wIdx , wNoTax , data , 'P');
        }else{
            updateWehagoInfo(clientInfo.wIdx , wNoTax , data , 'N');
            // 전송실패 - rollback
            alert("[처리실패][CODE:"+resultCode+"] "+data.RESULT_MSG);
        }

    }

    function callback_get_invoice_sendtax_error(response){
        var errors = response.errors ;
        errors.RESULT = errors.code;
        errors.RESULT_MSG = errors.message;

        var data = errors;

        alert('[처리실패][CODE:'+errors.code+'] '+errors.message);
        updateWehagoInfo(clientInfo.wIdx , '' , data , 'N');
    }

    //정보 update
    function updateWehagoInfo(nIdx, wNoTax='', results=[], eTaxType) {

        var params = {"nIdx": nIdx, "wNoTAX": wNoTax, eTaxType : eTaxType , vcResCode : results.RESULT , vcResMsg : results.RESULT_MSG , wResults: results};

        $.ajax({
            type : 'POST',
            url : '/Wehago/taxUpsert',
            datatype : 'json',
            data : params,
            success : function(result){

                if(result.success) {
                    alert('세금 계산서 발행 처리가 정상적으로 처리가 되었습니다.');
                    opener.getList(opener.loc_page);
                    location.reload();
                    // self.close();
                } else if(result.msg) alert(result.msg);

            }
        });
    }

    //사업자 번호 확인 API
    function bizStatus(isAlert = true) {

        var $wTaxCompNo = $('input[name="wTaxCompNo"]');
        var biznum = $wTaxCompNo.val();
        biznum = biznum.replace( /[^0-9]/g ,"" );
        if(biznum === "") {
            alert("사업자번호를 입력하세요.");
            $wTaxCompNo.focus();
            return false;
        }
        var data = {
            "b_no": [biznum]
        };
        $.ajax({
            url: "https://api.odcloud.kr/api/nts-businessman/v1/status?serviceKey=errkGU7dbjd%2BE69uSZNBbLxKh2jfkYJ5eEw6b17JAXZ10PS%2Fx5UAuPDictqnGLMmE32J7Ni3wN4jYXF0D8Yeig%3D%3D",  // serviceKey 값을 xxxxxx에 입력
            type: "POST",
            data: JSON.stringify(data), // json 을 string으로 변환하여 전송
            dataType: "JSON",
            contentType: "application/json",
            accept: "application/json",
            success: function(result) {
                if( result.data[0].b_stt_cd == "01") {
                    if(isAlert)  alert("사용가능한 사업자등록번호 입니다.");
                    $("#bizNoStatus").val("Y");
                } else {
                    alert(result.data[0].tax_type);
                    $("#bizNoStatus").val("N");
                }
            }
        });
    }

    $(document).ready(function(){

        bizStatus(false)

        //test로 인해 사업자번호 동적처리
        $('input[name="wcNo"]').val(defaultInfo.cno);

        $('form#frmInvoice').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result, status) {
                $('form#frmInvoice input[name="nIdx"]').val(result.data.nIdx);
                if(result.success) WehagoMakeDataSet(result.data)
            }
        });

        //세션이 없고, 발행되지 않은 경우 로그인페이지로 이동
        if( (typeof access_token === "undefined" || access_token === '') && $('input[name="eTaxType"]').val() !== 'P' ) {
            //쿠기삭제
            $.removeCookie(wehago_id_login.service_code + "_token" , {path : '/'});
            $.removeCookie(wehago_id_login.service_code + "_selected_company_no" , {path : '/'});
            $.removeCookie(wehago_id_login.service_code + "_access_token" , {path : '/'});

            location.replace('/Wehago/wehago_login?id=' + <?=$aInfo['idx']?>);

        }
        //세션이 있는 경우 service_token을 가져오도록
        else getServiceToken();

        $("#btnSave").click(function (e){
            e.preventDefault();

            if( $("#log_access_token").val() == "" ) {
                alert("위하고 로그인을 먼저 하고 세금계산서를 발행 하세요.")
                self.close();
                return false;
            }

            if ($("#wTaxCompany").val() == ''){
                alert('상호명 항목을 입력하세요.');
                $("#wTaxCompany").focus();
                return;
            }
            if ($("#wTaxCompNo").val() == ''){
                alert('사업자번호 항목을 입력하세요.');
                $("#wTaxCompNo").focus();
                return;
            }

            if ($("#bizNoStatus").val() == 'N' && !$("#bizResultPass").is(':checked')){
                alert('사업자번호 진위 확인을 하세요.');
                $("#wTaxCompNo").focus();
                return;
            }

            if ($("#wTaxCEO").val() == ''){
                alert('대표자 항목을 입력하세요.');
                $("#wTaxCEO").focus();
                return;
            }
            if ($("#wTaxEmail").val() == ''){
                alert('Email 항목을 입력하세요.');
                $("#wTaxEmail").focus();
                return;
            }
            if ($("#wTaxMobile").val() == ''){
                alert('핸드폰 항목을 입력하세요.');
                $("#wTaxMobile").focus();
                return;
            }
            if ($("#wTaxAddr").val() == ''){
                alert('주소 항목을 입력하세요.');
                $("#wTaxAddr").focus();
                return;
            }
            if ($("#vcMmWrite").val() == ''){
                alert('작성월 항목을 입력하세요.');
                $("#vcMmWrite").focus();
                return;
            }

            if ($("#vcDdWrite").val() == ''){
                alert('작성일 항목을 입력하세요.');
                $("#vcDdWrite").focus();
                return;
            }

            if ($("#wNmItem").val() == ''){
                alert('품명 항목을 입력하세요.');
                $("#wNmItem").focus();
                return;
            }
            if ($("#wAm").val() == ''){
                alert('공급가액 항목을 입력하세요.');
                $("#wAm").focus();
                return;
            }

            if ($("#wAmVat").val() == ''){
                alert('부가세액 항목을 입력하세요.');
                $("#wAmVat").focus();
                return;
            }
            if ($("#wAmt").val() == ''){
                alert('합계금액 항목을 입력하세요.');
                $("#wAmt").focus();
                return;
            }

            var ans = confirm('위하고에 세금계산서를 발행할까요?');
            if (ans){
                $('#frmInvoice').submit();
            }

        });


    });

    // access token 발급 후 service token 을 가져옴
    function getServiceToken() {
        // 소속회사 리스트 조회한 cno값 입력 후, 토큰값 발급

        var service_hash_key = $.cookie(wehago_id_login.service_code + "_token");

        if (service_hash_key === undefined || $.cookie(wehago_id_login.service_code + "_selected_company_no") !== defaultInfo.cno) {

            wehago.getToken({
                "cno": defaultInfo.cno,
                "thirdparty_a_token": access_token
            }, function (result) {
                if (result.resultCode == 200) {
                    console.log("토큰발급 성공!");

                    //토근있음
                    $('.log-area input#log_cno').val(defaultInfo.cno);
                    $('.log-area input#log_access_token').val(access_token);
                    $('.log-area input#log_wehago_id').val(wehago_id_login.getId());
                    $('.log-area input#log_service_token').val($.cookie(wehago_id_login.service_code + "_token"));

                } else {
                    console.log("토큰발급 실패!");
                }
            });
        }else{
            console.log("토큰발급 성공!");

            //토근있음
            $('.log-area input#log_cno').val(defaultInfo.cno);
            $('.log-area input#log_access_token').val(access_token);
            $('.log-area input#log_wehago_id').val(wehago_id_login.getId());
            $('.log-area input#log_service_token').val($.cookie(wehago_id_login.service_code + "_token"));

        }

    }

</script>


</body>
</html>