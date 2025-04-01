<?php
/**
 * @var array $aList '컨텐츠 리스트'
 *
 */
?>
<div class="col-resize" ondrag="dragging(event)">
    <svg width="15" height="82" viewBox="0 0 15 82" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.5 1.3999L6.9585 7.3371C11.0784 11.1245 13.4231 16.4647 13.4231 22.061V59.9387C13.4231 65.5349 11.0784 70.8752 6.9585 74.6626L0.5 80.5998V1.3999Z" fill="#fff"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 82L7.87611 75.2193C12.1173 71.3204 14.5 66.0324 14.5 60.5185V21.4815C14.5 15.9676 12.1173 10.6796 7.8761 6.78073L0.5 0V1.40007L7.1146 7.48077C11.1538 11.194 13.4231 16.2302 13.4231 21.4815V60.5185C13.4231 65.7698 11.1539 70.806 7.11461 74.5192L0.5 80.5999V82Z" fill="#5a657726"></path><rect x="0.5" y="36" width="1.8" height="10" fill="#444d5c57" fill-opacity="0.34"></rect><rect x="4.5" y="36" width="1.8" height="10" fill="#444d5c57" fill-opacity="0.34"></rect></svg>
</div>

<!-- search form -->
<div class="d-flex flex-column mt-4">
    <div class="d-flex position-relative">
        <input name="search-text" class="form-control" style="padding-left: 2rem;box-sizing: border-box" value="" placeholder="템플릿 검색" />
        <input name="search-text-hidden" type="hidden" value=""/>
        <input name="search-type" type="hidden" value="_template"/>
        <i class="fa-solid fa-magnifying-glass position-absolute icon-magnifying"></i>
        <i class="fa-solid fa-xmark text-cancel position-absolute icon-text-cancel" style="display: none;cursor:pointer;" onclick="cancel_contents_lists();"></i>
    </div>
</div>

<!-- list contents -->
<div class="d-flex flex-column mt-4 overflow-y-scroll overflow-x-hidden scroll-ajax contents-list-container" style="padding-right: .75rem" data-act="category">
</div>

<!-- result  -->
<div class="result-list-wrap overflow-y-scroll overflow-x-hidden scroll-ajax" style="display: none;padding-right: .75rem" data-act="search" >
    <div class="justified-gallery"></div>
</div>

<script>
    $(function(){
        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

        var $scroll_ajax = $('.scroll-ajax');
        getLoadAjax($scroll_ajax.data('act'));
        $scroll_ajax.scroll(function(){
            var act = $(this).data('act');
            var scTop = parseInt($(this).scrollTop());
            var wrap_h = parseInt($(this).height());
            var wrap_sc_h = parseInt($(this)[0].scrollHeight);
            var chk_line = wrap_sc_h - (wrap_h*2);
            if(scTop > chk_line && page_ing === false && isLoadAjaxEnd === false){
                page_ing = true;
                getLoadAjax(act);
            }
        });

        applyDrag();
    });

</script>