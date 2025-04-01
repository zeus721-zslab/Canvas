<?php
/**
 * @var array $aList '컨텐츠 리스트'
 * @var object $encrypter '암호화object'
 */
?>
<!--  webfont -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
<main>
    <div class="container-fluid w-1560">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center">내 보관함</h1>
            <p class="text-center mt-3" style="font-weight: 600"></p>
        </div>

        <div class="row contents-lists mt-5">
            <div class="col-12">
                <ul class="grid p-0">
                <?php
                foreach($aList as $aRow){
                    $strEnc = sprintf("%s_my_%s_",date('YmdHis'),$aRow["my_canvas_id"]);
                    $sEnc = urlencode($encrypter->encrypt($strEnc));
                    ?>


                    <li class="grid-items" style="background-color: #fff;overflow: inherit">
                        <figure class="figure d-flex gap-1 flex-column">
                            <a href="/Canvas?e=<?=$sEnc?>" target="_blank" class="ratio-<?=$aRow['rotate']?> position-relative goCanvas d-inline-block rotate-<?=$aRow['rotate']?>" style="background-color: #f8f8f8;">
                                <img src="<?=$aRow["thumb_file"]?>" alt="<?=$aRow["title"]?>" class="w-100" />
                                <div class="moreAct bg-secondary position-absolute d-flex d-md-none align-items-center justify-content-center text-white zs-cp bottom-0">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                                <ul class="moreList fs-6 d-none position-absolute flex-column shadow-sm fs-7" data-id="<?=$aRow["my_canvas_id"]?>" >
                                    <li data-type="copy">복사하기</li>
                                    <li data-type="down">다운로드</li>
                                    <li data-type="del">삭제하기</li>
                                </ul>
                            </a>
                            <figcaption class="figure-caption d-flex position-relative" >
                                <span contenteditable="true" data-id="<?=$aRow["my_canvas_id"]?>"><?=$aRow["title"]?></span>
                                <i class="fa-regular fa-pen-to-square position-absolute" style="display: none"></i>
                            </figcaption>
                        </figure>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">

    var $isotope = null;
    var aCanvas = [];
    var aJson = [];
    var prev_title = '';
    var aFontFamily = ['Nanum Gothic', 'Nanum Myeongjo', 'IM_HyeminRegular', 'GangwonEduAllLight', 'MaplestoryLight', 'Yangjin', 'Jalnan', 'ONE_MobilePOP', 'INKLIPQUID', 'GmarketSansTTFMedium', 'CookieRunRegular', 'TMONBlack', 'Black And White Picture', 'Black Han Sans', 'Cute Font', 'Dokdo', 'East Sea Dokdo', 'Dongle', 'Gaegu', 'Gamja Flower', 'Gowun Dodum', 'Gugi', 'Hahmlet', 'Hi Melody', 'Kirang Haerang', 'Nanum Pen Script', 'Nanum Brush Script', 'Poor Story', 'Single Day', 'Stylish', 'Yeon Sung', 'Do Hyeon', 'Jua', 'Sunflower'];
    var LoadedFont = false;

    $(function() {

        if ($('.grid').length > 0) {
            $isotope = $(".grid").isotope({
                layoutMode: 'masonry'
                ,   masonry: {
                    columnWidth: '.grid-items'
                    ,   gutter: 10
                }
            });
        }

        $('.figure-caption span').on('focus',function(){
            $(this).siblings('i').show();
            prev_title = $(this).text();
        }).on('blur',function(){
            $(this).siblings('i').hide();

            var title = $(this).text();
            var id = $(this).data('id');

            if(prev_title === title) return false;

            $.ajax({
                url: "/My/"+id+"/action/change_title",
                data: { _csrf : $('input[name="_csrf"]').val() , title : title },
                method: "post",
                dataType: "json",
                success: function (result) {
                    if(result.msg) alert(result.msg);
                }
            });

        }).on('keydown',function(e){
            var key = e.keyCode || e.charCode;  // ie||others
            if(key === 13)  // if enter key is pressed
                $(this).blur();  // lose focus
        }).on('mouseenter',function(){
            $(this).siblings('i').show();
        }).on('mouseleave',function(){
            if($(this).is(':focus') === false) $(this).siblings('i').hide();
        });

        $('.grid-items').on('mouseenter',function(){
            $(this).find('.moreAct').removeClass('d-md-none');
        }).on('mouseleave',function(){
            $(this).find('.moreAct').addClass('d-md-none');
            if( $(this).find('.moreList').hasClass('d-flex') ){
                $(this).find('.moreList').toggleClass('d-flex').toggleClass('d-none');
            }
        });

        $('.moreList li').on('click',function(e) {
            e.stopImmediatePropagation();
            e.preventDefault();

            var id = $(this).parent().data('id');
            var type = $(this).data('type');

            if(type === 'del'){
                if(!confirm("삭제 후 복구가 불가능합니다.\n삭제 하시겠습니까?")) return false;
            }else if(type === 'copy'){
                if(!confirm("복사 하시겠습니까?")) return false;
            }else if(type === 'down'){
                if(confirm("다운로드 하시겠습니까?")) {
                    var href = $(this).parents('a').attr('href')+'&act=down';
                    win_open(href);
                }

                return true;
            }

            $.ajax({
                url: "/My/"+id+"/action/"+type,
                data: { _csrf : $('input[name="_csrf"]').val() },
                method: "post",
                dataType: "json",
                success: function (result) {
                    if(result.msg) alert(result.msg);
                    if(result.success) location.reload();
                }
            });

        });

        $('.moreAct').on('click',function(e){
            e.stopImmediatePropagation();
            e.preventDefault();
            $(this).parent().find('.moreList').toggleClass('d-flex').toggleClass('d-none');
        });

    });

</script>




















