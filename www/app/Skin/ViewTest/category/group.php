<?php
/**
 * @var array $aList  '컨텐츠리스트'
 * @var array $aInput '입력값'
 * @var object $encrypter '암호화object'
 * @var int $per_page '페이지당 갯수'
 */
?>

<style>
    .category-sub-title {font-size: 20px;font-weight: 600;}
    .contents-lists img.paid-mark{width: 40px!important;top: 10px;right:10px;z-index: 999}
    @media (min-width: 992px) {
        .contents-lists img.paid-mark{width: 35px!important;top: 10px;right:10px;z-index: 999}
    }
</style>

<main class="main-ctgr">
    <div class="container-fluid px-lg-5">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center"><?=$aInput['page_title']?></h1>
            <p class="text-center mt-3" style="font-weight: 600"></p>
        </div>

        <div class="d-flex flex-column mt-5 gap-5 contents-lists">

            <?php foreach ($aList as $r) {?>

                <?php if(count($r['templates']) > 0){?>

                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between">
                        <a href="/Category/<?=$aInput['menu_type']?>/<?=$r['group_id']?>" class="category-sub-title d-flex align-items-center"><?=$r['title']?></a>
                        <a href="/Category/<?=$aInput['menu_type']?>/<?=$r['group_id']?>" class="d-flex align-items-center">더보기</a>
                    </div>
                    <div class="justified-gallery">
                        <?php foreach ($r['templates'] as $rr) {
                            $strEnc = sprintf("%s_template__%s",date('YmdHis'),$rr["template_id"]);
                            $sEnc = urlencode($encrypter->encrypt($strEnc));
                            ?>
                            <a href="/Canvas?e=<?=$sEnc?>" target="_blank" class="goCanvas img-thumbnail">
                                <img src="<?=$rr["thumb_file"]?>" alt="<?=$rr["title"]?>"  />

                                <?php if($rr['paid_yn'] == 'Y' && session('isPay') == false){?>
                                <span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>
                                <?php } ?>

                            </a>
                        <?php }?>
                    </div>
                </div>

                <?php } ?>

            <?php } ?>
        </div>
    </div>
</main>

<script type="text/javascript">

    var isLoadAjaxEnd = false;
    var loc_page = 2;
    var page_ing = false;
    var setH = 150;
    $(function() {
        if( check_mobile() ) setH = 135;
        if($('.justified-gallery').length > 0){
            //이미지 상하정렬
            $('.justified-gallery').justifiedGallery({
                rowHeight : setH,
                lastRow : 'nojustify',
                maxRowsCount : 1,
                border : 2,
                margins : 10
            });
        }

        $(window).scroll(scrollPaging);

    });

    function scrollPaging(){

        var win_t = $(window).scrollTop();
        var win_h = $(window).height();
        var curr_b = win_t + win_h;
        var body_h = $('body').height();

        if( curr_b >= (body_h - win_h) && isLoadAjaxEnd === false && page_ing === false  ){
            getLists()
        }

    }

    var menu_type = '<?=$aInput['menu_type']?>';

    function getLists(){

        page_ing = true;

        var url = '/Category/'+menu_type+'/getLists';
        var obj = { page : loc_page , menu_type : menu_type};

        $.ajax({
            type: 'post',
            url: url,
            data: obj,
            dataType: 'json',
            async: false,
            success: function(result){
                if(result.data.length < <?=$per_page?>) isLoadAjaxEnd = true; //리스트가 마지막이라면 더이상 ajax 함수 실행안하도록
                if(result.data.length > 0) printList(result.data);
            }

        }).done(function(){

            loc_page++;
            page_ing = false;

        });

    }

    function printList(data){

        var html = '';
        $.each(data,function(k,r){
            html += '<div class="d-flex flex-column gap-2">';
            html += '   <div class="d-flex justify-content-between">';
            html += '       <a href="/Category/'+menu_type+'/'+r.group_id+'" class="category-sub-title d-flex align-items-center">'+r.title+'</a>';
            html += '       <a href="/Category/'+menu_type+'/'+r.group_id+'" class="d-flex align-items-center">더보기</a>';
            html += '   </div>';
            html += '   <div class="justified-gallery">';
            $.each(r['templates'],function(kk,rr){
                html += '       <a href="/Canvas?e='+rr.sEnc+'" target="_blank" class="goCanvas img-thumbnail">';
                html += '           <img src="'+rr.thumb_file+'" alt="'+rr.title+'"  />';
                html += '       </a>';
            })
            html += '   </div>';
            html += '</div>';
        });

        $('.contents-lists').append(html);

        $('.justified-gallery').justifiedGallery({
            rowHeight : setH,
            lastRow : 'nojustify',
            maxRowsCount : 1,
            border : 2,
            margins : 10
        });

    }


</script>