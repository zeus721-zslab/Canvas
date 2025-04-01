"use strict";

/**
 * 객체가 있는지 없는지 체크
 * @param obj
 * @returns {boolean}
 */
function empty(obj) {
    if( typeof(obj) != 'undefined' && obj != null && obj != '' ) {
        return false;
    }
    else {
        return true;
    }
}//end of empty()

/**
 * 고유한 문자열 생성
 * @returns {string}
 */
function create_uniqid() {
    var d = new Date().getTime();
    if(window.performance && typeof window.performance.now === "function"){
        d += performance.now();; //use high-precision timer if available
    }
    var uid = 'xxxxyxxxxyxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uid;
}//end of create_uniqid()

//================== 날짜 관련
Number.prototype.padLeft = function(base,chr){
    var  len = (String(base || 10).length - String(this).length)+1;
    return len > 0? new Array(len).join(chr || '0')+this : this;
};

function get_ymd(div,date) {
    if(date == '' || date == undefined) var date = new Date();
    if( empty(div) ) {
        div = '-';
    }
    return [date.getFullYear(), (date.getMonth()+1).padLeft(), date.getDate().padLeft()].join(div);
}


/**
 * 숫자만
 * @param str
 * @returns {*}
 */
function number_only(str) {
    if( empty(str) ) {
        return '';
    }
    return str.replace(/[^0-9]/gi, "");
}//end of number_only()

//document.ready
$(function(){

});

$(document).ajaxError((event, jqXHR, ajaxSettings, thrownError) => {
    if(jqXHR.status === 403) {
        alert("요청하신 작업 권한이 없습니다.\nthrownError : "+thrownError);
    }else if(jqXHR.status === 404){
        alert("없는 페이지 입니다.\nthrownError : "+thrownError);
    }else if(jqXHR.status === 500 || jqXHR.status === 501 || jqXHR.status === 502 || jqXHR.status === 503){
        alert("개발자에게 문의하세요.\nthrownError : "+thrownError);
    }
});


// 숫자만 입력받음
$(document).on('keypress keyup', 'input[type="text"][numberOnly],input[type="tel"][numberOnly]', function(e) {
    $(this).val(number_only($(this).val()));
});

//입력 최대글자수 체크
$(document).on('keypress keyup', 'input[type="text"][maxlenthCheck],input[type="tel"][maxlenthCheck],input[type="number"][maxlenthCheck]', function(e) {

    var max = $(this).attr('maxlength');
    if( !max ) {
        return true;
    }

    var len = $(this).val().length;

    if( len >= max ) {
        /* *
         * @date180309 황기석
         * @desc 모바일에서 처리안됨에 따라 아래 구문 추가
         * */
        this.value = this.value.slice(0, max);
        e.preventDefault();
        return false;
    }
});

//이미지 바로보기
$(document).on('click','.goViewImg',function(){
    var href = $(this).data('org_src');
    var win = window.open('', '_blank');
    win.location.href = href;
});


//이미지 바로보기
$(document).on('click','.goUpsertTemplate',function(e){
    e.preventDefault();

    var href = $(this).attr('href');
    var win = window.open('', '_blank');
    win.location.href = href;
});


$(document).on('click','a[href="#none"],a[href="#"]',function(e){
    e.preventDefault();
    return false;
});


function setAllChecked(){
    $('[class^="icheck-"] input[type="checkbox"]').on('click',function(){
        if($(this).val() === '') $('[class^="icheck-"] input[type="checkbox"]').prop('checked' , $(this).prop('checked')); //전체 체크를 클릭했을때
        else{ //전체 체크가 아닌 항목을 클릭했을 때

            var $inputName          = $(this).attr('name');
            var $iCheckboxAll       = $('input[name="'+$inputName+'"]').not('[value=""]').length;
            var $iCheckboxChecked   = $('input[name="'+$inputName+'"]:checked').not('[value=""]').length;

            if($iCheckboxAll === $iCheckboxChecked) $('input[name="'+$inputName+'"][value=""]').prop('checked' , true);
            else $('input[name="'+$inputName+'"][value=""]').prop('checked' , false);
        }
    })
}

function phLog(tn,nm,obj){

    $.ajax({
        url: "/Common/PrivacyHistoryLog",
        data: { tn : tn , nm : nm , csrf : $('input[name="csrf"]').val() },
        method: "post",
        dataType: "json",
        success: function (result) {

            if( result.success === true ) single_download(obj);
            $('input[name="csrf"]').val(result.csrf);
        }
        , error:function(err){
        }
    });


}

