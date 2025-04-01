<?php
/**
 * @var array $aList  '컨텐츠리스트'
 * @var array $aInput '입력값'
 * @var object $encrypter '암호화object'
 * @var int $per_page '페이지당 갯수'
 */
?>
<main class="main-ctgr">
    <div class="container-fluid">
        <?php if(count($aList) < 1){?>
            <div class="row my-5 align-items-center justify-content-center fs-3">
                <?=$aInput['search_text']?> : 검색결과가 없습니다.
            </div>
        <?php }else {?>
            <div class="row my-5 align-items-center justify-content-center fs-3">
                <?=$aInput['search_text']?> : 검색결과
            </div>
            <div class="contents-lists mt-5 mx-1 mx-lg-5 result-list">
                <ul class="grid p-0">
                    <?php
                    foreach($aList as $aRow){
                        $strEnc = sprintf("%s_template__%s",date('YmdHis'),$aRow["template_id"]);
                        $sEnc = urlencode($encrypter->encrypt($strEnc));
                        ?>
                        <li class="grid-items">
                            <a href="/Canvas?e=<?=$sEnc?>" target="_blank" class="position-relative goCanvas ratio-<?=$aRow['rotate']?>">
                                <img src="<?=$aRow["thumb_file"]?>" alt="<?=$aRow["title"]?>" />
                                <span class="position-absolute"><?=$aRow["title"]?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php }?>
    </div>
</main>


<script type="text/javascript">

    var $isotope = null;
    var isLoadAjaxEnd = false;
    var loc_page = 2;
    var page_ing = false;
    var search_text = '<?=$aInput['search_text']?>';
    var search_type = '<?=$aInput['search_type']?>';

    $(function() {
        if ($('.grid').length > 0) {
            $isotope = $(".grid").isotope({
                    layoutMode: 'masonry'
                ,   masonry: {
                    columnWidth: '.grid-items'
                    ,   gutter: 30
                }
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

    function getLists(){

        page_ing = true;

        var obj = { page : loc_page , search_text : search_text , search_type : search_type};

        $.ajax({
            type: 'post',
            url: "/Search/getLists",
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
            html += '<li class="grid-items">';
            html += '   <a href="/Canvas?e='+r.sEnc+'" target="_blank" class="position-relative goCanvas ratio-'+r.rotate+'">';
            html += '       <img src="'+r.thumb_file+'" alt="'+r.title+'" />';
            html += '       <span class="position-absolute">'+r.title+'</span>';
            html += '   </a>';
            html += '</li>';
        });

        var $html = $(html);
        $isotope.append($html)
        $isotope.isotope('appended', $html);

    }

</script>
