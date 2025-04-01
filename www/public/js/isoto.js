"use strict";

var isLoadAjaxEnd = false;
var loc_page = 1;
var page_ing = false;
var $isotope = null;
var gutter = 30;
var $isotopeActive = false;

$(function(){

    getLists(false);

    $(window).scroll(scrollPaging);

    if(check_mobile()) gutter = 10;

    var $contents_category = $('.contents-category');

    //월별 디자인인 경우
    if($contents_category.length > 0) {

        $('.ctgr-month-right-arrow').on('click',function(){
            // alert('>');
        });

        $('.ctgr-month-left-arrow').on('click',function(){
            // alert('<');
        });

        $('.goGetMonth').on('click',function(){
            loc_page = 1; //초기화
            isLoadAjaxEnd = false;

            $('.goGetMonth').removeClass('active');
            $(this).addClass('active');

            getLists(false);
        });

        $contents_category.animate({ scrollLeft: $('.goGetMonth.active').offset().left-20 }, 0);

        $contents_category.scroll(function(){
            var $contents_category = $('.contents-category');
            var $r_arrow = $('.contents-category-wrap .ctgr-month-right-arrow');
            var $l_arrow = $('.contents-category-wrap .ctgr-month-left-arrow');
            var r_val = Math.round($(this).scrollLeft() + $contents_category.width());
            var tot_w = Math.round($contents_category[0].scrollWidth);

            if($(this).scrollLeft() > 0 && $l_arrow.hasClass('d-none') ){
                $l_arrow.removeClass('d-none').addClass('d-flex');
            }else if($(this).scrollLeft() === 0){
                $l_arrow.addClass('d-none').removeClass('d-flex');
            }

            if( r_val < tot_w && $r_arrow.hasClass('d-none') ){
                $r_arrow.removeClass('d-none').addClass('d-flex');
            }else if( r_val === tot_w ){
                $r_arrow.addClass('d-none').removeClass('d-flex');
            }

        });

    }

});

function scrollPaging(){

    var win_t = $(window).scrollTop();
    var win_h = $(window).height();
    var curr_b = win_t + win_h;
    var body_h = $('body').height();

    if( curr_b >= (body_h - win_h) && isLoadAjaxEnd === false && page_ing === false  ){
        getLists(true)
    }

}

function getLists(isAppend){

    page_ing = true;

    if(menu_type === 'month') group_id = $('.goGetMonth.active').data('seq');

    var url = '/Category/'+menu_type+'/'+group_id+'/getLists';
    var obj = { page : loc_page };

    $.ajax({
        type: 'post',
        url: url,
        data: obj,
        dataType: 'json',
        async: false,
        success: function(result){
            if(result.data.length > 0){
                if(result.data[0].templates.length < per_page) isLoadAjaxEnd = true; //리스트가 마지막이라면 더이상 ajax 함수 실행안하도록
                printList(result.data , isAppend);
            }
        }

    }).done(function(){
        loc_page++;
        page_ing = false;

    });

}

function printList(data , isAppend){

    var $grid = $(".grid");
    var data_sub = data[0];
    var html = '';

    if( data_sub['menu_type'] === 'play' || data_sub['menu_type'] === 'event' ) {
        $('.contents-lists .category-sub-title').html(data_sub.title);
    }

    if(data_sub['templates'].length < 1){
        if(isAppend === false && $isotopeActive) {
            $grid.isotope('destroy').html("<li class=\"d-flex justify-content-center\">준비 중입니다.</li>");
            $isotopeActive = false;
            return false;
        }
    }else{

        if(data_sub['templates'].length > 0){
            $.each(data_sub['templates'],function(k,r){
                html += '<li class="grid-items">';
                html += '   <a href="/Canvas?e='+r.sEnc+'" target="_blank" class="position-relative goCanvas ratio-'+r.rotate+'">';
                html += '       <img src="'+r.thumb_file+'" alt="'+r.title+'" />';
                html += '       <span class="position-absolute">'+r.title+'</span>';
                if(r.paid_yn === 'Y' && paid_user === 'N'){
                html += '       <img src="/img/paid_mark.png" class="paid-mark position-absolute" alt="유료마크">';
                }
                html += '   </a>';
                html += '</li>';
            });

            if(isAppend === true){

                var $html = $(html);
                $isotope.append($html).isotope('appended', $html );//.isotope('layout');
                $isotopeActive = true;
            }else{

                if($isotopeActive) {
                    $grid.isotope('destroy').html(html);
                    $isotopeActive = false;
                }else{
                    $grid.html(html);
                }

                $isotope = $grid.isotope({
                    layoutMode: 'masonry'
                    ,   masonry: {
                        columnWidth: '.grid-items'
                        ,   gutter: gutter
                    }
                });
                $isotopeActive = true;
                // $isotope.isotope('reloadItems').isotope('layout');

            }

        }else{
            html += '<li class="d-flex justify-content-center">준비 중입니다.</li>';
            if($isotopeActive) {
                $grid.isotope('destroy').html(html);
            }else{
                $grid.html(html);
            }

            $isotopeActive = false;
        }

    }

}
