<?php

/**
 * @var array $aOrderInfo '주문 정보'
 */

//zsView($aOrderInfo);

?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <title>거래명세서</title>
        <style>
            /* AC */
            @font-face {
                font-family: 'NanumSquareAc';
                font-weight: 400;
                src: url(/fonts/NanumSquareAcR.eot);
                src: local('☺'),
                url(/fonts/NanumSquareAcR.eot?#iefix) format('embedded-opentype'),
                url(/fonts/NanumSquareAcR.woff2) format('woff2'),
                url(/fonts/NanumSquareAcR.woff) format('woff'),
                url(/fonts/NanumSquareAcR.ttf) format('truetype');
            }
            @font-face {
                font-family: 'NanumSquareAc';
                font-weight: 700;
                src: url(/fonts/NanumSquareAcB.eot);
                src: local('☺'),
                url(/fonts/NanumSquareAcB.eot?#iefix) format('embedded-opentype'),
                url(/fonts/NanumSquareAcB.woff2) format('woff2'),
                url(/fonts/NanumSquareAcB.woff) format('woff'),
                url(/fonts/NanumSquareAcB.ttf) format('truetype');
            }
            @font-face {
                font-family: 'NanumSquareAc';
                font-weight: 800;
                src: url(/fonts/NanumSquareAcEB.eot);
                src: local('☺'),
                url(/fonts/NanumSquareAcEB.eot?#iefix) format('embedded-opentype'),
                url(/fonts/NanumSquareAcEB.woff2) format('woff2'),
                url(/fonts/NanumSquareAcEB.woff) format('woff'),
                url(/fonts/NanumSquareAcEB.ttf) format('truetype');
            }
            @font-face {
                font-family: 'NanumSquareAc';
                font-weight: 300;
                src: url(/fonts/NanumSquareAcL.eot);
                src: local('☺'),
                url(/fonts/NanumSquareAcL.eot?#iefix) format('embedded-opentype'),
                url(/fonts/NanumSquareAcL.woff2) format('woff2'),
                url(/fonts/NanumSquareAcL.woff) format('woff'),
                url(/fonts/NanumSquareAcL.ttf) format('truetype');
            }
            :root{
                --bg-color : #f3f0eb;
                --logo-red:#F09191;
                --logo-yellow:#F8EAAB;
                --logo-blue:#ABD4F2;
                --gray-color:#a69688;
                --lightgray-color:#f3f0eb;
                --main-color:#d4cabe;
                --lightbrown-color:#a69688;
            }

            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */

            /* Document
               ========================================================================== */

            /**
             * 1. Correct the line height in all browsers.
             * 2. Prevent adjustments of font size after orientation changes in iOS.
             */

            html {
                line-height: 1.15; /* 1 */
                -webkit-text-size-adjust: 100%; /* 2 */
            }

            /* Sections
               ========================================================================== */

            /**
             * Remove the margin in all browsers.
             */

            body {
                margin: 0;
            }

            /**
             * Render the `main` element consistently in IE.
             */

            main {
                display: block;
            }

            /**
             * Correct the font size and margin on `h1` elements within `section` and
             * `article` contexts in Chrome, Firefox, and Safari.
             */

            h1 {
                font-size: 2em;
                margin: 0.67em 0;
            }

            /* Grouping content
               ========================================================================== */

            /**
             * 1. Add the correct box sizing in Firefox.
             * 2. Show the overflow in Edge and IE.
             */

            hr {
                box-sizing: content-box; /* 1 */
                height: 0; /* 1 */
                overflow: visible; /* 2 */
            }

            /**
             * 1. Correct the inheritance and scaling of font size in all browsers.
             * 2. Correct the odd `em` font sizing in all browsers.
             */

            pre {
                font-family: monospace, monospace; /* 1 */
                font-size: 1em; /* 2 */
            }

            /* Text-level semantics
               ========================================================================== */

            /**
             * Remove the gray background on active links in IE 10.
             */

            a {
                background-color: transparent;
            }

            /**
             * 1. Remove the bottom border in Chrome 57-
             * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
             */

            abbr[title] {
                border-bottom: none; /* 1 */
                text-decoration: underline; /* 2 */
                text-decoration: underline dotted; /* 2 */
            }

            /**
             * Add the correct font weight in Chrome, Edge, and Safari.
             */

            b,
            strong {
                font-weight: bolder;
            }

            /**
             * 1. Correct the inheritance and scaling of font size in all browsers.
             * 2. Correct the odd `em` font sizing in all browsers.
             */

            code,
            kbd,
            samp {
                font-family: monospace, monospace; /* 1 */
                font-size: 1em; /* 2 */
            }

            /**
             * Add the correct font size in all browsers.
             */

            small {
                font-size: 80%;
            }

            /**
             * Prevent `sub` and `sup` elements from affecting the line height in
             * all browsers.
             */

            sub,
            sup {
                font-size: 75%;
                line-height: 0;
                position: relative;
                vertical-align: baseline;
            }

            sub {
                bottom: -0.25em;
            }

            sup {
                top: -0.5em;
            }

            /* Embedded content
               ========================================================================== */

            /**
             * Remove the border on images inside links in IE 10.
             */

            img {
                border-style: none;
            }

            /* Forms
               ========================================================================== */

            /**
             * 1. Change the font styles in all browsers.
             * 2. Remove the margin in Firefox and Safari.
             */

            button,
            input,
            optgroup,
            select,
            textarea {
                font-family: inherit; /* 1 */
                font-size: 100%; /* 1 */
                line-height: 1.15; /* 1 */
                margin: 0; /* 2 */
            }

            /**
             * Show the overflow in IE.
             * 1. Show the overflow in Edge.
             */

            button,
            input { /* 1 */
                overflow: visible;
            }

            /**
             * Remove the inheritance of text transform in Edge, Firefox, and IE.
             * 1. Remove the inheritance of text transform in Firefox.
             */

            button,
            select { /* 1 */
                text-transform: none;
            }

            /**
             * Correct the inability to style clickable types in iOS and Safari.
             */

            button,
            [type="button"],
            [type="reset"],
            [type="submit"] {
                -webkit-appearance: button;
            }

            /**
             * Remove the inner border and padding in Firefox.
             */

            button::-moz-focus-inner,
            [type="button"]::-moz-focus-inner,
            [type="reset"]::-moz-focus-inner,
            [type="submit"]::-moz-focus-inner {
                border-style: none;
                padding: 0;
            }

            /**
             * Restore the focus styles unset by the previous rule.
             */

            button:-moz-focusring,
            [type="button"]:-moz-focusring,
            [type="reset"]:-moz-focusring,
            [type="submit"]:-moz-focusring {
                outline: 1px dotted ButtonText;
            }

            /**
             * Correct the padding in Firefox.
             */

            fieldset {
                padding: 0.35em 0.75em 0.625em;
            }

            /**
             * 1. Correct the text wrapping in Edge and IE.
             * 2. Correct the color inheritance from `fieldset` elements in IE.
             * 3. Remove the padding so developers are not caught out when they zero out
             *    `fieldset` elements in all browsers.
             */

            legend {
                box-sizing: border-box; /* 1 */
                color: inherit; /* 2 */
                display: table; /* 1 */
                max-width: 100%; /* 1 */
                padding: 0; /* 3 */
                white-space: normal; /* 1 */
            }

            /**
             * Add the correct vertical alignment in Chrome, Firefox, and Opera.
             */

            progress {
                vertical-align: baseline;
            }

            /**
             * Remove the default vertical scrollbar in IE 10+.
             */

            textarea {
                overflow: auto;
            }

            /**
             * 1. Add the correct box sizing in IE 10.
             * 2. Remove the padding in IE 10.
             */

            [type="checkbox"],
            [type="radio"] {
                box-sizing: border-box; /* 1 */
                padding: 0; /* 2 */
            }

            /**
             * Correct the cursor style of increment and decrement buttons in Chrome.
             */

            [type="number"]::-webkit-inner-spin-button,
            [type="number"]::-webkit-outer-spin-button {
                height: auto;
            }

            /**
             * 1. Correct the odd appearance in Chrome and Safari.
             * 2. Correct the outline style in Safari.
             */

            [type="search"] {
                -webkit-appearance: textfield; /* 1 */
                outline-offset: -2px; /* 2 */
            }

            /**
             * Remove the inner padding in Chrome and Safari on macOS.
             */

            [type="search"]::-webkit-search-decoration {
                -webkit-appearance: none;
            }

            /**
             * 1. Correct the inability to style clickable types in iOS and Safari.
             * 2. Change font properties to `inherit` in Safari.
             */

            ::-webkit-file-upload-button {
                -webkit-appearance: button; /* 1 */
                font: inherit; /* 2 */
            }

            /* Interactive
               ========================================================================== */

            /*
             * Add the correct display in Edge, IE 10+, and Firefox.
             */

            details {
                display: block;
            }

            /*
             * Add the correct display in all browsers.
             */

            summary {
                display: list-item;
            }

            /* Misc
               ========================================================================== */

            /**
             * Add the correct display in IE 10+.
             */

            template {
                display: none;
            }

            /**
             * Add the correct display in IE 10.
             */

            [hidden] {
                display: none;
            }
            /* http://meyerweb.com/eric/tools/css/reset/
   v2.0 | 20110126
   License: none (public domain)
*/

            html, body, div, span, applet, object, iframe,
            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
            a, abbr, acronym, address, big, cite, code,
            del, dfn, em, img, ins, kbd, q, s, samp,
            small, strike, strong, sub, sup, tt, var,
            b, u, i, center,
            dl, dt, dd, ol, ul, li,
            fieldset, form, label, legend,
            table, caption, tbody, tfoot, thead, tr, th, td,
            article, aside, canvas, details, embed,
            figure, figcaption, footer, header, hgroup,
            menu, nav, output, ruby, section, summary,
            time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                font-size: 100%;
                font: inherit;
                vertical-align: baseline;
            }
            /* HTML5 display-role reset for older browsers */
            article, aside, details, figcaption, figure,
            footer, header, hgroup, menu, nav, section {
                display: block;
            }
            body {
                line-height: 1;
            }
            ol, ul {
                list-style: none;
            }
            blockquote, q {
                quotes: none;
            }
            blockquote:before, blockquote:after,
            q:before, q:after {
                content: '';
                content: none;
            }
            table {
                border-collapse: collapse;
                border-spacing: 0;
            }
            body *{
                font-family: 'NanumSquareAC', "Nanum Gothic", "Dotum", "Malgun Gothic", "돋움", serif;
            }
        </style>
    </head>

    <body>

    <style>
        :root{
            --border-color:#777;
        }

        h1 {font-size: 3rem;text-align: center;letter-spacing: 3rem;margin-right: -3rem;}
        table{ width: 90%;margin: .5rem auto 0 auto ;}
        table.table1 td{width: 50%;padding: 1rem;}
        table.table2 td{padding: .25rem}
         table tr td
        ,table tr th{border:1px solid var(--border-color);}
        dl {display: flex;margin: 0;flex-direction: row;}
        dl dt {width: 15%;text-align: right;position: relative;}
        dl dt:after{content: ":";position: absolute;top:0;right:-15px;}
        dl dd{margin-left: 25px;width: 80%;}

    </style>

    <table cellpadding="0" cellspacing="0" class="table1">
        <tr>
            <td colspan="2" style="border:1px solid var(--border-color);">
                <h1>거래명세표</h1>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <dl>
                        <dt>관리번호</dt>
                        <dd><?=$aOrderInfo['order_id']?></dd>
                    </dl>

                    <dl>
                        <dt>작성일자</dt>
                        <dd><?=date('Y년 m월 d일 H시i분')?></dd>
                    </dl>
                    <dl>
                        <dt>수신</dt>
                        <dd class="reception"></dd>
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
            <td style="border:1px solid var(--border-color);border-top:none;border-left:none;padding: 1rem;">

                <div>
                    <div style="width: 45%;display: inline-block;text-align: center">꼬망세미디어(주)</div>
                    <div style="width: 45%;display: inline-block;text-align: center">대표이사 최남호 (인)</div>
                </div>

                <div>
                    <div style="width: 45%;display: inline-block;text-align: center">사업자 번호 : 105-81-01773</div>
                </div>

                <div>
                    <div style="width: 45%;display: inline-block;text-align: center">업태 : 서비스,도소매</div>
                    <div style="width: 45%;display: inline-block;text-align: center">업종 : 서적, 출판 외</div>
                </div>
                <div>
                    <div style="width: 45%;display: inline-block;text-align: center">서울시 강남구 논현로 76길27 에이포스페이스 5층</div>
                </div>

                <div>
                    <div style="width: 45%;display: inline-block;text-align: center">TEL) 1588-1978, FAX)02-337-5534</div>
                </div>
            </td>
        </tr>

    </table>


    <table cellpadding="0" cellspacing="0" class="table2" style="border:2px solid var(--border-color)">
        <tr>
            <td colspan="7" style="border:none;text-align: right;">(단위:원)</td>
        </tr>

        <tr>
            <th>NO</th>
            <th>상품명</th>
            <th>내역</th>
            <th>구분</th>
            <th>수량</th>
            <th>금액</th>
            <th>계</th>
        </tr>
        <tr>
            <td>1</td>
            <td><?=$aOrderInfo['good_name']?></td>
            <td>&nbsp;</td>
            <td>과세</td>
            <td>1개</td>
            <td><?=number_format($aOrderInfo['amount'])?>원</td>
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
