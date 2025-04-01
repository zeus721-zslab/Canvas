"use strict";

function loader(msg){
    if(typeof msg !== 'string') msg = '처리 중 입니다.';
    var $loader_area = $('.--loader-area');

    if($loader_area.length < 1){
        var html  = '<div class="--loader-area">';
        html += '   <div class="--loader-bg"></div>';
        html += '       <div class="--loader-wrap">';
        html += '       <div class="--loader"></div>';
        html += '       <span>'+msg+'</span>';
        html += '   </div>';
        html += '</div>';

        $('body').append(html);

    }else{
        $loader_area.fadeOut(200,function (){
            $loader_area.remove();
        });
    }

}