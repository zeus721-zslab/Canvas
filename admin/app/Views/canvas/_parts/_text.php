<?php
/**
 * @var array $aFontSize '폰트사이즈'
 *
 */

?>
<style>
    /*글자색 관련*/
    ul.text-color-palette{justify-content: center;align-items: center;display: flex;gap: 0.8rem;}
    ul.bg-color-palette{justify-content: center;align-items: center;display: flex;gap: 0.8rem;}
    ul.text-color-palette li{width: 11%;height: 25px; border-radius: 5px;border:1px solid #ccc;cursor: pointer; }
    ul.bg-color-palette li {width: 11%;height: 25px; border-radius: 5px;border:1px solid #ccc;cursor: pointer;}
    /*폰트사이즈 관련*/
    .fontSizeList li{cursor: pointer;}
    .fontSizeList li:hover{background-color: #f8f8f8;}
    /*그림자 관련*/
    .shadow-direct li{display: flex;justify-content: center;align-items: center;cursor: pointer;width: 33.3333%;height: 39px; }
    .shadow-direct li.active{border: 1px solid #ddd;}
    .shadow-direct li i.top-left
    , .shadow-direct li i.down-right{ transform: rotate(-45deg); }
    .shadow-direct li i.top-right
    , .shadow-direct li i.down-left{ transform: rotate(45deg); }
    /* accordion override */
    .accordion-button {padding: 0; width:20px;box-shadow: none!important;}
    .accordion-button { &:not(.collapsed) { background-color:#fff; } }
    /* 커스텀 체크박스 */
    .checkbox-wrapper-3 input[type="checkbox"] {visibility: hidden;display: none;}
    .checkbox-wrapper-3 .toggle {position: relative;display: block;width: 40px;height: 20px;cursor: pointer;-webkit-tap-highlight-color: transparent;transform: translate3d(0, 0, 0);}
    .checkbox-wrapper-3 .toggle:before {content: "";position: relative;top: 3px;left: 3px;width: 34px;height: 14px;display: block;background: #9A9999;border-radius: 8px;transition: background 0.2s ease;}
    .checkbox-wrapper-3 .toggle span {position: absolute;top: 0;left: 0;width: 20px;height: 20px;display: block;background: white;border-radius: 10px;box-shadow: 0 3px 8px rgba(254,126,141, 0.5);transition: all 0.2s ease;}
    .checkbox-wrapper-3 .toggle span:before {content: "";position: absolute;display: block;margin: -18px;width: 56px;height: 56px;background: rgba(254,126,141, 0.5);border-radius: 50%;transform: scale(0);opacity: 1;pointer-events: none;}
    /* 커스텀 체크박스 - 외곽선 */
    .checkbox-wrapper-3 #active-stroke:checked + .toggle:before {background: #ffe1e3;}
    .checkbox-wrapper-3 #active-stroke:checked + .toggle span {background: #fe7e8d;transform: translateX(20px);transition: all 0.2s cubic-bezier(0.8, 0.4, 0.3, 1.25), background 0.15s ease;box-shadow: 0 3px 8px rgba(254,126,141, 0.2); }
    .checkbox-wrapper-3 #active-stroke:checked + .toggle span:before {transform: scale(1);opacity: 0;transition: all 0.4s ease;}
    /* 커스텀 체크박스 - 그림자 */
    .checkbox-wrapper-3 #active-shadow:checked + .toggle:before {background: #ffe1e3;}
    .checkbox-wrapper-3 #active-shadow:checked + .toggle span {background: #fe7e8d;transform: translateX(20px);transition: all 0.2s cubic-bezier(0.8, 0.4, 0.3, 1.25), background 0.15s ease;box-shadow: 0 3px 8px rgba(254,126,141, 0.2); }
    .checkbox-wrapper-3 #active-shadow:checked + .toggle span:before {transform: scale(1);opacity: 0;transition: all 0.4s ease;}
</style>

<div class="row">
    <div class="col-12 pt-3 flex-row gap-3 d-flex ">
        <select class="objFF form-control w-50">
            <option value="Nanum Gothic" style='font-family:Nanum Gothic'>나눔고딕</option>
            <option value="Nanum Myeongjo" style='font-family:Nanum Myeongjo'>나눔명조</option>
            <option value="IM_HyeminRegular" style='font-family:IM_HyeminRegular'>IM혜민체</option>
            <option value="GangwonEduAllLight" style='font-family:GangwonEduAllLight'>강원교육튼튼체</option>
            <option value="MaplestoryLight" style='font-family:MaplestoryLight'>메이플스토리체</option>
            <option value="Yangjin" style='font-family:Yangjin'>양진체</option>
            <option value="Jalnan" style='font-family:Jalnan'>여기어때 잘난체</option>
            <option value="ONE_MobilePOP" style='font-family:ONE_MobilePOP'>원스토어 모바일체</option>
            <option value="INKLIPQUID" style='font-family:INKLIPQUID'>잉크립퀴드체</option>
            <option value="GmarketSansTTFMedium" style='font-family:GmarketSansTTFMedium'>지마켓 산스체</option>
            <option value="CookieRunRegular" style='font-family:CookieRunRegular'>쿠키런체</option>
            <option value="TMONBlack" style='font-family:TMONBlack'>티몬 몬소리체</option>
            <option value="Black And White Picture" style='font-family:Black And White Picture'>흑백사진</option>
            <option value="Black Han Sans" style='font-family:Black Han Sans'>검은고딕</option>
            <option value="Cute Font" style='font-family:Cute Font'>귀여운 폰트</option>
            <option value="Dokdo" style='font-family:Dokdo'>독도</option>
            <option value="East Sea Dokdo" style='font-family:East Sea Dokdo'>대한민국 독도</option>
            <option value="Dongle" style='font-family:Dongle'>동글</option>
            <option value="Gaegu" style='font-family:Gaegu'>개구쟁이</option>
            <option value="Gamja Flower" style='font-family:Gamja Flower'>감자꽃마을</option>
            <option value="Gowun Dodum" style='font-family:Gowun Dodum'>고운 돋음</option>
            <option value="Gugi" style='font-family:Gugi'>구기</option>
            <option value="Hahmlet" style='font-family:Hahmlet'>함렛</option>
            <option value="Hi Melody" style='font-family:Hi Melody'>하이 멜로디</option>
            <option value="Kirang Haerang" style='font-family:Kirang Haerang'>기랑해랑</option>
            <option value="Nanum Pen Script" style='font-family:Nanum Pen Script'>나눔 손글씨 펜</option>
            <option value="Nanum Brush Script" style='font-family:Nanum Brush Script'>나눔 손글씨 붓</option>
            <option value="Poor Story" style='font-family:Poor Story'>서툰이야기</option>
            <option value="Single Day" style='font-family:Single Day'>싱글데이</option>
            <option value="Stylish" style='font-family:Stylish'>스타일리시</option>
            <option value="Yeon Sung" style='font-family:Yeon Sung'>연성</option>
            <option value="Do Hyeon" style='font-family:Do Hyeon'>도현</option>
            <option value="Jua" style='font-family:Jua'>주아</option>
            <option value="Sunflower" style='font-family:Sunflower'>선플라워</option>
        </select>
        <button class="btn btn-outline-success w-50 objItemTxt" role="button">텍스트 추가 하기</button>
    </div>
</div>

<div class="row">
    <div class="col-12 border-bottom py-3 d-flex justify-content-between ">

        <div class="input-group position-relative" style="width: 50%;">
            <button class="btn btn-default fontSizeUp" style="border-color: #dee2e6;"> <i class="fa-solid fa-plus" aria-hidden="true"></i> </button>
            <input type="text" class="form-control text-center objFSize" name="objFSize" value="60" onlynumber title autocomplete="off" />
            <button class="btn btn-default fontSizeDown" style="border-color: #dee2e6;"> <i class="fa-solid fa-minus" aria-hidden="true"></i> </button>
            <ul class="position-absolute d-none flex-column fontSizeList bg-white" style="top:38px;left:0;width: 150px;z-index: 99;">
                <?php foreach($aFontSize as $k => $nVal){?>
                    <li class="border py-1 text-center <?=$k == count($aFontSize)-1? "" : "border-bottom-0"?>" data-val="<?=$nVal?>"><?=$nVal?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="d-flex gap-1 justify-content-evenly" style="width: 50%;">
            <button class="btn fw-bold objFS" data-val="bold" title="두껍게">가</button>
            <button class="btn fst-italic objFS" data-val="italic" title="이텔릭체">가</button>
            <button class="btn text-decoration-underline objFS" data-val="underline" title="밑줄">가</button>
            <!--            <button class="btn objFS" style="text-shadow:2px 1px 1px rgba(0,0,0,.2);-webkit-text-shadow:2px 1px 1px rgba(0,0,0,.2);" data-val="shadow" title="그림자">가</span></button>-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 border-bottom py-3 d-flex">
        <button class="btn flex-grow-1 objFTA objFTA_left" data-val="left" title="좌측정렬"> <img src="/canvas/easycanvas/easycv_icon_txtleft.png" /> </button>
        <button class="btn flex-grow-1 objFTA objFTA_center" data-val="center" title="가운데정렬"> <img src="/canvas/easycanvas/easycv_icon_txtcenter.png" /> </button>
        <button class="btn flex-grow-1 objFTA objFTA_right" data-val="right" title="오른쪽정렬"> <img src="/canvas/easycanvas/easycv_icon_txtright.png" /> </button>
        <button class="btn flex-grow-1 objFTA objFTA_justify" data-val="justify" title="양쪽정렬"> <img src="/canvas/easycanvas/easycv_icon_txtall.png" /> </button>
    </div>
</div>

<div class="row">
    <div class="col-12 border-bottom py-3">
        <div class="d-flex flex-row justify-content-between gap-4">
            <span class="flex-grow-0 w-25 text-center d-flex align-items-center justify-content-center">자간</span>
            <input class="flex-grow-1 w-50 text-center" type='range' id='objCS' min='-100' max='100' value='0' step='1' title="objCS">
            <input type="text" class="flex-grow-0 w-25 text-center form-control" id="objCSVal" value="0" title />
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 border-bottom py-3">
        <div class="d-flex flex-row justify-content-between gap-4">
            <span class="flex-grow-0 w-25 text-center d-flex align-items-center justify-content-center">행간</span>
            <input class="flex-grow-1 w-50 text-center" type='range' id='objLH' min='0.2' max='3' step='0.01' value='1.16' title="objLH">
            <input type="text" class="flex-grow-0 w-25 text-center form-control" id="objLHVal" value="1.16" title />
            <!--<span  class="flex-grow-0 w-25 ps-3 text-center" id='objLHVal'>1.16</span>-->
        </div>
    </div>
</div>


<!--글자색-->
<div class="row">
    <div class="col-12 d-flex flex-column py-3 border-bottom">
        <div class="accordion accordion-flush" id="accordionTextColor">
            <div class="accordion-item">

                <div class="accordion-header d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span data-bs-toggle="collapse" data-bs-target="#text-color-wrap" aria-expanded="false" aria-controls="text-color-wrap">글자색</span>
                        <input type="color" id="_color" value="" class="objFC" style="border-style: dashed;border-color: #ccc;border-radius: 5px;padding: .25rem;width: 40px;height: 40px;cursor: pointer"/>
                    </div>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#text-color-wrap" aria-expanded="false" aria-controls="text-color-wrap">
                    </button>
                </div>

                <div id="text-color-wrap" class="accordion-collapse collapse" data-bs-parent="#accordionTextColor">
                    <div class="accordion-body p-0 mt-3">
                        <div class="input-group mb-3 d-none align-items-start border-bottom flex-column gap-2 recent-text-color" >
                            <label for="color" class="d-flex">최근사용한 글자색</label>
                            <ul class="d-flex text-color-palette flex-wrap justify-content-start pb-2" style="width: 100%;"> </ul>
                        </div>
                        <ul class="d-flex text-color-palette flex-wrap justify-content-start">
                            <li style="background-color:#feccbe;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#feebb6;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#ddecca;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#b8e6e1;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#b8e9ff;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#ccd2f0;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#e0bfe6;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#fd8a69;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#ffcd4a;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#afd485;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#82cbc4;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#58ccff;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#9fa9d8;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#b96bc6;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#fc5230;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#fd9f28;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#7db249;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#2fa599;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#18a8f1;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#5d6dbe;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#9a30ae;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#d94925;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#fd6f22;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#568a35;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#12887a;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#1187cf;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#3a4ca8;" class="editor_palet_color objFC_p"></li>
                            <li style="background-color:#692498;" class="editor_palet_color objFC_p"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--글자색 배경-->
<div class="row">
    <div class="col-12 border-bottom d-flex py-3 flex-column">

        <div class="accordion accordion-flush" id="accordionBgColor">
            <div class="accordion-item">
                <div class="accordion-header d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span data-bs-toggle="collapse" data-bs-target="#bg-color-wrap" aria-expanded="false" aria-controls="bg-color-wrap">글 배경색</span>
                        <input type="color" id="_color" class="objFBC" value="" style="border-style: dashed;border-color: #ccc;border-radius: 5px;padding: .25rem;width: 40px;height: 40px;cursor: pointer"/>

                        <div class="d-flex position-relative justify-content-center align-items-center objFBC_no" style="width: 40px;height: 40px;border:1px dashed #ddd;padding: .25rem;border-radius: 5px;cursor: pointer">
                            <div class="position-absolute" style="top: 13px;left:13px;  border-top: solid 1px #FF5252;transform: rotate(-45deg);height: 100%;width: 100%;"></div>

                            <div class="position-absolute bg-color-cmt align-items-center justify-content-center border" style="display: none; top: -30px;left:0;width: 120px;height: 30px;background-color: #fff;">배경색 없음</div>
                        </div>

                        <script>
                            $(function(){
                                $('.objFBC_no').on('mouseenter',function(){
                                    $('.bg-color-cmt').css('display','flex');
                                }).on('mouseleave',function() {
                                    $('.bg-color-cmt').css('display', 'none');
                                });
                            });
                        </script>


                    </div>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#bg-color-wrap" aria-expanded="false" aria-controls="bg-color-wrap">
                    </button>
                </div>
                <div id="bg-color-wrap" class="accordion-collapse collapse" data-bs-parent="#accordionBgColor">
                    <div class="accordion-body p-0 mt-3">
                        <div class="input-group mb-3 d-none align-items-start border-bottom flex-column gap-2 recent-bg-color" >
                            <label for="color" class="d-flex">최근사용한 배경</label>
                            <ul class="d-flex bg-color-palette flex-wrap justify-content-start pb-2" style="width: 100%;"> </ul>
                        </div>

                        <ul class="d-flex bg-color-palette flex-wrap justify-content-start">
                            <li style="background-color:#feccbe;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#feebb6;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#ddecca;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#b8e6e1;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#b8e9ff;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#ccd2f0;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#e0bfe6;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#fd8a69;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#ffcd4a;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#afd485;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#82cbc4;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#58ccff;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#9fa9d8;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#b96bc6;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#fc5230;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#fd9f28;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#7db249;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#2fa599;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#18a8f1;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#5d6dbe;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#9a30ae;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#d94925;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#fd6f22;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#568a35;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#12887a;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#1187cf;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#3a4ca8;" class="editor_palet_color objFBC_p"></li>
                            <li style="background-color:#692498;" class="editor_palet_color objFBC_p"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 외곽선 -->
<div class="row">
    <div class="col-12 py-3 border-bottom flex-row d-flex flex-column">
        <div class="accordion accordion-flush" id="accordionStroke">
            <div class="accordion-item">
                <div class="accordion-header d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span data-bs-toggle="collapse" data-bs-target="#stroke-wrap" aria-expanded="false" aria-controls="stroke-wrap">외곽선</span>
                        <div class="d-flex align-items-center">
                            <div class="checkbox-wrapper-3">
                                <input type="checkbox" value="" name="active-stroke" id="active-stroke">
                                <label for="active-stroke" class="toggle"><span></span></label>
                            </div>
                        </div>
                    </div>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stroke-wrap" aria-expanded="false" aria-controls="stroke-wrap">
                    </button>
                </div>
                <div id="stroke-wrap" class="accordion-collapse collapse " data-bs-parent="#accordionStroke">
                    <div class="accordion-body p-0 mt-3">
                        <div class="d-flex flex-column justify-content-evenly gap-2">
                            <div class="d-flex justify-content-start gap-2">
                                <span class="form-control-plaintext text-center" style="width: 75px;">두께</span>
                                <input type="range" name="stroke-width-range" class="w-50" min="1" max="5" value="2" >
                                <input type="number" name="stroke-width" class="form-control w-25" value="2"  />
                            </div>
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <span class="form-control-plaintext text-center" style="width: 75px;">색상</span>
                                <input type="color" name="stroke-color" value="#fe7e8d" style="width: 85.9px;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 그림자 -->
<div class="row">
    <div class="col-12 py-3 border-bottom flex-row d-flex flex-column">
        <div class="accordion accordion-flush" id="accordionShadow">
            <div class="accordion-item">
                <div class="accordion-header d-flex justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span data-bs-toggle="collapse" data-bs-target="#shadow-wrap" aria-expanded="false" aria-controls="shadow-wrap">그림자</span>
                        <div class="d-flex align-items-center">
                            <div class="checkbox-wrapper-3">
                                <input type="checkbox" value="" name="active-shadow" id="active-shadow">
                                <label for="active-shadow" class="toggle"><span></span></label>
                            </div>
                        </div>
                    </div>
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shadow-wrap" aria-expanded="false" aria-controls="shadow-wrap">
                    </button>
                </div>
                <div id="shadow-wrap" class="accordion-collapse collapse" data-bs-parent="#accordionShadow">
                    <div class="accordion-body p-0 mt-3">
                        <div class="d-flex">
                            <div class="d-flex flex-column justify-content-evenly gap-2">
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <span class="form-control-plaintext text-center" style="width: 60px;">색상</span>
                                    <input type="color" name="shadow-color" value="#fe7e8d" style="width: 86px;" />
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <span class="form-control-plaintext text-center" style="width: 60px;">투명도</span>
                                    <input type="range" name="shadow-blur-range" class="w-50" min="2" max="10" value="5" >
                                    <input type="number" name="shadow-blur" class="form-control w-25" value="5"  />
                                </div>
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <span class="form-control-plaintext text-center " style="width: 60px;">방향</span>
                                    <ul class="d-flex flex-wrap shadow-direct" style="width: 150px;">
                                        <li data-x="-5" data-y="-5"><i class="fa-solid fa-chevron-up top-left"></i></li>
                                        <li data-x="0" data-y="-5"><i class="fa-solid fa-chevron-up"></i></li>
                                        <li data-x="5" data-y="-5"><i class="fa-solid fa-chevron-up top-right"></i></li>

                                        <li data-x="-5" data-y="0"><i class="fa-solid fa-chevron-left"></i></li>
                                        <li data-x="0" data-y="0"><i class="fa-solid fa-expand"></i></li>
                                        <li data-x="5" data-y="0"><i class="fa-solid fa-chevron-right"></i></li>

                                        <li data-x="-5" data-y="5"><i class="fa-solid fa-chevron-down down-left"></i></li>
                                        <li data-x="0" data-y="5"><i class="fa-solid fa-chevron-down"></i></li>
                                        <li data-x="5" data-y="5"><i class="fa-solid fa-chevron-down down-right"></i></li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function(){
        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

        //폰트사이즈 input 포커스여부
        $('input[name="objFSize"]').on('focus',function(){
            $('.fontSizeList').addClass('d-flex').removeClass('d-none');
        }).on('blur',function(e){
            //blur 시 mouseover된 영역이 폰트사이즈 리스트 영역인 경우에는 modal살림
            if($(':hover').hasClass('fontSizeList') == false)
                $('.fontSizeList').removeClass('d-flex').addClass('d-none');
        });

    })

    // ----------------------- 외곽선
    function setStrokeWidth()
    {
        if($('#active-stroke').prop('checked') === true){//외곽선 설정
            if (typeof curObj !== 'undefined') { //객체확인
                if (curObj[0].type === 'textbox') {//텍스트박스확인
                    var val = $('input[name="stroke-width"]').val() < 1 ? 1 : $('input[name="stroke-width"]').val();
                    var scale = curObj[0].get('scaleX')/10;
                    var strokeWidth = (val / 10) * scale;
                    strokeWidth = strokeWidth < 1 ? 1 : strokeWidth;
                    curObj[0].set({strokeWidth: strokeWidth});
                    oCanvas.renderAll();
                    onUpdate();
                }
            }
        }
    }

    $(document).on('change','#active-stroke',function(){

        if (typeof curObj !== 'undefined') {
            if (curObj[0].type === 'textbox') {

                //if( $('#accordionStroke .accordion-collapse').hasClass('show') == false ){
                if($(this).prop('checked') === true){
                    if( $('#accordionStroke .accordion-collapse').hasClass('show') == false )
                        $('.accordion-button[aria-controls="stroke-wrap"]').trigger('click');
                    $('input[name="stroke-width-range"]').trigger('change');
                }else{
                    curObj[0].set({stroke: null, strokeWidth: null});
                    oCanvas.renderAll();
                    onUpdate();
                }

            }else{
                $(this).prop('checked',false);
            }
        }else{
            $(this).prop('checked',false);
        }
    });

    $(document).on('change','input[name="stroke-width-range"]',function() {

        $('input[name="stroke-width"]').val($(this).val()).trigger('change');

        if (typeof curObj !== 'undefined' && curObj[0]) {
            if (curObj[0].type === 'textbox') {

                $('#active-stroke').prop('checked',true);

                var scale = curObj[0].get('scaleX');
                var rgb = $('input[name="stroke-color"]').val();
                var strokeWidth = ($(this).val() / 10) * scale;

                curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
                oCanvas.renderAll();
                onUpdate();
            }

        }

    });

    $(document).on('keyup','input[name="stroke-width"]',function() {

        if (typeof curObj !== 'undefined') {
            if (curObj[0].type === 'textbox') {
                $('#active-stroke').prop('checked',true);

                var scale = curObj[0].get('scaleX');
                var rgb = $('input[name="stroke-color"]').val();
                var strokeWidth = ($(this).val() / 10) * scale;

                curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
                oCanvas.renderAll();
                onUpdate();
            }
        }

    });

    $(document).on('change','input[name="stroke-color"]',function() {

        if(typeof curObj !== 'undefined' && curObj[0]) {

            if (curObj[0].type === 'textbox') {
                $('#active-stroke').prop('checked',true);
                var scale = curObj[0].get('scaleX');
                var rgb = $(this).val();
                var strokeWidth = ($('input[name="stroke-width"]').val() / 10) * scale;

                curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
                oCanvas.renderAll();
                onUpdate();
            }

        }

    });


    // ----------------------- 그림자

    $(document).on('change','#active-shadow',function(){

        if (typeof curObj !== 'undefined' && curObj[0]) {
            if (curObj[0].type === 'textbox') {

                //if( $('#accordionStroke .accordion-collapse').hasClass('show') == false ){
                if($(this).prop('checked') === true){
                    if( $('#accordionShadow .accordion-collapse').hasClass('show') == false )
                        $('.accordion-button[aria-controls="shadow-wrap"]').trigger('click');
                    $('input[name="shadow-blur-range"]').trigger('change');

                }else{
                    curObj[0].set({shadow: null});
                    oCanvas.renderAll();
                    onUpdate();
                }

            }else{
                $(this).prop('checked',false);
            }
        }else{
            $(this).prop('checked',false);
        }
    });

    $(document).on('change','input[name="shadow-blur-range"]',function() {

        $('input[name="shadow-blur"]').val($(this).val()).trigger('change');

        if (typeof curObj !== 'undefined' && curObj[0]) {

            if (curObj[0].type === 'textbox') {

                var rgb = $('input[name="shadow-color"]').val();
                var x = 5, y = 5;
                var blur = $(this).val();
                var $activeObj = $('.shadow-direct li.active');

                if ($activeObj.length > 0) {
                    y = $activeObj.data('y');
                    x = $activeObj.data('x');
                } else {
                    $('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
                }

                var shadow = new fabric.Shadow({
                    blur: blur,
                    color: rgb,
                    offsetX: x,
                    offsetY: y

                });

                curObj[0].set({shadow: shadow});
                oCanvas.renderAll();
                onUpdate();
            }

        }

    });

    $(document).on('keyup','input[name="shadow-blur"]',function() {

        if (typeof curObj !== 'undefined' && curObj[0]) {
            if (curObj[0].type === 'textbox') {

                var val = $(this).val() < 5 ? 5 : $(this).val();

                var rgb = $('input[name="shadow-color"]').val();
                var x = 5, y = 5;
                var blur = $(this).val();
                var $activeObj = $('.shadow-direct li.active');

                if ($activeObj.length > 0) {
                    y = $activeObj.data('y');
                    x = $activeObj.data('x');
                } else {
                    $('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
                }

                var shadow = new fabric.Shadow({
                    blur: blur,
                    color: rgb,
                    offsetX: x,
                    offsetY: y

                });

                curObj[0].set({shadow: shadow});
                oCanvas.renderAll();
                onUpdate();
            }

        }

    });

    $(document).on('change','input[name="shadow-color"]',function() {

        if(typeof curObj !== 'undefined' && curObj[0]) {
            if (curObj[0].type === 'textbox') {
                var rgb = $(this).val();
                var x = 5, y = 5;
                var blur = $('input[name="shadow-blur"]').val();
                var $activeObj = $('.shadow-direct li.active');

                if ($activeObj.length > 0) {
                    y = $activeObj.data('y');
                    x = $activeObj.data('x');
                } else {
                    $('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
                }

                var shadow = new fabric.Shadow({
                    blur: blur,
                    color: rgb,
                    offsetX: x,
                    offsetY: y
                });

                curObj[0].set({shadow: shadow});
                oCanvas.renderAll();
                onUpdate();
            }
        }

    });

    $(document).on('click','.shadow-direct li',function() {

        if (typeof curObj !== 'undefined' && curObj[0]) {

            if (curObj[0].type === 'textbox') {

                var shadow = null;
                var bool_active = $(this).hasClass('active');
                $('.shadow-direct li').removeClass('active');

                if( bool_active === false ) {

                    var x = $(this).data('x');
                    var y = $(this).data('y');
                    var rgb = $('input[name="shadow-color"]').val();
                    var blur = $('input[name="shadow-blur"]').val();

                    $(this).addClass('active');

                    shadow = new fabric.Shadow({
                        color: rgb,
                        blur: blur,
                        offsetX : x,
                        offsetY : y
                    });

                }

                curObj[0].set({shadow: shadow});
                oCanvas.renderAll();
                onUpdate();

            }

        }

    });

</script>
