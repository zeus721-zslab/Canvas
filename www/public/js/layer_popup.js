"use strict";

var __popup = {
        target:'--layer-popup-wrap' //기본 아이디
    ,   nPopup:0 //오픈된 팝업 수
    ,   z_index:2000 //zindex
    ,   m_w: 250 //최소 가로px
    ,   m_h: 250 //최소 세로px
    ,   def_w: 500 //기본 가로px
    ,   def_h: 600 //기본 세로px
    ,   init : function(title, w=500, h=600){

        this.nPopup++;
        this.z_index++;
        if(w <= this.m_w) w = this.m_w;
        if(h <= this.m_h) h = this.m_h;
        if(w == null) w = this.def_w;
        if(h == null) h = this.def_h;

        var w_str       = w + 'px';
        var h_str       = h + 'px';
        var top_str     = 'calc(50% - ' + (h/2) +'px )';
        var left_str    = 'calc(50% - ' + (w/2) +'px )';
        var target_id   = this.target+this.nPopup;

        if($('#'+target_id).length < 0){
            alert('이미 같은 depth의 팝업이 있습니다. 담당자에게 문의하세요');
            return false;
        }

        var popup_html  = '<div id="'+target_id+'" class="--layer-popup-wrap" style="z-index: '+this.z_index+'">';
            popup_html += '     <div class="--layer-popup-bg"></div>';
            popup_html += '     <div class="--layer-popup-container d-flex flex-column justify-content-start align-items-center" style="top:'+top_str+';left: '+left_str+'; height: '+h_str+'; width: '+w_str+'">';
            popup_html += '         <div class="--layer-popup-header d-flex">';
            popup_html += '             <span class="--layer-popup-title">'+title+'</span>';
            popup_html += '             <span class="--layer-popup-close" onclick="__popup.close('+this.nPopup+')"><i class="fa-solid fa-xmark"></i></span>';
            popup_html += '         </div>';
            popup_html += '         <div class="--layer-popup-main"></div>';
            popup_html += '     </div>';
            popup_html += '</div>';

        $('body').append(popup_html);

    }
    ,   setMain : function(html){
        var target_id   = this.target+this.nPopup;
        $('#'+target_id+' .--layer-popup-main').html(html);
    }
    ,   open : function(){
        $('body').css('overflow','hidden');
        $('#--layer-popup-wrap'+this.nPopup).fadeIn(200);
    }
    ,   close : function(seq = ''){

        if(seq === '' ) seq = __popup.nPopup;

        $('#--layer-popup-wrap'+seq).fadeOut(50,function(){
            $('#--layer-popup-wrap'+seq).remove();
            if($('.--layer-popup-wrap').length < 1) $('body').css('overflow','auto');
        });
        this.nPopup--;
        this.z_index--;
    }

}
$(document).on('click','.--layer-popup-bg',function(e){
    e.stopImmediatePropagation();
    __popup.close(__popup.nPopup);
});
$(document).on('keyup',function(e){
    e.preventDefault();
    if(e.keyCode === 27 && $('.--layer-popup-wrap').length > 0){
        __popup.close(__popup.nPopup);
    }
})