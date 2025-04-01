<!DOCTYPE html>
<html>
<head>
    <link href="/js/jplayer/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/js/jplayer/jquery.jplayer.min.js"></script>
</head>

<body style="padding:0px; margin:0px; background-color:#fff;font-family:helvetica, arial, verdana, sans-serif">

<script src="/js/slider/jssor.slider-21.1.6.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function ($) {
        $(".objSlideWrap, #slider1_container, .tblTxt").css("width",$(document).width());
        $(".objSlideWrap, #slider1_container, .tblTxt").css("height",$(document).height());
        $(".objThumb").css("width",$(document).width());
        $(".objSlideWrap, #slider1_container, .tblTxt").css("max-width",$(document).width());
        $(".objSlideWrap, #slider1_container, .tblTxt").css("max-height",$(document).height());



        var jssor_1_SlideoTransitions = [
            [{b:-1,d:1,o:-1},{b:0,d:200,o:1,e:{o:5}}]
        ];



        var options = {
            $AutoPlay: false,
            $Idle: 0,
            $Loop : 0,

            $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions,
                $Breaks: [
                    [{d:500,b:500}]
                ]
            },

            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 1,
                $AutoCenter: 2
            },

            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $ChanceToShow: 0
            },

            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 12,
                $SpacingX: 3,
                $SpacingY: 3,
                $Align: 260,
                $ChanceToShow: 1
            }

        };

        var jssor_slider1 = new $JssorSlider$('slider1_container', options);

        jssor_slider1.$On($JssorSlider$.$EVT_PARK,function(nPosId,nPrevId){
            $("#divPlayerBase_"+nPrevId).html('');
            $("#divPlayerBase_"+nPrevId).hide();
            $("#btnClipPlay_"+nPrevId).show();
            $("#oCaption_btn_"+nPrevId).css("height","200px");
            $("#divPlayerMp3_"+nPrevId).html('');
            $("#divPlayerMp3_"+nPrevId).hide();
            $("#btnClipPlay_"+nPrevId).attr("src","/images/btn/play_opa200.png");
            $("#btnClipPlay_"+nPrevId).attr("bPlay","0");
        });


        jssor_slider1.$On($JssorSlider$.$EVT_CLICK,function(nPos){
            jssor_slider1.$Next();
        });

        $(document).keyup(function (e){
            switch (e.keyCode){
                case 8: jssor_slider1.$Prev();break;	// back space
                case 32: jssor_slider1.$Next();break;	// space
            }
        });

    });
