"use strict";

$(function(){
    //검색창관련
    if( $('input[name="header_search_text"]').length > 0 ) {
        $('input[name="header_search_text"]').on('keyup', function(e){
            e.preventDefault();
            if( e.keyCode === 13 ) goHeaderSearch();
        });
    }
    $('.header-search .icon-magnifying').on('click', goHeaderSearch);
});

function goHeaderSearch(){
    var $obj = $('.header-search');

    var val_q = $obj.find('input[name="header_search_text"]').val();
    var val_t = $obj.find('.search_type:checked').val();
    if( val_q === '' ){
        alert('검색하실 단어를 입력해주세요');
        $obj.find('input[name="header_search_text"]').focus();
        return false;
    }

    $('.header_search_form input[name="t"]').val(val_t);
    $('.header_search_form input[name="q"]').val(val_q);
    $('.header_search_form').submit();

}