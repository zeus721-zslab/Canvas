<?php
/**
 * @var array $aOrderInfo '주문 정보'
 * @var string $receipt_name '수신자명'
 */
list($order_id1,$order_id2) = explode('_',$aOrderInfo['order_id']);
$order_id = $order_id1.'_'.$order_id2
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <title>거래명세서</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* AC */
        @font-face {
            font-family: 'NanumGothic';
            font-weight: 400;
            src: url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-regular.eot);
            src: local('☺'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-regular.eot?#iefix) format('embedded-opentype'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-regular.woff2) format('woff2'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-regular.woff) format('woff'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-regular.ttf) format('truetype');
        }

        @font-face {
            font-family: 'NanumGothic';
            font-weight: 700;
            src: url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-700.eot);
            src: local('☺'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-700.eot?#iefix) format('embedded-opentype'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-700.woff2) format('woff2'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-700.woff) format('woff'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-700.ttf) format('truetype');
        }
        @font-face {
            font-family: 'NanumGothic';
            font-weight: 800;
            src: url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-800.eot);
            src: local('☺'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-800.eot?#iefix) format('embedded-opentype'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-800.woff2) format('woff2'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-800.woff) format('woff'),
            url(https://www.kindercanvas.co.kr/fonts/nanum-gothic-v13-korean_latin-800.ttf) format('truetype');
        }

        *{
            font-family: 'NanumGothic',"Dotum", "Malgun Gothic", "돋움", serif;
        }
    </style>

</head>
<body>

<style>
    h1 {font-size: 2rem;text-align: center;letter-spacing: 3rem;margin-right: -3rem;}
    table{ width: 90%;margin: .5rem auto 0 auto ;}
    table.table1 td{width: 50%;padding: 1rem;}
    table.table2 td{padding: .25rem;text-align: center;}
    table tr td
    ,table tr th{border:1px solid #777;}
    dl {margin: 0;}
    dl dt {width: 15%;text-align: right;position: relative;display: inline-block;font-weight: bold}
    dl dt:after{content: ":";position: absolute;top:0;right:-15px;}
    dl dd{margin-left: 25px;width: 70%;display: inline-block;}
    img{width: 60px;height: 60px;position: absolute;top: -10px;right:0;}
</style>

<table cellpadding="0" cellspacing="0" class="table1" style="border:2px solid #777">
    <tr>
        <th colspan="2" style="border:1px solid #777;padding: 0;">
            <h1>거래명세표</h1>
        </th>
    </tr>
    <tr>
        <td>
            <div>
                <dl>
                    <dt>관리번호</dt>
                    <dd><?=$order_id?></dd>
                </dl>

                <dl>
                    <dt>작성일자</dt>
                    <dd><?=date('Y년 m월 d일')?></dd>
                </dl>
                <dl>
                    <dt>수신</dt>
                    <dd class="reception"><?=$receipt_name?></dd>
                </dl>

                <dl>
                    <dt>발신</dt>
                    <dd>꼬망세미디어(주)</dd>
                </dl>

                <dl>
                    <dt>연락처</dt>
                    <dd>(TEL)1588-1978(내선 2번)</dd>
                </dl>
            </div>
        </td>

        <td style="border:1px solid #777;border-top:none;border-left:none;padding: 1rem;">

            <div style="margin: 0">
                <div style="width: 48%;display: inline-block;text-align: left;">(주)꼬망세미디어</div>
                <div style="width: 48%;display: inline-block;text-align: left;position: relative;">대표이사 최남호 (인) <img src="https://www.kindercanvas.co.kr/img/sign.jpg" alt="sign" /></div>
            </div>

            <div>
                <div style="display: inline-block;text-align: left;"><b>사업자 번호</b> : </div>
                <div style="display: inline-block;text-align: left;">105-81-01773</div>
            </div>

            <div>
                <div style="width: 48%;display: inline-block;text-align: left;"><b>업태</b> : 서비스,도소매</div>
                <div style="width: 48%;display: inline-block;text-align: left;"><b>업종</b> : 서적, 출판 외</div>
            </div>

            <div>
                <div style="display: inline-block;text-align: left;"><b>주소</b> :</div>
                <div style="display: inline-block;text-align: left;">서울시 강남구 논현로 76길 27 에이포스페이스 5층</div>
            </div>

            <div>
                <div style="width: 48%;display: inline-block;text-align: left;"><b>TEL</b> : 1588-1978</div>
                <div style="width: 48%;display: inline-block;text-align: left;"><b>FAX</b> : 02-337-5534</div>
            </div>
        </td>
    </tr>

</table>


<diV style="width: 90%;margin: 30px auto 0 auto;text-align: right;">(단위:원)</diV>

<table cellpadding="0" cellspacing="0" class="table2" style="border:2px solid #777">

    <tr>
        <th>NO</th>
        <th>상품명</th>
        <th>구분</th>
        <th>수량</th>
        <th>공급가</th>
        <th>부가세액</th>
        <th>계</th>
    </tr>
    <tr>
        <td>1</td>
        <td><?=$aOrderInfo['good_name']?></td>
        <td>과세</td>
        <td>1개</td>
        <td><?=number_format($aOrderInfo['supply_amount'])?>원</td>
        <td><?=number_format($aOrderInfo['vat_amount'])?>원</td>
        <td><?=number_format($aOrderInfo['amount'])?>원</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: center;border-top-width: 2px;">총계</td>
        <td style="border-top-width: 2px;"><?=number_format($aOrderInfo['amount'])?>원</td>
    </tr>
</table>

</body>

</html>