</script>
<STYLE type="text/css">

    .jssorb05 {
        position: absolute;
    }
    .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
        position: absolute;
        /* size of bullet elment */
        width: 16px;
        height: 16px;
        background: url('/js/slider/img/b05.png') no-repeat;
        overflow: hidden;
        cursor: pointer;
    }
    .jssorb05 div { background-position: -7px -7px; }
    .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
    .jssorb05 .av { background-position: -67px -7px; }
    .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }



    .jssora22l, .jssora22r {
        display: block;
        position: absolute;
        /* size of arrow element */
        width: 40px;
        height: 58px;
        cursor: pointer;
        background: url('/js/slider/img/a22.png') center center no-repeat;
        overflow: hidden;
    }
    .jssora22l { background-position: -10px -31px; }
    .jssora22r { background-position: -70px -31px; }
    .jssora22l:hover { background-position: -130px -31px; }
    .jssora22r:hover { background-position: -190px -31px; }
    .jssora22l.jssora22ldn { background-position: -250px -31px; }
    .jssora22r.jssora22rdn { background-position: -310px -31px; }
    .jssora22l.jssora22lds { background-position: -10px -31px; opacity: .3; pointer-events: none; }
    .jssora22r.jssora22rds { background-position: -70px -31px; opacity: .3; pointer-events: none; }


    .jssort03 .p {
        position: absolute;
        top: 0;
        left: 0;
        width: 62px;
        height: 32px;
    }

    .jssort03 .t {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .jssort03 .w, .jssort03 .pav:hover .w {
        position: absolute;
        width: 60px;
        height: 30px;
        border: white 1px dashed;
        box-sizing: content-box;
    }

    .jssort03 .pdn .w, .jssort03 .pav .w {
        border-style: solid;
    }

    .jssort03 .c {
        position: absolute;
        top: 0;
        left: 0;
        width: 62px;
        height: 32px;
        background-color: #000;

        filter: alpha(opacity=45);
        opacity: .45;
        transition: opacity .6s;
        -moz-transition: opacity .6s;
        -webkit-transition: opacity .6s;
        -o-transition: opacity .6s;
    }

    .jssort03 .p:hover .c, .jssort03 .pav .c {
        filter: alpha(opacity=0);
        opacity: 0;
    }

    .jssort03 .p:hover .c {
        transition: none;
        -moz-transition: none;
        -webkit-transition: none;
        -o-transition: none;
    }

    * html .jssort03 .w {
        width /**/: 62px;
        height /**/: 32px;
    }

    .oCaption{
        position: absolute;
        font-weight:bold;
        width: 100%;
        padding:10px;
        text-align: center
    }

    .oCaption_txt{
        display:inline-block;
        padding:10px;
        background-color:rgba(80,80,80,0.2);
        text-shadow:1px 1px #ccc
    }


    .oCaption_btn{
        position: absolute;
        font-weight:bold;
        width: 100%;
        padding:10px;
        text-align: center
    }

    .btnClipPlay{
        cursor:pointer;
    }

    .oPlayerFrame{
        display:inline-block;
        background-color:#FFF;
        border:2px solid #333;
    }

    .objBackImg{
        width:auto !important;
        position:relative !important;
    }

    @media screen {
        .objPrint{display:none;}
    }

    @media print {
        .objScreen{display:none;}
    }

</STYLE>

<div id="slider1_container" class='objScreen' style="position: relative; top: 0px; left: 0px;">
    <div class='objSlideWrap' u="slides" style="cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: 600px; height: 300px;background-color:#000;background-image:url('/images/wm_black_2212.png');">
        <?php foreach($aSlideData as $sIdx => $sVal){
            print "<div class='bgSlide'  style=\"text-align:center !important;\">";
            printf("<img u='image' class='objBackImg' src='%s' />",$sVal);
            print "</div>";
        }?>

    </div>

    <!-- Thumbnail Navigator -->
    <div data-u="thumbnavigator" class="jssort03 objThumb" style="position:absolute;left:0px;bottom:0px;width:600px;height:60px;" data-autocenter="1">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height:100%; background-color: #000; filter:alpha(opacity=30.0); opacity:0.3;"></div>
        <!-- Thumbnail Item Skin Begin -->
        <div data-u="slides" style="cursor: default;">
            <div data-u="prototype" class="p">
                <div class="w">
                    <div data-u="thumbnailtemplate" class="t"></div>
                </div>
                <div class="c"></div>
            </div>
        </div>
        <!-- Thumbnail Item Skin End -->

        <div style='position:absolute;margin-top:20px;right:20px;'>
            <span style='display:inline-block;border-radius:5px;padding:3px 10px;background-color:#fff;cursor:pointer;color:#000;font-weight:bold;font-size:13px;' id='btnPrint'><IMG src='/images/printer20.png' align='absmiddle'> 인쇄하기</span>
        </div>
    </div>



    <!-- Bullet Navigator -->
    <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
        <!-- bullet navigator item prototype -->
        <div data-u="prototype" style="width:16px;height:16px;"></div>
    </div>

    <!-- Arrow Navigator -->
    <span data-u="arrowleft" class="jssora22l" style="top:0;left:10px;width:40px;height:58px;font-size:50px;" data-autocenter="2"></span>
    <span data-u="arrowright" class="jssora22r" style="top:0;right:10px;width:40px;height:58px;font-size:50px;" data-autocenter="2"></span>
</div>

<div class='objPrint'>
    <?php foreach((array)$aSlideData as $sIdx => $sVal){?>
        <?php if($sIdx > 0){?><div style='page-break-before:always'></div><?php }?>
        <div><img src='<?=$sVal?>' width='100%' alt></div>
    <?php }?>
</div>


<script type="text/javascript">
    <!--
    $(document).ready(function (){
        $("#btnPrint").click(function (e){
            e.stopImmediatePropagation();
            alert('프린터 기본설정을 통해 화면 가로 및 여백설정 후 인쇄해 주세요.');
            window.print();
        });
    });
    //-->
</script>

</body>
</html>