function single_download(obj){

    var id = $(obj).data('id');
    if(typeof id ===  'undefined' || id === '' ){
        alert('필수입력정보누락');
        return false;
    }
    //iFrame으로 처리
    $('#hiddenFrame').attr('src','/Common/download_file?file_id='+id);

}


function go_home(){
    location.href = '/';
}

function FileChk(obj){
    if(obj.val() != ''){
        var file_size = obj[0]['files'][0]['size'];
        var size_mb = (file_size / 1024) / 1024;
        if(size_mb >= 10){
            alert('첩부파일은 10메가 미만 파일만 업로드가 가능합니다.');
            obj.val('');
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }

}

function MimeChk(obj){
    if(obj.val() != ''){
        return obj[0]['files'][0]['type'];
    }
}


//desc http://daplus.net/javascript-%EC%9E%90%EB%B0%94-%EC%8A%A4%ED%81%AC%EB%A6%BD%ED%8A%B8-%EB%AC%B8%EC%9E%90%EC%97%B4%EC%9D%B4-url%EC%9D%B8%EC%A7%80-%ED%99%95%EC%9D%B8/
function validURL(str) {

    try {
        new URL(str);
    }catch (e){
        return false;
    }

    return true;
    // var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    //     '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
    //     '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    //     '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
    //     '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
    //     '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
    // return !!pattern.test(str);
}

//이메일 유효성검사
//desc https://www.thewordcracker.com/jquery-examples/email-validation-javascript/
function isEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function getCookie(name) {
    return $.cookie(name);

    // var lastChrCookie;
    // var cookieName = name + "=";
    // var x = 0;
    // while ( x <= document.cookie.length ) {
    //     var y = (x+cookieName.length);
    //     if ( document.cookie.substring( x, y ) == cookieName) {
    //         if ((lastChrCookie=document.cookie.indexOf(";", y)) == -1)
    //             lastChrCookie = document.cookie.length;
    //         return decodeURI(document.cookie.substring(y, lastChrCookie));
    //     }
    //     x = document.cookie.indexOf(" ", x ) + 1;
    //     if ( x == 0 )
    //         break;
    // }
    // return "";
}

function setCookie(cname, value, expire) {
    if(empty(expire) === true) expire = 365;
    $.cookie(cname, value , { expires: expire, path: '/', domain: 'medioz.kr'});
}

//input tag Add >> onkeyup="moveFocus(this,4,'cellphone3')"
function moveFocus(obj,no,nextObj){
    if(obj.value.length === no){
        $('#'+nextObj).focus();
    }
}

function chkSpace(str){
    var space_pattern = /[\s]/g;
    return space_pattern.test(str);
}

function isEmpty(val){
    return (val === undefined || val === null || val.length <= 0 || (Object.keys(val).length === 0 && val.constructor === Object));
}

function setLnb(lnb_info){

    let lnb_html = "";
    let sub_menu_name = "";
    let menu_name = "";

    if( typeof lnb_info === 'object' ){
        $.each(lnb_info , function(k,r){

            var active_class = "";
            var open_class = "";
            var href_url = "href=\"javascript:;\"";

            if(r.active === 'Y') {
                if(r.sub_menu.length > 0) open_class = "menu-open menu-is-open";
                active_class = "active";
                menu_name = r.name;
            }

            if(r.sub_menu.length < 1)
                href_url = "href=\""+r.path+"\"";

                lnb_html += "<li class=\"nav-item "+open_class+"\" >";

                lnb_html += "   <a "+href_url+" class=\"nav-link "+active_class+"\">";
                lnb_html += "       <i class=\"nav-icon fas fa-circle\"></i>";
                lnb_html += "       <p>";
                lnb_html += r.name;
                if(r.sub_menu.length > 0) lnb_html += "<i class=\"right fas fa-angle-left\"></i>";
                lnb_html += "       </p>";
                lnb_html += "   </a>";

            if(r.sub_menu.length > 0){

                //submenu active chk

                lnb_html += "<ul class=\"nav nav-treeview\">";

                $.each(r.sub_menu, function(kk,rr){

                    var sub_active = '';
                    if( rr.sub_active === 'Y' ) {
                        sub_active = 'active';
                        sub_menu_name = rr.sub_menu_name;
                    }
                    lnb_html += "<li class=\"nav-item\">";
                    lnb_html += "   <a href=\""+rr.path+"\" class=\"nav-link "+sub_active+"\">";
                    lnb_html += "       <i class=\"nav-icon far fa-circle\"></i>";
                    lnb_html += "       <p>"+rr.sub_menu_name+"</p>";
                    lnb_html += "   </a>";
                    lnb_html += "</li>";
                });

                lnb_html += "</ul>";

            }

            lnb_html += "</li>";

        });

        $('ul.nav-sidebar').html(lnb_html);

        if(sub_menu_name) $('.content-wrapper .sub_manu_name').html(sub_menu_name);
        else $('.content-wrapper .sub_manu_name').html(menu_name);
        $('.content-wrapper .manu_name').html(menu_name);
    }
}

function check_mobile() {

    var agent = window.navigator.userAgent;

    const mobileRegex = [
        /Android/i,
        /iPhone/i,
        /iPad/i,
        /iPod/i,
        /BlackBerry/i,
        /Windows Phone/i
    ]

    return mobileRegex.some(mobile => agent.match(mobile))
}

// 주민등록번호 유효성 체크
function isJuminNo(no) {

    // -제거
    no = no.split('-').join('');

    var arr_ssn = [];
    var compare = [2,3,4,5,6,7,8,9,2,3,4,5];
    var sum     = 0;

    // 입력값 체크
    if (no.match('[^0-9]')) {
        return false;
    }

    // 자리수 체크
    if (no.length != 13) {
        return false;
    }

    // 공식: M = (11 - ((2×A + 3×B + 4×C + 5×D + 6×E + 7×F + 8×G + 9×H + 2×I + 3×J + 4×K + 5×L) % 11)) % 10
    for (var i = 0; i < 13; i++) {
        arr_ssn[i] = no.substring(i,i+1);
    }

    for (var i = 0; i < 12; i++) {
        sum = sum + (arr_ssn[i] * compare[i]);
    }

    sum = (11 - (sum % 11)) % 10;

    if (sum != arr_ssn[12]) {
        return false;
    }

    return true;

}


// 법인등록번호 유효성 체크
function isBubinNo(no) {

    // -제거
    no = no.split('-').join('');

    var as_Biz_no = String(no);
    var isNum = true;
    var I_TEMP_SUM = 0 ;
    var I_TEMP = 0;
    var S_TEMP;
    var I_CHK_DIGIT = 0;

    if (no.length != 13) {
        return false;
    }

    for (var index01 = 1; index01 < 13; index01++) {
        var i = index01 % 2;
        var j = 0;

        if(i == 1) j = 1;
        else if( i == 0) j = 2;

        I_TEMP_SUM = I_TEMP_SUM + parseInt(as_Biz_no.substring(index01-1, index01),10) * j;
    }

    I_CHK_DIGIT= I_TEMP_SUM%10;
    if (I_CHK_DIGIT != 0 ) I_CHK_DIGIT = 10 - I_CHK_DIGIT;

    if (as_Biz_no.substring(12, 13) != String(I_CHK_DIGIT)) return false;

    return true;

}

// 사업자등록번호 유효성 체크
function isCorporateRegiNo(no) {

    var numberMap = no.replace(/-/gi, '').split('').map(function (d){
        return parseInt(d, 10);
    });

    if (numberMap.length == 10) {

        var keyArr = [1, 3, 7, 1, 3, 7, 1, 3, 5];
        var chk = 0;

        keyArr.forEach(function(d, i){
            chk += d * numberMap[i];
        });

        chk += parseInt((keyArr[8] * numberMap[8])/ 10, 10);
        return Math.floor(numberMap[9]) === ( (10 - (chk % 10) ) % 10);

    }

    return false;

}
//휴대폰 번호
function isCelltel(hp){
    if(hp === "") return true;
    var phoneRule = /^(01[016789]{1})[0-9]{3,4}[0-9]{4}$/;
    return phoneRule.test(hp);
}


$(function(){
    //icheck를 필터로 사용하는 경우 전체 체크 관련 처리
    if( $('[class^="icheck-"] input[type="checkbox"]').length > 0 ){ //check object icheck
        if($('[class^="icheck-"] input[type="checkbox"][value=""]').length > 0) setAllChecked();
    };
});

//var.ltrim();
String.prototype.ltrim = function() {
    return this.replace(/^\s+/,"");
}
//var.rtrim();
String.prototype.rtrim = function() {
    return this.replace(/\s+$/,"");
}
