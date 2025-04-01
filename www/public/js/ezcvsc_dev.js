"use strict";

var aCanvas = new Array(100);
var nCanvasNo = 0;
var nCurPageNo = 0;
var oCanvas;
var curObj;
var nPage = 0;
var bSave = false;
var nCurZoom = null;
var _clipboard = null;
var isFirst = true; // InitCanvas 시 처음인 경우에만 zoom처리하기 위한 flag
var isRemoveHistory = false;
var isFontLoaded = false; //폰트 loading 여부 확인
var page_ing = false; //페이지 로딩여부
var loc_page = 1; //
var isLoadAjaxEnd = false; //페이지완료여부
var dialog;
var nHistory = -1;
var aHistory = [];
var aOriginal = [];
var downloadInterval = null;
var completeRemakePage = false;
var save_ing = false;//저장중 여부
$(window).bind("beforeunload", function (e){
	if (bSave){
		return "창을 닫으실래요?";
	}
});

$(window).on('copy',function(e){
	// e.preventDefault();
	// e.originalEvent.clipboardData.setData()
	// console.log(e.originalEvent.clipboardData.items);
	//
	// var text = '' , ret = false;
	// if(window.getSelection) text = window.getSelection().toString();
	//
	// if(text){
	// 	ret = true;
	// }else{
	// 	oCanvas.getActiveObject().clone(function (cloned) {
	// 		_clipboard = cloned;
	// 	});
	// 	oCanvas.renderAll();
	// 	onUpdate();
	// 	$(".objPopMenu").hide();
	// }

});

$(window).on('paste',function (e){

	// var SystemData = 0;
	// var CanvasData = 0;
	// if(e.originalEvent.clipboardData.files.length > 0) SystemData = parseInt(e.originalEvent.clipboardData.files[0].lastModified) - parseInt(e.originalEvent.timeStamp) + 5800;
	// if(_clipboard !== null) CanvasData = _clipboard.lastModified;
	//
	// console.log('SystemData : '+SystemData , 'CanvasData : '+CanvasData);
	//
	// function canvasImage(url) {
	// 	fabric.Image.fromURL(url, function(img) {
	// 		oCanvas.add(img);
	// 	});
	// }
	//
	// if(CanvasData < 1 && SystemData > 0 ){
	// 	console.log('case 1');
	//
	//
	// 	for(var i=0;i<items.length;i++){
	// 		var file = items[i],
	// 			type = file.type;
	//
	// 		if (type.indexOf("image")!=-1) {
	// 			e.preventDefault();
	// 			isSystemPaste = true;
	//
	// 			var imageData = file.getAsFile();
	// 			var reader  = new FileReader();
	// 			reader.readAsDataURL(imageData);
	// 			reader.onloadend = function() {
	// 				var base64data = reader.result;
	// 				canvasImage(base64data);
	// 			}
	// 		}
	// 	}
	//
	//
	// }else if(SystemData < 1 && CanvasData > 0){
	// 	console.log('case 2');
	// 	procPaste();
	//
	// }else if(SystemData > 0 && CanvasData > 0){
	//
	// 	if(SystemData > CanvasData){
	// 		console.log('case 3' , SystemData - CanvasData);
	// 		for(var i=0;i<items.length;i++){
	// 			var file = items[i],
	// 				type = file.type;
	//
	// 			if (type.indexOf("image")!=-1) {
	// 				e.preventDefault();
	// 				isSystemPaste = true;
	//
	// 				var imageData = file.getAsFile();
	// 				var reader  = new FileReader();
	// 				reader.readAsDataURL(imageData);
	// 				reader.onloadend = function() {
	// 					var base64data = reader.result;
	// 					canvasImage(base64data);
	// 				}
	// 			}
	// 		}
	//
	// 	}else{
	//
	// 		console.log('case 4' , SystemData - CanvasData);
	// 		procPaste();
	// 	}
	//
	// }

});

var objControlsTxt = new Object({
	bl : true,
	br : true,
	mb : false,
	ml : true,
	mr : true,
	mt : false,
	tl : true,
	tr : true,
	mtr : true
});



var objControlsImg = new Object({
	bl : true,
	br : true,
	mb : true,
	ml : true,
	mr : true,
	mt : true,
	tl : true,
	tr : true,
	mtr : true
});

//-- 행간 자간관련
$(document).on('keyup','#objLHVal',function(){
	var val = $(this).val();

	if(val > 3) val = 3;
	else if(val < 0.2) val = 0.2;

	$(this).val(val);
	$('#objLH').val(val).trigger('change');
});
$(document).on('keyup','#objCSVal',function(){
	var val = $(this).val();

	if(val > 100) val = 100;
	else if(val < -100) val = -100;

	$(this).val(val);
	$('#objCS').val(val).trigger('change');
});

//-- 폰트사이즈 handling
$(document).on('click','.fontSizeUp',function(){
	var $objFSize = $('input[name="objFSize"]');
	var val = $objFSize.val();
	var setVal = parseInt(val)+1;
	$objFSize.val(setVal).trigger('change');
});
$(document).on('click','.fontSizeDown',function(){
	var $objFSize = $('input[name="objFSize"]');
	var val = $objFSize.val();
	var setVal = parseInt(val)-1;
	$objFSize.val(setVal).trigger('change');
});

$(document).on('click','.fontSizeList li',function(){
	var val = $(this).data('val');
	$('input[name="objFSize"]').val(val).trigger('change');
	$('.fontSizeList').removeClass('d-flex').addClass('d-none');
});

//캔버스 위치 변경
$(document).on('click', '.mvScroll', function () {
	var targetIdx , targetObject;
	var idx = parseInt($(this).data('idx'));

	//$($('.canvas-page[data-idx="3"]')[0]).insertBefore('.canvas-page[data-idx="0"]');
	if ($(this).data('act') === 'up') { //페이지 up
		targetIdx = idx - 1;


		if(typeof aCanvas[targetIdx] !== 'undefined' && aCanvas[targetIdx] !== ''){
			$($('.canvas-page[data-idx="'+idx+'"]')[0]).insertBefore('.canvas-page[data-idx="'+targetIdx+'"]');
		}else{
			console.log('첫 페이지입니다.');
		}

	} else {//페이지 다운
		targetIdx = idx + 1;
		if(typeof aCanvas[targetIdx] !== 'undefined' && aCanvas[targetIdx] !== ''){
			$($('.canvas-page[data-idx="'+idx+'"]')[0]).insertAfter('.canvas-page[data-idx="'+targetIdx+'"]');
		}else{
			console.log('마지막 페이지입니다.');
		}
	}

	var myObject = aCanvas[idx];
	targetObject = aCanvas[targetIdx];

	aCanvas[targetIdx] = myObject;
	aCanvas[idx] = targetObject;

	resetPageNo();

});
//캔버스 위치 이동
// $(document).on('click', '.mvScroll', function () {
// 	var idx;
//
// 	if ($(this).data('act') === 'up') { //페이지 up
// 		idx = parseInt($(this).data('idx')) - 1;
// 	} else {//페이지 다운
// 		idx = parseInt($(this).data('idx')) + 1;
// 	}
// 	mvScroll(idx);
// });

//페이지 삭제
$(document).on("click",".btnPageDel",function (e){
	e.stopImmediatePropagation();
	var ans = confirm('이 페이지를 삭제할까요?\n\n※페이지 삭제는 되돌릴 수 없습니다.');
	if (ans){
		var nDelCanvasNo = $(this).data('idx');

		$(".canvas-page[data-idx='"+nDelCanvasNo+"']").remove();

		aCanvas[nDelCanvasNo] = null;
		nCanvasNo--;

		if($('.canvas-wrap .canvas-page').length === 0) {

			addPage();
			nDelCanvasNo = 0;

		}else{ //남은 캔버스가 있는 경우 aCanvas정리

			var i = 0;
			var aNewCanvas = [];
			$.each(aCanvas , function(k , r){
				if( r != null) aNewCanvas.push(r);
			});
			nDelCanvasNo = aNewCanvas.length -1 ;
			aCanvas = aNewCanvas;

		}

		resetPageNo();
		setCanvas(nDelCanvasNo);

	}
});

//페이지 복사
$(document).on("click",".btnPageCopy",function (e){
	e.stopImmediatePropagation();
	var nIdx = parseInt($(this).data("idx"));
	if (aCanvas[nIdx] != null){
		addPage(aCanvas[nIdx].toDatalessJSON());
	}

});

function save_log(type , tid = 0 ,mid = 0, cid = 0){
	var data = {type: type , tid : tid , mid : mid , cid : cid};
	$.ajax({
		url: "/Common/saveLog/",
		data: data,
		method: "post",
		dataType: "json",
	});
}

// 배경적용
$(document).on("click",".objBGImg",function (e){
	e.stopImmediatePropagation();
	if($(this).data('paid_yn') === 'Y' && paid_user === 'N'){
		paid_modal();
		return false;
	}

	save_log('L',0,0,$(this).data('cid'));

	setBackgroundImg($(this).data("org_file"));
});

// 이미지 추가
$(document).on("click",".objItemImg",function (e){
	e.stopImmediatePropagation();

	if($(this).data('paid_yn') === 'Y' && paid_user === 'N'){
		paid_modal();
		return false;
	}

	//myupload img 제외
	if(!$(this).hasClass('objItemImgMy')) save_log('L',0,0,$(this).data('cid'));

	$('.dummy_img').attr('src',$(this).data('org_file'));
	var thisobj = $(this);

	setTimeout(function(){
		addImage('object',thisobj.get(0));
	},100)

});

// 템플릿 추가
$(document).on("click",".objItemTemplate",function (e){
	e.stopImmediatePropagation();

	if($(this).data('paid_yn') === 'Y' && paid_user === 'N'){
		paid_modal();
		return false;
	}

	save_log('L',$(this).data('idx'),0,0);

	var idx = $(this).data('idx');
	LoadPage('template' , idx , false);
});


$(document).on("click",".btnDelMyImg",function (e){
	e.stopImmediatePropagation();
	var ans = confirm('이 이미지를 삭제할까요?');
	if (ans){
		var objItem = $(this).parents(".listItemImgMy");
		$.post("/_proc/procHelper.htm",
			{
				nIdx : $(this).attr("nIdx"),
				commitType : "remove_ezcvs_img_my"
			},
			function (data){
				if (data["ret"] == 'succ'){
					objItem.fadeOut(200,function (){
						objItem.remove();
						if ($(".objItemImgMy").length > 0){
						}else{
							$(".wrapMyImg").hide();
						}
					});

				}else{
					alert(data["msg"]);
				}
			},
			'json'
		);

	}
});

//자간 관련
$(document).on("input","#objCS",function (e){
	e.stopImmediatePropagation();
	$("#objCSVal").val($(this).val());

	curObj[0].set("charSpacing",$(this).val());
	oCanvas.renderAll();
	onUpdate();

});

$(document).on("change","#objCS",function (e){
	e.stopImmediatePropagation();

	curObj[0].set("charSpacing",$(this).val());
	oCanvas.renderAll();
	onUpdate();
});

//행간 관련
$(document).on("input","#objLH",function (e){
	e.stopImmediatePropagation();
	$("#objLHVal").val($(this).val());

	curObj[0].set("lineHeight",$(this).val());
	oCanvas.renderAll();
	onUpdate();
});
$(document).on("change","#objLH",function (e){
	e.stopImmediatePropagation();

	curObj[0].set("lineHeight",$(this).val());
	oCanvas.renderAll();
	onUpdate();
});

// 배경색 지정
$(document).on('change', '.objBC',function(e){
	e.stopImmediatePropagation();
	setBackgroundColor($(this).val() , $('#bgAllAccept').prop('checked'));
})


$(document).on('click','.title-save',function(e){
	e.preventDefault();
	var $target = $(this).parent();
	var title = $target.find('input').val();

	if(title === ''){
		alert('페이지 제목을 입력해주세요!');
		return false;
	}

	$target.prev().html(title);

	$(this).parent().toggleClass('d-none').toggleClass('d-flex');
	$(this).parent().prev().toggleClass('d-none').toggleClass('d-flex');
	$(this).parent().parent().find('span:eq(0)').css('width','70px');
});

$(document).on('click','.canvas-title-str',function(e){
	e.preventDefault();

	$(this).toggleClass('d-none').toggleClass('d-flex');
	$(this).next().toggleClass('d-none').toggleClass('d-flex');
	$(this).parent().find('span:eq(0)').css('width','95px');

});

$(document).on('click',".objItemTxt",function (e){
	e.stopImmediatePropagation();
	addTxt();
});

$(document).on('change','.upImgFile', function (e){
	e.stopImmediatePropagation();
	var aFile = $(this).val().split('.');
	var fileExt = aFile[aFile.length-1];
	fileExt = fileExt.toUpperCase();
	if (fileExt === 'JPG' || fileExt === 'PNG' || fileExt === 'GIF' || fileExt === 'JPEG'){
		var nIdx = $(this).attr("nIdx");
		$("#frmImgUpload").submit();
	}else{
		alert('이미지 파일(JPG,PNG,GIF)만 등록가능합니다.');
	}
});

//### set Font Size
$(document).on('change',".objFSize",function (e){
	e.stopImmediatePropagation();
	var nFontSize = $(this).val();
	if (typeof curObj !== 'undefined' && curObj[0]){
		if (curObj[0].type == 'textbox'){
			curObj[0].set("fontSize",nFontSize);
			oCanvas.renderAll();
			onUpdate();
		}
	}
});
$(document).on('keyup',".objFSize",function (e){
	e.stopImmediatePropagation();
	var nFontSize = $(this).val();
	if (curObj[0]){
		if (curObj[0].type == 'textbox'){
			curObj[0].set("fontSize",nFontSize);
			oCanvas.renderAll();
			onUpdate();
		}
	}
});

//##### Event Handler ####
$(document).keydown(function (e){
	e.stopImmediatePropagation();
	var pxMove = 5;

	if(isFontLoaded === false) return false;

	curObj = oCanvas.getActiveObjects();

	if (curObj.length){
		switch (e.keyCode){
			case 8:		// backspace
			case 46:	// Delete

				//input focusing 되어 있다면 return;
				if($(':focus').is('input') == true) return true;
				if (curObj[0].isEditing) return true;
				if (curObj){
					//var ans = confirm('현재 선택된 오브젝트를 삭제할까요?');
					var ans = true;
					if (ans){
						curObj.forEach(function (object) {
							oCanvas.remove(object);
						});
						oCanvas.discardActiveObject();
						oCanvas.renderAll();
						onUpdate();
					}
				}
				break;
			case 37 :	// Left
				curObj.forEach(function (object) {
					//object.set('left',(object.get('left') < pxMove) ? 0 : object.get('left')-pxMove);
					object.set('left',object.get('left')-pxMove);
				});
				oCanvas.renderAll();
				//onUpdate();
				break;
			case 38 :	// Up
				curObj.forEach(function (object) {
					//object.set('top',(object.get('top') < pxMove) ? 0 : object.get('top')-pxMove);
					object.set('top',object.get('top')-pxMove);
				});
				oCanvas.renderAll();
				//onUpdate();
				break;
			case 39 :	// Right
				curObj.forEach(function (object) {
					object.set('left',object.get('left')+pxMove);
				});
				oCanvas.renderAll();
				//onUpdate();
				break;
			case 40 :	// Down
				curObj.forEach(function (object) {
					object.set('top',object.get('top')+pxMove);
				});
				oCanvas.renderAll();
				//onUpdate();
				break;
			case 67:	// Ctrl+C
				if (event.ctrlKey){
					procCopy(e);
				}
				if(!ret) break;

		}

	}

	switch (e.keyCode){
		case 90 : // Ctrl+Z
			if (event.ctrlKey){
				unDo();
			}
			break;
		case 89 : // Ctrl+Y
			if (event.ctrlKey){
				reDo();
			}
			break;

		case 86:	// Ctrl+V
			if (event.ctrlKey){
				procPaste(e);
			}
			break;
		case 71:	// Ctrl+G
			if (event.ctrlKey){
				if(curObj.length > 1) procSetGroup();
				else procSetUnGroup();
				return false;
			}
			break;
	}
});

$(document).on("contextmenu",".cvBase",function (e){
	e.stopImmediatePropagation();
	$(".objPopMenu").hide();

	curObj = oCanvas.findTarget(e.originalEvent);

	if (curObj){
		oCanvas.setActiveObject(curObj);
		oCanvas.renderAll();

		var curObj1 = oCanvas.getActiveObject();
		var curObj2 = oCanvas.getActiveObjects();

		$(".btnObject").show();

		if (curObj1.type == 'group'){
			$(".btnGroup").hide();
			$(".btnUnGroup").show();
		}else{
			if (curObj2.length > 1){
				$(".btnGroup").show();
				$(".btnUnGroup").hide();
			}else{
				$(".btnGroup").hide();
				$(".btnUnGroup").hide();
			}

		}

	}else{
		$(".btnObject").hide();
	}

	$(".objPopMenu").css({"left":e.clientX+10,"top":e.clientY+5}).show(100);

	return false;
});

$(document).on('click',function (e){
	e.stopImmediatePropagation();
	$(".objPopMenu").hide();
});

$(document).on('click',".objFTA",function (e){
	e.stopImmediatePropagation();

	// $(".objFTA").removeClass("editor_ticon_on");
	// $(this).addClass("editor_ticon_on");

	if (curObj[0]){
		if (curObj[0].type == 'textbox'){
			curObj[0].set("textAlign",$(this).data('val'));
			oCanvas.renderAll();
			onUpdate();
		}
	}
});



$(document).on('click',".objFS", function (e){
	e.stopImmediatePropagation();
	if (curObj[0]){
		if (curObj[0].type == 'textbox'){

			if ($(this).data("val") == 'bold'){
				if ($(this).hasClass("active")){
					curObj[0].set("fontWeight","normal");
					$(this).removeClass("editor_tstyle_onactive");
				}else{
					curObj[0].set("fontWeight","800");
					$(this).addClass("active");
				}
			}else if ($(this).data("val") == 'italic'){
				if ($(this).hasClass("active")){
					curObj[0].set("fontStyle","normal");
					$(this).removeClass("active");
				}else{
					curObj[0].set("fontStyle","italic");
					$(this).addClass("active");
				}
			}else if ($(this).data("val") == 'underline'){
				if ($(this).hasClass("active")){
					curObj[0].set("underline",false);
					$(this).removeClass("active");
				}else{
					curObj[0].set("underline",true);
					$(this).addClass("active");
				}
			}else if ($(this).data("val") == 'shadow'){

				if ($(this).hasClass("active")){
					curObj[0].set({shadow: ''});
					$(this).removeClass("active");
				}else{
					curObj[0].set({shadow: 'rgba(0,0,0, 0.3) 2px 2px 2px'});
					$(this).addClass("active");
				}
			}
			oCanvas.renderAll();
			onUpdate();
		}
	}
});


/* ----------------------- 텍스트 */
//글자색 변경
$(document).on('change',".objFC",function (e){
	e.stopImmediatePropagation();
	if (typeof curObj !== 'undefined') {
		if (curObj[0]) {
			if (curObj[0].type == 'textbox') {
				curObj[0].set("fill", $(this).val());
				oCanvas.renderAll();
				onUpdate();

				addRecentColor('text', $(this).val());
			}
		}
	}
});
//글자색 클릭
$(document).on('click',".objFC_p",function (e){
	e.stopImmediatePropagation();
	$(".objFC").val(rgb2hex($(this).css("background-color")));
	$(".objFC").trigger("change");
});
//배경색 변경
$(document).on('change',".objFBC",function (e){
	e.stopImmediatePropagation();
	if (typeof curObj !== 'undefined') {
		if (curObj[0]) {
			if (curObj[0].type == 'textbox') {
				curObj[0].set("textBackgroundColor", $(this).val());
				oCanvas.renderAll();
				onUpdate();

				addRecentColor('bg',$(this).val());
			}
		}
	}
});

//배경색 클릭
$(document).on('click', ".objFBC_p", function (e) {
	e.stopImmediatePropagation();
	var bg_color_code = rgb2hex($(this).css("background-color"));
	$(".objFBC").val(bg_color_code);
	$(".objFBC").trigger("change");
});
//배경없음
$(document).on('click',".objFBC_no",function (e){
	e.stopImmediatePropagation();
	if (typeof curObj !== 'undefined'){
		if (curObj[0].type === 'textbox'){
			curObj[0].set("textBackgroundColor",'');
			oCanvas.renderAll();
			onUpdate();
		}
	}
});
//폰트변경
$(document).on('change',".objFF", function (e){
	e.stopImmediatePropagation();
	if(typeof curObj !== 'undefined'){
		if (curObj[0]){
			if (curObj[0].type === 'textbox'){
				//FontloadAndUse(curObj[0],$(this).val());
				curObj[0].set("fontFamily",$(this).val());
				oCanvas.renderAll();
				onUpdate();
			}
		}
	}
});

$(document).on('click', '.image-prev' ,function(){

	var w_str;
	var isFirst = $(this).parent().find('.image-list-inner > a.active').index() == 0 ? true : false;
	var $active = $(this).parent().find('.image-list-inner > a.active');

	if(isFirst === true) return false;

	$active.removeClass('active').prev().addClass('active');
	w_str = '-' + $(this).parent().find('.image-list-inner > a.active').css('left');

	$(this).parent().find('.image-list').css('transform','translateX('+w_str+')');

});

$(document).on('click','.image-next',function(){

	var w_str;
	var isLast = $(this).parent().find('.image-list-inner > a.active').index()+1 == $(this).parent().find('.image-list-inner > a').length ? true : false;
	var $active = $(this).parent().find('.image-list-inner > a.active')

	if(isLast === true) return false;

	$active.removeClass('active').next().addClass('active');
	w_str = '-' + $(this).parent().find('.image-list-inner > a.active').css('left');

	if($(this).parent().find('.image-list-inner > a.active').index()+1 == $(this).parent().find('.image-list-inner > a').length){
		$(this).parent().find('.image-list-inner div.list-ignore').removeClass('d-none').addClass('d-flex');
	}

	$(this).parent().find('.image-list').css('transform','translateX('+w_str+')');

});

$(document).on('keyup' , 'input[name="search-text"]', function (e){
	e.preventDefault();
	if (e.keyCode === 13){
		setTextCancelIcon();
		getList();
	}

});

$(function(){

	var nFontLoadIdx = 0;
	var aFontFamily = ['Nanum Gothic', 'Nanum Myeongjo', 'IM_HyeminRegular', 'GangwonEduAllLight', 'MaplestoryLight', 'Yangjin', 'Jalnan', 'ONE_MobilePOP', 'INKLIPQUID', 'GmarketSansTTFMedium', 'CookieRunRegular', 'TMONBlack', 'Black And White Picture', 'Black Han Sans', 'Cute Font', 'Dokdo', 'East Sea Dokdo', 'Dongle', 'Gaegu', 'Gamja Flower', 'Gowun Dodum', 'Gugi', 'Hahmlet', 'Hi Melody', 'Kirang Haerang', 'Nanum Pen Script', 'Nanum Brush Script', 'Poor Story', 'Single Day', 'Stylish', 'Yeon Sung', 'Do Hyeon', 'Jua', 'Sunflower'];

	dialog = $( ".wrapProgress" ).dialog({
		autoOpen: true,
		minHeight:120,
		dialogClass : "alert",
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", $(this).parent()).hide();
		}
	});

	$( "#progressbar" ).progressbar({
		value: false,
		max:aFontFamily.length,
		change: function() {
			$( ".progress-label" ).text( "진행 : " + $( "#progressbar" ).progressbar( "value" ) + " / "+aFontFamily.length );
		},
		complete: function() {
			$( ".progress-label" ).text( "완료!" );
		}
	});
	// Init();
	WebFont.load({
		google: {
			families: aFontFamily
		},
		loading : function (){
		},
		inactive : function (){
		},
		fontloading : function (){
		},
		fontactive : function (){
			nFontLoadIdx++;
			$( "#progressbar" ).progressbar( "value", nFontLoadIdx);
		},
		fontinactive : function (e){
		},
		active  : function (){
			isFontLoaded = true;
			$("#objLoading").fadeOut('fast',function () {
				dialog.dialog('close');
				Init();

				if(check_mobile()){
					mobile_modal();
				}

			});
		}
	});

	//init
	setContentsWrap('_template');

	//icon메뉴 <<< 버튼 액션 > 컨텐츠 메뉴 열고 닫기
	$('.hide-contents').on('click',function(){

		if( $('.contents-menu-wrap').hasClass('wrap-disable') ) {
			$('.contents-menu-wrap').removeClass('wrap-disable');
		}else{
			$('.contents-menu-wrap').addClass('wrap-disable');
		}
	});
	//아이콘 클릭 액션
	$('.icon-menu-wrap > ul > li > div').on('click',function(){

		$('.icon-menu-wrap > ul > li > div').removeClass('active');
		if($(this).hasClass('hide-contents-wrap') == false){
			$(this).addClass('active');
			setContentsWrap($(this).data('val'));
		}
	});

	$('#frmSave').ajaxForm({
		type: 'post',
		dataType: 'json',
		cache: false,
		success : function(result, status) {

			$('.btnSave').html('저장됨').addClass('disabled');
			save_ing = false;
			$('input[name="_csrf"]').val(result.csrf);
			if($('#bg_save').val() === 'N'){
				if(result.msg) alert(result.msg);
				if(result.success){
					opener.location.href = '/My';
					window.close();
				}
			}else{

				if(parseInt(result.id) > 0){
					$('#frmSave input[name="my_canvas_id"]').val(result.id)
					$('#frmSave input[name="save_type"]').val('my')
				}

				$('#last_modified').val(result.datetime);
			}
		}
	});

	$('.close-object-wrap').on('click',function(){
		$('.contents-menu-wrap').addClass('d-flex').removeClass('d-none');
		$('.object-wrap').removeClass('d-flex').addClass('d-none');
	});

	//하단 사이즈조절
	$('.emRotate').on('click',function(){
		$('.emRotate').removeClass('active');
		var val = $(this).data('val');

		if(val == 'S') {
			nCanvasWidth = 2200;
			nCanvasHeight = 2200;
		}else if(val == 'P'){
			nCanvasWidth = 1556;
			nCanvasHeight = 2200;
		}else{
			nCanvasWidth = 2200;
			nCanvasHeight = 1556;
		}
		procZoom(nCurZoom);
		$(this).addClass('active');
		chkScroll();
	});

	//스크롤시 처리
	$('.canvas-scroll').scroll(chkScroll);

	$(".isDraw").on('click',function (e){
		e.stopImmediatePropagation();
		if ($(this).prop("checked")){
			oCanvas.isDrawingMode = true;
			oCanvas.freeDrawingBrush.width = 20;
			oCanvas.freeDrawingBrush.color = $(".objFC").val();
		}else{
			oCanvas.isDrawingMode = false;
		}
	});

	$(".header_logo").dblclick(function (e){
		e.stopImmediatePropagation();
		oCanvas.renderAll();
	});

	$(".btnDownload").on('click',function (e){
		e.stopImmediatePropagation();

		if(act !== 'down'){ // 자동 다운로드가 아닌 경우 loader
			//set loader
			loader('다운로드 준비 중 입니다.');
			console.log('in btnDownload Called loader');
		}

		oCanvas.discardActiveObject();
		oCanvas.renderAll();

		var curZoom = nCurZoom;
		procZoom(1 , true);

		var aJson = [];

		$(".canvas-page").each(function (){
			var nIdx = $(this).data("idx");
			if (parseInt(nIdx) >= 0 && aCanvas[nIdx] != null){
				var json_data = aCanvas[nIdx].toDataURL();
				aJson.push(json_data);
			}
		});

		procZoom(curZoom);
		//var vcSaveTitle = ($(".vcTitle").val() == '') ? $(".vcTitleTemplate").val():$(".vcTitle").val();
		$("#aImgData").val(JSON.stringify(aJson));
		$("#frmDown").submit();

		setTimeout(loader , 500);

	});

	$(".btnSlide").on('click',function (e){
		e.stopImmediatePropagation();
		oCanvas.discardActiveObject();
		oCanvas.renderAll();

		var curZoom = nCurZoom;
		procZoom(1,true);

		var aJson = new Array();
		var idx=0;
		$(".canvas-page").each(function (){
			var nIdx = $(this).data("idx");
			if (parseInt(nIdx) >= 0 && aCanvas[nIdx] != null){
				var json_data = aCanvas[nIdx].toDataURL();
				aJson.push(json_data);
			}
		});

		procZoom(curZoom);
		$("#aSlideData").val(JSON.stringify(aJson));

		var w = $(window).width();
		var h = $(window).height();
		var winSlide = window.open('','winSlide','width='+w+',height='+h+',left=0,top=0,resizable=no,fullscreen=yes');

		$("#frmSlide").attr("target","winSlide");
		$("#frmSlide").attr("action","/Canvas/Slide");
		$("#frmSlide").submit();

	});


	$(".btnSave").on('click',function (e){
		e.stopImmediatePropagation();
		oCanvas.discardActiveObject();
		oCanvas.renderAll();
		save_process();

	});

	// 요소, 배경
	//사용안함
	$(".btnObjBG").on('click',function (e){
		e.stopImmediatePropagation();
		var curRight = $(this).attr("val");
		$(".btnObjBG").removeClass("editor_tooltab_btnon").addClass("editor_tooltab_btnoff");
		$(this).removeClass("editor_tooltab_btnoff").addClass("editor_tooltab_btnon");
		$(".right_top").hide();
		$(".right_top_"+curRight).show();

		$(".right_obj").hide();
		$(".right_bg").hide();
		$(".right_"+curRight).show();

		$("#frmSearch").attr("val",curRight);
		$(".btnSearchClose").trigger("click");

		oCanvas.discardActiveObject();
		oCanvas.renderAll();
		onUpdate();

	});

	$(".btnSearchClose").on('click',function (e){
		e.stopImmediatePropagation();
		$(this).hide();
		$("#txtKeyword").val('');
		var vcSearchKind = $("#frmSearch").attr("val");
		$(".right_"+vcSearchKind+"_search_result").html('');
		$(".right_"+vcSearchKind+"_search").hide();
		$(".right_"+vcSearchKind+"_def").show();

	});

	$(".btnMoreItem").on('click',function (e){
		e.stopImmediatePropagation();
		var wrapObj = $(this).parents(".editor_imglisttlt").siblings(".wrapItemList");
		if (wrapObj.css("display") == 'block'){
			wrapObj.css({"height":"117px","display":"flex"});
			$(this).html("더보기");
		}else{
			wrapObj.css({"height":"auto","display":"block"});
			$(this).html("접기");
		}

	});

	$(".btnPageAdd").on('click',function (e){
		e.stopImmediatePropagation();
		addPage();
	});

	$(".btnUnDo").on('click',function (e){
		e.stopImmediatePropagation();
		unDo();
	});

	$(".btnReDo").on('click',function (e){
		e.stopImmediatePropagation();
		reDo();
	});

	$(".btnZoomOut").on('click',function (e){
		e.stopImmediatePropagation();
		//var curZoom = oCanvas.getZoom();
		var curZoom = parseFloat(nCurZoom);
		if (curZoom <= 0.3){
			return false;
		}
		curZoom = Math.round((curZoom - 0.1)*1e12) / 1e12;
		procZoom(curZoom);

	});


	$(".btnZoomIn").on('click',function (e){
		e.stopImmediatePropagation();
		//var curZoom = oCanvas.getZoom();
		var curZoom = parseFloat(nCurZoom);
		if (curZoom >= 1.3){
			return false;
		}

		curZoom = Math.round((curZoom + 0.1)*1e12) / 1e12;
		procZoom(curZoom);
	});

	$(".objDelete").on('click',function (e){
		e.stopImmediatePropagation();
		procDelete();
	});

	$(".btnCT").on('mouseover',function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"#003399","color":"#fff"});
	});

	$(".btnCT").on('mouseout',function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"#fff","color":"#000"});
	});

	$(".btnCT").on('click',function (e){
		e.stopImmediatePropagation();
		var sCmd = $(this).attr("cmd");
		if (sCmd == 'delete'){
			procDelete();
		}else if (sCmd == 'forward'){
			procForward();
		}else if (sCmd == 'forwardFirst'){
			procForwardFirst();
		}else if (sCmd == 'backward'){
			procBackward();
		}else if (sCmd == 'backwardLast'){
			procBackwardLast();
		}else if (sCmd == 'flipX'){
			procFlipX();
		}else if (sCmd == 'flipY'){
			procFlipY();
		}else if (sCmd == 'rotate90'){
			procRotate(90);
		}else if (sCmd == 'rotate180'){
			procRotate(180);
		}else if (sCmd == 'group'){
			procSetGroup();
		}else if (sCmd == 'ungroup'){
			procSetUnGroup();
		}else if (sCmd == 'copy'){
			procCopy();
		}else if (sCmd == 'paste'){
			procPaste();
		}

	});

	$(".btnAlign").on('click',function (e){
		e.stopImmediatePropagation();
		var sCmd = $(this).data("val");
		if (sCmd == 'left'){
			procAlignLeft();
		}else if (sCmd == 'center'){
			procAlignCenter();
		}else if (sCmd == 'right'){
			procAlignRight();
		}else if (sCmd == 'forward'){
			procForward();
		}else if (sCmd == 'backward'){
			procBackward();
		}else if (sCmd == 'flipX'){
			procFlipX();
		}else if (sCmd == 'flipY'){
			procFlipY();
		}else if (sCmd == 'rotate90'){
			procRotate(90);
		}else if (sCmd == 'rotate180'){
			procRotate(180);
		}
	});

	//자동 다운로드
 	if(act === 'down'){
		downloadInterval = setInterval(function(){
			 if(completeRemakePage === true){
				 clearInterval(downloadInterval);
				 loader('다운로드 준비 중 입니다.');
				 setTimeout(function(){
					 $(".btnDownload").click();
				 }, 500)
			 }
		 },500)
	}

	$('input[name="top_title"]').on('blur',function(){

		var val = $(this).val();
		if(val !== ''){
			oCanvas.discardActiveObject();
			oCanvas.renderAll();
			save_process('bg-save')
		}

	});

});
//end of readyFunction

function save_process(save_type = ''){

	if(save_ing === true){
		return false;
	}
	save_ing = true;

	if(save_type === 'bg-save') $('#bg_save').val('Y');
	else $('#bg_save').val('N');

	//수정정보 확인
	if($('#save_type').val() === 'my'){ //수정 시에만
		var modified_success = true;
		$.ajax({
			url: "/Canvas/CheckModified/",
			data: { _csrf : $('input[name="_csrf"]').val() , my_canvas_id : $('#my_canvas_id').val() , last_modified : $('#last_modified').val() },
			method: "post",
			dataType: "json",
			async: false,
			success: function (result) {
				modified_success = result.success;
				if(modified_success === false){
					showModifiedError(result.data); //popup
				}
			}
		});

		if(modified_success === false){//파일을 열었을때와 수정시간이 다른경우 return & caution
			save_ing = false;
			return false;
		}
	}

	if($('input[name="top_title"]').val() === ''){
		alert('제목을 입력하세요.');
		$('input[name="top_title"]').focus();
		save_ing = false;
		return false;
	}

	if(save_type == ''){
		if(!confirm('저장하시겠습니까?')) {
			save_ing = false;
			return false;
		}
	}

	//set loader
	if(save_type == '') loader('저장 중 입니다.');

	bSave = false;

	$('input[name="title"]').val($('input[name="top_title"]').val());

	var curZoom = nCurZoom;
	procZoom(1 , true);

	var aJson = [];
	var aImgData = [];
	var aImgTitle = [];
	var idx=0;
	var nPage = 0;
	var objThumbCanvas;
	var isEmpty = true;
	$(".canvas-page").each(function (k,r){
		var nIdx = $(this).data("idx");
		if (parseInt(nIdx) >= 0 && aCanvas[nIdx] != null){
			var temp_json = aCanvas[nIdx].toDatalessJSON();
			if(temp_json.objects.length > 0) isEmpty = false;
			var json_data = JSON.stringify(temp_json);

			aJson.push(json_data);
			aImgData.push(aCanvas[nIdx].toDataURL());
			nPage++;
		}
	});

	if(isEmpty === true && save_type === 'bg-save'){//백그라운드 저장인경우 내용이 없으면 저장안함
		procZoom(curZoom);
		save_ing = false;
		return false;
	}

	$("#thumb_file").val(JSON.stringify(aImgData));
	$("#blob_data").val(JSON.stringify(aJson));
	$("#page").val(nPage);
	$("#rotate").val($('.emRotate.active').data('val'));

	procZoom(curZoom);

	$("#frmSave").submit();

}

function resetAll(){

	aCanvas = new Array(100);
	nCanvasNo = -1;
	nCurPageNo = 0;
	nHistory = -1;
	aHistory = new Array();
	nPage = 0;

	// $(".cvBase").remove();
	$(".canvas-wrap").html('');

}



function applyDrag(){
	$(".objItemImg").draggable({
		revert : true
		, appendTo: 'body'
		, containment: 'window'
		, revertDuration : 0
		, helper : "clone"
		, zIndex: 99999
		, start:function (event, ui){

			if($(this).data('paid_yn') === 'Y' && paid_user === 'N'){
				paid_modal();
				return false;
			}


			$('.dummy_img').attr('src',$(this).data('org_file'));
		}
	});

}

function rgb2hex(rgb){
	if (rgb.search("rgb") == -1) {
		return rgb;
	} else {
		rgb = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);
		function hex(x) {
			return ("0" + parseInt(x).toString(16)).slice(-2);
		}
		return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
	}
}

function onSelected(opt){
	chkObject();
}

function onUpdate(){
	bSave = true;
	$('.btnSave').html('저장하기').removeClass('disabled');
	addHistory();
	chkObject();
}
function Init(){
	applyDrag();
	InitCanvas(0);
	setCanvas(0);

	var nLoadIdx = '' ;
	if($("#loadType").val() === 'my') nLoadIdx = $("#nDataIdx").val(); //my_canvas_id
	else  nLoadIdx = $("#nLoadIdx").val(); //template_id

	LoadPage($("#loadType").val(), nLoadIdx , true);
}


function setCanvas(nIdx){

	oCanvas = aCanvas[nIdx];
	nCurPageNo = nIdx;

	for (var idx=0;idx<aCanvas.length ;idx++ ){
		if (aCanvas[idx] != null){
			aCanvas[idx].discardActiveObject();
			aCanvas[idx].renderAll();
		}
	}
}

function InitCanvas(nIdx,defData){

	var objCanvas = new fabric.Canvas('cvBase'+nIdx,{
		preserveObjectStacking: true
	});

	objCanvas.setWidth($(".wrapCanvas").width());
	objCanvas.setHeight($(".wrapCanvas").height());

	fabric.util.object.extend(fabric.Textbox.prototype, {
		_initDimensions: function(ctx) {
			if (this.__skipDimension) {
				return;
			}

			if (!ctx) {
				ctx = fabric.util.createCanvasElement().getContext('2d');
				this._setTextStyles(ctx);
			}

			this.dynamicMinWidth = 0;

			this._textLines = this._splitTextIntoLines();

			if (this.dynamicMinWidth != this.width) {
				this._set('width', this.dynamicMinWidth);
			}


			this._clearCache();
			this.height = this._getTextHeight(ctx);
		},
	});

	//선택된 객체의 회전 아이콘 처리
	var img_rotate = document.createElement('img');
	img_rotate.src = "/images/easycanvas/easycv_icon_rotate.png";

	fabric.Object.prototype.controls.mtr = new fabric.Control({
		x: 0,
		y: -0.5,
		offsetY: -40,
		cursorStyle: 'crosshair',
		actionHandler: fabric.controlsUtils.rotationWithSnapping,
		actionName: 'rotate',
		render: renderRotateIcon,
		cornerSize: 34,
		withConnection: false
	});

	fabric.Textbox.prototype.controls.mtr = new fabric.Control({
		x: 0,
		y: -0.5,
		offsetY: -20,
		cursorStyle: 'crosshair',
		actionHandler: fabric.controlsUtils.rotationWithSnapping,
		actionName: 'rotate',
		render: renderRotateIcon,
		cornerSize: 34,
		withConnection: false
	});

	// here's where the render action for the control is defined
	function renderRotateIcon(ctx, left, top, styleOverride, fabricObject) {
		var size = this.cornerSize;
		ctx.save();
		ctx.translate(left, top);
		ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
		ctx.drawImage(img_rotate, -size / 2, -size / 2, size, size);
		ctx.restore();
	}

	//선택된 객체의 삭제처리
	var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";

	var img_delete = document.createElement('img');
	img_delete.src = deleteIcon;

	fabric.Textbox.prototype.controls.deleteControl = new fabric.Control({
		x: 0.5,
		y: -0.5,
		offsetY: -20,
		cursorStyle: 'pointer',
		mouseUpHandler: deleteObject,
		render: renderDeleteIcon,
		cornerSize: 24
	});

	fabric.Object.prototype.controls.deleteControl = new fabric.Control({
		x: 0.5,
		y: -0.5,
		offsetY: -20,
		cursorStyle: 'pointer',
		mouseUpHandler: deleteObject,
		render: renderDeleteIcon,
		cornerSize: 24
	});

	// here's where the render action for the control is defined
	function deleteObject(eventData, transform) {
		var target = transform.target;
		var canvas = target.canvas;
		canvas.remove(target);
		canvas.requestRenderAll();
	}

	function renderDeleteIcon(ctx, left, top, styleOverride, fabricObject) {
		var size = this.cornerSize;
		ctx.save();
		ctx.translate(left, top);
		ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
		ctx.drawImage(img_delete, -size/2, -size/2, size, size);
		ctx.restore();
	}


	fabric.Object.prototype.borderColor = 'black';
	fabric.Object.prototype.cornerColor = 'black';
	fabric.Object.prototype.transparentCorners = false;
	fabric.Object.prototype.cornerSize = 15;
	fabric.Object.prototype.cornerStyle = "circle";
	fabric.Object.prototype.fireRightClick = true;
	fabric.Object.prototype.stopContextMenu = true;


	objCanvas.on({
		'object:selected': function(opt) {
			onSelected(opt);
		},
		'object:modified': function(opt) {
			isRemoveHistory = true;
			//onUpdate(opt);
		},
		'object:moving': function(opt) {
			chkObject();
		},
		'object:scaling': function(opt) {
			chkObject();
		},
		'selection:updated': function(opt) {
			onSelected(opt);
		},
		'selection:cleared': function(e) {
			chkObject();
		},
		'object:rotated': function(e) {
			onUpdate();
		},
		'object:scaled': function(e) {
			setStrokeWidth();//객체가 스케일링될 때 외곽선도 같이 스케일링처리 하도록
			onUpdate();
		},
		'object:moved': function(e) {
			onUpdate();
		},
		'selection:created': function(opt) {
			onSelected(opt);
		}
	});

	if (defData != ''){
		objCanvas.loadFromJSON(defData, function (){

			objCanvas.renderAll.bind(objCanvas);

			if (nIdx==0){
				addHistory();
			}
			procZoom(nCurZoom)

		},function (o,object){
			fabric.util.clearFabricFontCache();
			oCanvas.renderAll();
			oCanvas.requestRenderAll();
		});
	}

	aCanvas[nIdx] = objCanvas;

	droppable(nIdx);

	if(isFirst === true){
		if( nCurZoom == null ) procZoom(init_zoom);
		else procZoom(nCurZoom);

		isFirst = false;
	}

}

function droppable(nIdx){

	$("#cvBase"+nIdx).droppable({
		drop : function (event, ui){
			var obj = ui.draggable;
			if (obj.hasClass("objItemImg")){

				var size_x = ( ($('.canvas-container').width() - $(".canvas-wrap").width()) / 2 ) + $('.left-menu').width();
				var size_y = $('header').height() + parseInt($('.canvas-page').css('marginTop')) + $('.contents-wrap-header').height();
				var x = ui.offset.left - size_x ;
				var y = ui.offset.top - size_y ;

				addImage('object',obj.get(0), x, y);

			}
		}
	});
}
function LoadPage(sType , nLoadIdx , isFirst){

	if(nLoadIdx === '') return false;

	$.ajax({
		url : '/Canvas/getCvsData',
		type : 'post',
		data : {
			loadType : sType
			,	nLoadIdx : nLoadIdx
			,   _csrf : $('input[name="_csrf"]').val()
		},
		dataType : 'json',
		success : function(data){

			$('input[name="_csrf"]').val(data.csrf)
			if(data.emRotate) $('.emRotate[data-val="'+data.emRotate+'"]').click();

			if( data.reject === 'Y' ){
				paid_modal();
			}else{

				if (data.success === true && data.blob !== ''){
					if(isFirst){

						if(sType === 'my') save_log('V',0,nLoadIdx);
						else if(sType === 'template') save_log('V',nLoadIdx);

						reMakePage(data.blob);
					}else{

						setupPage(data.blob);

					}
				}

			}
		}

	});

}

function setupPage(blobdata){

	var aJSON = blobdata.split("||");
	var nCanvasObjectSeq = -1;
	var limit_cnt = aCanvas.length;

	for (var i = 0 ; i < limit_cnt ; i++ ){
		if (typeof aCanvas[i] !== 'undefined'){
			if(aCanvas[i].toDatalessJSON().objects.length > 0){ //컨텐츠가 있으면 page seq 기록
				nCanvasObjectSeq = i;
			}
		}
	}

	//기록된 페이지 뒤는 모두 제거
	for(var j = nCanvasObjectSeq+1 ; j < limit_cnt ; j++){

		var nDelCanvasNo = j;
		var $page_wrap = $(".canvas-page[data-idx='"+nDelCanvasNo+"']");

		if($page_wrap.length > 0){

			$page_wrap.remove();

			aCanvas[nDelCanvasNo] = null;
			nCanvasNo--;

			if($('.canvas-wrap .canvas-page').length > 0) {

				var aNewCanvas = [];
				$.each(aCanvas , function(k , r){
					if( r != null) aNewCanvas.push(r);
				});
				nDelCanvasNo = aNewCanvas.length -1 ;
				aCanvas = aNewCanvas;

			}

		}

	}

	resetPageNo();

	for (var idx=0;idx<aJSON.length;idx++ ){
		var json = JSON.parse(aJSON[idx]);
		addPage(json);


		aCanvas[idx].renderAll();



	}



}

function reMakePage(sData){
	resetAll();
	if (sData == '' || sData == null){
		addPage();
		return;
	}

	var aJSON = sData.split("||");
	for (var idx=0;idx<aJSON.length;idx++ ){
		aOriginal[idx] = aJSON[idx];
		var json = JSON.parse(aJSON[idx]);
		addPage(json);
		aCanvas[idx].renderAll();
	}
	completeRemakePage = true;
}

function addHistory(){

	if(oCanvas.toDatalessJSON().objects.length > 0){//데이터가 있는 경우만 history 저장
		nHistory++;

		var overlap = false;
		$.each(aHistory, function(k , r){
			if( r["nCanvasNo"] === nCurPageNo ) overlap = true;
		});

		if(!overlap){//해당 페이지가 첫 저장인 경우
			aHistory[nHistory] = {};
			aHistory[nHistory]["nCanvasNo"] = parseInt(nCurPageNo);
			aHistory[nHistory]["sCanvasData"] = typeof aOriginal[nCurPageNo] === 'undefined' ? JSON.stringify({'objects' : [] , 'version' : fabric.version}) : aOriginal[nCurPageNo];
			nHistory++;
		}
		var json_data = JSON.stringify(oCanvas.toDatalessJSON());
		aHistory[nHistory] = {};
		aHistory[nHistory]["nCanvasNo"] = parseInt(nCurPageNo);
		aHistory[nHistory]["sCanvasData"] = json_data;
	}
}

function unDo(){

	if (aHistory.length > 0){

		nHistory--;
		if(nHistory < 0) nHistory = 0;

		var nPageNo = aHistory[nHistory]["nCanvasNo"];

		if(typeof aCanvas[nPageNo] === 'undefined') return;

		mvScroll(nPageNo);
		aCanvas[nPageNo].loadFromJSON(JSON.parse(aHistory[nHistory]["sCanvasData"]), function(obj) {
			aCanvas[nPageNo].renderAll();
		});

	}
}


function reDo(){

	if (nHistory < aHistory.length-1){
		nHistory++;
		var nPageNo = aHistory[nHistory]["nCanvasNo"];
		if (aCanvas[nPageNo] == null) return;
		mvScroll(nPageNo);
		aCanvas[nPageNo].loadFromJSON(JSON.parse(aHistory[nHistory]["sCanvasData"]), function(obj) {
			aCanvas[nPageNo].renderAll();
		});

	}
}

function procZoom(nZoom , onSave = false){

	nCurZoom = parseFloat(nZoom);
	var nRealZoom = nCurZoom/2;

	if(onSave === true) nRealZoom = nCurZoom;

	$('.canvas-add-page').parent().css('width' , (nCanvasWidth*nRealZoom)+'px');

	$("input.btnZoomScale").val(nCurZoom*100);
	$(".wrapCanvas").width(nCanvasWidth*nRealZoom);
	$(".wrapCanvas").height(nCanvasHeight*nRealZoom);
	try{
		for (var idx=0;idx<aCanvas.length ;idx++ ){
			aCanvas[idx].setZoom(nRealZoom);
			aCanvas[idx].setWidth($(".wrapCanvas").width());
			aCanvas[idx].setHeight($(".wrapCanvas").height());
		}
	}catch(e){

	}
}


function addImageMy(sUrl,nIdx) {

	$('.icon-menu li div[data-val="_upload"]').click();
	// var html  = '<a>';
	// 	html += '	<img src="'+ImageUrlPrefix+sUrl+'" class="objItemImg objItemImgMy ui-draggable ui-draggable-handle canvas-img" data-w="" data-h="" />';
	// 	html += '</a>';
	//
	// $(".upload-file-wrap .upload-file-list").append(html);
	//
	// 이미지 상하정렬
	// $('.justified-gallery').justifiedGallery({
	// 	rowHeight : 88,
	// 	lastRow : 'nojustify',
	// 	border : 0,
	// 	margins : 15
	// });
	//
	// applyDrag();

}


function addImage(objType, obj, x, y) {

	var objImg = new Image();
	objImg.src = $(obj).data('org_file');//$(obj).attr('src');

	x = (typeof x == 'undefined' || x == null) ? oCanvas.width / 2 - parseInt($(obj).data('w')) / 2 : x;
	y = (typeof y == 'undefined' || y == null) ? oCanvas.height / 2 - parseInt($(obj).data('h')) / 2 : y;

	x = x < 1 ? 10 : x;
	y = y < 1 ? 10 : y;

	var w = Math.round(( parseInt($(obj).data('w')) * nCurZoom)*1e12) / 1e12;
	w = w > oCanvas.width ? oCanvas.width/2 : w;
	var h = Math.round(( parseInt($(obj).data('h')) * nCurZoom)*1e12) / 1e12;
	h = h > oCanvas.height ? oCanvas.height/2 : h;

	if ($(obj).attr("t") == 'svg'){

		fabric.loadSVGFromURL($(obj).attr("src"), function(objects, options) {
			var objImgIns = fabric.util.groupSVGElements(objects, options);
			objImgIns.left = x;
			objImgIns.top = y;
			objImgIns.scaleToWidth(100);
			objImgIns.scaleToHeight(100);
			oCanvas.add(objImgIns);
			oCanvas.setActiveObject(objImgIns);
			oCanvas.renderAll();
		});

	}else{

		var objImgIns = new fabric.Image(objImg,{
			left: x,
			top: y,
			angle: 0,
			opacity: 1,
			rotatingPointOffset: 10
		});

		objImgIns.scaleToWidth(w);
		objImgIns.scaleToHeight(h);

		objImgIns.setControlsVisibility(objControlsImg);

		//스켈링이 제대로 되지 않는 경우 강제로 현재 zoom값으로 처리
		if(objImgIns.scaleX < 0.1 || isNaN(objImgIns.scaleX)){
			objImgIns.scaleX = nCurZoom;
			objImgIns.scaleY = nCurZoom;
		}

		objImg.onload = function(){
			oCanvas.add(objImgIns).setActiveObject(objImgIns);
		}

	}

	oCanvas.renderAll();
	onUpdate();

}

function addTxt(x,y){
	var pos = $("#cvBase"+nCanvasNo).offset();
	var x = (x=='undefined' || x==null) ? oCanvas.width/2-100:x;
	var y = (y=='undefined' || y==null ) ? oCanvas.height/2-100:y+50;
	//x = x-$(".wrapIcon").width();

	var fontFamily = $('.objFF').val();

	var objTxtIns = new fabric.Textbox('내용을 입력하세요', {
		left: x,
		top: y,
		width: 300,
		textAlign: "center",
		editingBorderColor:"#777",
		fontFamily : fontFamily, //"Nanum Gothic",
		fontSize: 60,
		padding:7,
		// shadow: shadow
		// stroke:'#FF0000',
		//strokeWidth: 0
	});
	objTxtIns.setControlsVisibility(objControlsTxt);
	oCanvas.add(objTxtIns).setActiveObject(objTxtIns);
	onUpdate();

}

function addPage(defData) {

	if ($(".canvas-page").length > 18) {
		alert('페이지는 19개까지 추가가능합니다.');
		return;
	}
	nCanvasNo++;

	if (nCanvasNo > 99) {
		alert('더 이상 페이지를 추가할 수 없습니다.');
		return;
	}
	$('.canvas-page .canvas-add-page').remove();

	var wrapCanvasHtml = '';
	wrapCanvasHtml += '<div class="canvas-page d-flex flex-column mt-3 position-relative" data-idx="' + nCanvasNo + '">';
	wrapCanvasHtml += '		<div class="d-flex flex-row align-items-center justify-content-between mb-2 contents-wrap-header">';
	wrapCanvasHtml += '			<div class="d-flex align-items-center justify-content-center" style="padding-bottom: 1px;">';
	wrapCanvasHtml += '				<span style="width: 70px;">'+ (parseInt(nCanvasNo) + 1)+ '</span>';
	wrapCanvasHtml += '			</div>';
	wrapCanvasHtml += '			<div class="icon-group d-flex flex-row">';
	//wrapCanvasHtml += '				<button class="btn btn-xs"><i class="fa-solid fa-plus"></i></button>';
	wrapCanvasHtml += '				<button class="btn btn-xs btnPageCopy" data-idx="' + nCanvasNo + '"><i class="fa-regular fa-copy"></i></button>';
	// wrapCanvasHtml += '				<button class="btn btn-xs" onclick="mvScroll('+(nCanvasNo-1)+')"><i class="fa-solid fa-arrow-up"></i></button>';
	// wrapCanvasHtml += '				<button class="btn btn-xs" onclick="mvScroll('+(nCanvasNo+1)+')"><i class="fa-solid fa-arrow-down"></i></button>';
	wrapCanvasHtml += '				<button class="btn btn-xs mvScroll" data-act="up" data-idx="' + nCanvasNo + '"><i class="fa-solid fa-arrow-up"></i></button>';
	wrapCanvasHtml += '				<button class="btn btn-xs mvScroll" data-act="down" data-idx="' + nCanvasNo + '"><i class="fa-solid fa-arrow-down"></i></button>';
	wrapCanvasHtml += '				<button class="btn btn-xs btnPageDel" data-idx="' + nCanvasNo + '"> <i class="fa-solid fa-trash"></i> </button>';
	wrapCanvasHtml += '			</div>';
	wrapCanvasHtml += '		</div>';
	wrapCanvasHtml += '		<div class="wrapCanvas mb-2" style="background-color: #fff;">';
	wrapCanvasHtml += '			<canvas id="cvBase' + nCanvasNo + '" class="cvBase" title="' + nCanvasNo + '"></canvas>';
	wrapCanvasHtml += '		</div>';
	wrapCanvasHtml += '</div>';

	$(".canvas-wrap").append(wrapCanvasHtml);

	InitCanvas(nCanvasNo, defData);
	setCanvas(nCanvasNo);
	procZoom(nCurZoom);
	mvScroll(nCanvasNo);
	resetPageNo();

}

function mvScroll(idx) {
	if ($('.canvas-page[data-idx="'+idx+'"]').length > 0 ){
		var target_t = parseInt($('.canvas-page[data-idx="'+idx+'"]').offset().top , 10);
		var curr_t = parseInt($('.canvas-scroll').scrollTop(), 10);
		var correction_val = 82;
		target_t -= correction_val;

		$('.canvas-scroll').stop().animate({scrollTop:curr_t + target_t} , 100, 'swing');
	}

}
function resetPageNo() {

	$(".canvas-wrap .canvas-page").each(function (k , r) {
		var idx = k;
		var page_num = k+1;
		var prev_id = $(this).data('idx');

		$(this).attr('data-idx' , idx).data('idx' , idx);

		var wrapCanvasHtml  = '';
			wrapCanvasHtml += '<span style="width: 70px;">'+page_num + '&nbsp;페이지</span>';

		$(this).find('div:eq(0) > div:eq(0)').html(wrapCanvasHtml);
		$(this).find('div:eq(0) > div:eq(1) > button[data-idx]').attr('data-idx' , idx).data('idx' , idx);
		$(this).find('#cvBase'+prev_id).attr('id' , 'cvBase'+idx).attr('title' , idx);

	});

}

function procCopy(event) {

	var text = '' , ret = false;
	if(window.getSelection) text = window.getSelection().toString();

	if(text){
		ret = true;
	}else{
		oCanvas.getActiveObject().clone(function (cloned) {
			cloned.lastModified = Date.now();
			_clipboard = cloned;
		});
		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}

	return ret;
}


function procPaste(event) {
	try {
		_clipboard.clone(function (clonedObj) {
			oCanvas.discardActiveObject();
			clonedObj.set({
				left: clonedObj.left + 50,
				top: clonedObj.top + 50,
				evented: true
			});

			if (clonedObj.type === 'activeSelection') {

				clonedObj.canvas = oCanvas;
				clonedObj.forEachObject(function (obj) {
					oCanvas.add(obj);
				});
				clonedObj.setCoords();
			} else {
				oCanvas.add(clonedObj);
			}

			_clipboard.top += 50;
			_clipboard.left += 50;
			oCanvas.setActiveObject(clonedObj);
			oCanvas.requestRenderAll();

		});
	} catch (e) {

	}

	oCanvas.renderAll();
	onUpdate();
	$(".objPopMenu").hide();
}


function procDelete() {
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		if (curObj[0].isEditing) return true;
		if (curObj){
			curObj.forEach(function (object) {
				oCanvas.remove(object);
			});
			oCanvas.discardActiveObject();
			oCanvas.renderAll();
			onUpdate();
			$(".objPopMenu").hide();
		}
	}

	// chkScroll();

	if( $('.canvas-page').length === 1 ){
		setCanvas(0);
	}

}


function procForward(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj.forEach(function (object) {
			oCanvas.bringForward(object);
		});
		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}


function procForwardFirst(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj.forEach(function (object) {
			oCanvas.bringToFront(object);
		});
		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procBackward(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj.forEach(function (object) {
			oCanvas.sendBackwards(object);
		});
		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procBackwardLast(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj.forEach(function (object) {
			oCanvas.sendToBack(object);
		});
		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procFlipX(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		if (curObj[0].flipX){
			curObj[0].set({flipX:false});
		}else{
			curObj[0].set({flipX:true});
		}

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procFlipY(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		if (curObj[0].flipY){
			curObj[0].set({flipY:false});
		}else{
			curObj[0].set({flipY:true});
		}

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}



function procRotate(nAngle){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		var curAngle = curObj[0].angle;
		curObj[0].rotate(curAngle+nAngle);

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}


function procAlignLeft(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj[0].set({left:1});
		curObj[0].setCoords();

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}


function procAlignRight(){
	curObj = oCanvas.getActiveObjects();

	if (curObj.length){

		//소수점 보정
		var scaleX = parseFloat(nCurZoom)/2;

		curObj[0].set({left: (oCanvas.width / scaleX) - (curObj[0].width * curObj[0].scaleX)});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procAlignCenter(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){

		var scaleX = parseFloat(nCurZoom)/2;

		curObj[0].set({left: ((oCanvas.width / scaleX) / 2) - ((curObj[0].width * curObj[0].scaleX) / 2)});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function procSetGroup(){

	if (!oCanvas.getActiveObject()) {
		return;
	}
	if (oCanvas.getActiveObject().type !== 'activeSelection') {
		return;
	}
	oCanvas.getActiveObject().toGroup();
	oCanvas.requestRenderAll();

	onUpdate();
	$(".objPopMenu").hide();
}



function procSetUnGroup(){
	if (!oCanvas.getActiveObject()) {
		return;
	}
	if (oCanvas.getActiveObject().type !== 'group') {
		return;
	}
	oCanvas.getActiveObject().toActiveSelection();

	oCanvas.requestRenderAll();
	onUpdate();
	$(".objPopMenu").hide();
}

function chkObject(){
	curObj = oCanvas.getActiveObjects();

	if(curObj.length === 1){//obj가 1개만 클릭

		if (curObj[0]){

			if (curObj[0].type == 'textbox'){

				//폰트사이즈
				$(".objFSize").val(curObj[0].fontSize);
				//자간
				$("#objCS").val(curObj[0].charSpacing);
				//자간str
				$("#objCSVal").html(curObj[0].charSpacing);
				//행간
				$("#objLH").val(curObj[0].lineHeight);
				//행간str
				$("#objLHVal").html(curObj[0].lineHeight);

				$(".objFTA").removeClass("active");
				$(".objFTA_"+curObj[0].textAlign).addClass("active");


				if(curObj[0].fontWeight == '800'){
					$(".objFS[data-val='bold']").addClass("active");
				}else{
					$(".objFS[data-val='bold']").removeClass("active");
				}

				if(curObj[0].fontStyle == 'italic'){
					$(".objFS[data-val='italic']").addClass("active");
				}else{
					$(".objFS[data-val='italic']").removeClass("active");
				}

				if(curObj[0].underline){
					$(".objFS[data-val='underline']").addClass("active");
				}else{
					$(".objFS[data-val='underline']").removeClass("active");
				}

				if(curObj[0].shadow == '' || curObj[0].shadow == null){
					$(".objFS[data-val='shadow']").removeClass("active");
				}else{
					$(".objFS[data-val='shadow']").addClass("active");
				}

				$(".objFC").val(curObj[0].fill);
				$(".objFBC").val(curObj[0].textBackgroundColor);
				$(".objFF").val(curObj[0].fontFamily);

				curObj[0].setControlsVisibility(objControlsTxt);

				var $contents_menu_wrap = $('.contents-menu-wrap');

				$('.object-wrap').removeClass('d-flex').addClass('d-none');
				$contents_menu_wrap.addClass('d-flex').removeClass('d-none');

				//외곽선
				if(curObj[0].stroke !== null){
					var stroke_width = Math.floor((curObj[0].strokeWidth/curObj[0].scaleX)*10);
					$('input[name="stroke-width-range"]').val(stroke_width);
					$('input[name="stroke-width"]').val(stroke_width);
					$('input[name="stroke-color"]').val(curObj[0].stroke);
					$('#active-stroke').prop('checked',true);
				}
				//그림자
				var shadow = curObj[0].shadow;
				if(shadow !== null){
					$('input[name="shadow-blur-range"]').val(shadow.blur);
					$('input[name="shadow-blur"]').val(shadow.blur);
					$('input[name="shadow-color"]').val(shadow.color);
					$('.shadow-direct li[data-y="'+shadow.offsetY+'"][data-x="'+shadow.offsetX+'"]').addClass('active');
					$('#active-shadow').prop('checked',true);
				}

				if($contents_menu_wrap.data('type') != '_text'){
					$('.icon-menu-wrap > ul > li > div[data-val="_text"]').click();
				}

			}else{ //텍스트가 아닌 경우

				$('.contents-menu-wrap').removeClass('d-flex').addClass('d-none');
				$('.object-wrap').addClass('d-flex').removeClass('d-none');

			}

		}

	}else{//obj가 x클릭

		$('.objFS , .objFTA').removeClass('active');
		$(".objFC , .objFBC").val('#00000');
		$('.objFSize').val(60);
		$('#objCS').val(0);
		$('#objLH').val(1.16);
		//$('.objFF').val('Nanum Gothic');

		$('.contents-menu-wrap').addClass('d-flex').removeClass('d-none');
		$('.object-wrap').removeClass('d-flex').addClass('d-none');

		//외곽선
		$('input[name="stroke-width-range"]').val(2);
		$('input[name="stroke-width"]').val(2);
		$('input[name="stroke-color"]').val('#fe7e8d');
		$('#active-stroke').prop('checked',false);
		//그림자
		$('input[name="shadow-blur-range"]').val(5);
		$('input[name="shadow-blur"]').val(5);
		$('input[name="shadow-color"]').val('#fe7e8d');
		$('.shadow-direct li').removeClass('active');
		$('#active-shadow').prop('checked',false);

	}
	//setObjHeight();
}



function setBackgroundImg(img){
	//var img = img.replace(/\.150/g,".500");

	fabric.Image.fromURL(img, (oImg) => {
		oImg.set({
			opacity: 1,
			scaleX: nCanvasWidth/oImg.width,
			scaleY: nCanvasHeight/oImg.height
			// scaleX: oCanvas.width*nCurZoom,
			// scaleY: oCanvas.height*nCurZoom

		});
		oCanvas.setBackgroundImage(oImg, oCanvas.requestRenderAll.bind(oCanvas),{
			backgroundImageOpacity: 1,
			backgroundImageStretch: true
		});
		onUpdate();

	});
}

function clearBackground(){
	const image = new fabric.Image('');
	oCanvas.setBackgroundImage(image, oCanvas.renderAll.bind(oCanvas));
	oCanvas.setBackgroundColor('', oCanvas.renderAll.bind(oCanvas));
	onUpdate();
}


// function unDo(){
//
// 	if(isRemoveHistory) {
// 		oCanvas.historyUndo.pop();
// 		isRemoveHistory = false;
// 	}
//
// 	for (var idx=0;idx<aCanvas.length ;idx++ ){
// 		if (aCanvas[idx] != null){
// 			aCanvas[idx].discardActiveObject();
// 			aCanvas[idx].renderAll();
// 		}
// 	}
// 	oCanvas.undo(()=>{
// 		oCanvas.renderAll();
// 	});
// }
//
//
// function reDo(){
// 	for (var idx=0;idx<aCanvas.length ;idx++ ){
// 		if (aCanvas[idx] != null){
// 			aCanvas[idx].discardActiveObject();
// 			aCanvas[idx].renderAll();
// 		}
// 	}
// 	oCanvas.redo(()=>{
// 		oCanvas.renderAll();
// 	});
// }

/*
function unDo(){
	if (nHistory > 0){
		nHistory--;
		var nPageNo = aHistory[nHistory]["nCanvasNo"];
		if (aCanvas[nPageNo] == null) return;
		$("#imgPageThumb"+nPageNo).trigger("click");
		aCanvas[nPageNo].loadFromJSON(JSON.parse(aHistory[nHistory]["sCanvasData"]), function(obj) {
			aCanvas[nPageNo].renderAll();
		});
	}
}


function reDo(){
	if (nHistory < aHistory.length-1){
		nHistory++;
		var nPageNo = aHistory[nHistory]["nCanvasNo"];
		if (aCanvas[nPageNo] == null) return;
		$("#imgPageThumb"+nPageNo).trigger("click");
		aCanvas[nPageNo].loadFromJSON(JSON.parse(aHistory[nHistory]["sCanvasData"]), function(obj) {
			aCanvas[nPageNo].renderAll();
		});

	}
}
*/
function addRecentColor(act , colorCode){
	var html,$target;

	if(act === 'bg') $target = $('.recent-bg-color'); //배경
	else if(act === 'text')  $target = $('.recent-text-color'); //글자색

	//같은 색을 사용한적이 있으면 제거
	$target.find('ul li').each(function () {
		if (colorCode === rgb2hex($(this).css('backgroundColor'))) $(this).remove();
	})

	//최근사용 색은 7개 이상 사용 불가
	if ($target.find('ul li').length >= 7) $target.find('ul li:last-child').remove();
	html = '<li style="background-color:' + colorCode + '" class="editor_palet_color objFC_p"></li>';
	$target.find('ul').prepend(html); //앞으로 넣기

	if ($target.hasClass('d-none')) {
		$target.toggleClass('d-none').toggleClass('d-flex');
	}
}

function chkScroll(){

	var setSize = $('.emRotate.active').data('val');
	var chkvalue = 300;
	var $canvas_page = $('.canvas-page');
	var $canvas_scroll = $('.canvas-scroll');

	if(setSize === 'P') chkvalue = 180;
	$('#emRotate').val(setSize);

	$canvas_page.each(function(k){
		if($(this).offset().top < chkvalue && $(this).offset().top > (chkvalue*-1)){
			if(parseInt(nCurPageNo,10) !== parseInt($(this).data('idx'),10)){
				setCanvas($(this).data('idx'));
			}
		}
	});

	//스크롤이 끝을 찍은 경우, 마지막 canvas 활성화
	var canvas_scroll_tot_h = Math.floor($canvas_scroll.scrollTop()+$canvas_scroll.height());
	var canvas_scroll_inner_h = 0;

	$canvas_scroll.find(' > div').each(function(){
		canvas_scroll_inner_h += Math.floor($(this).height());
	});

	if(canvas_scroll_inner_h <= canvas_scroll_tot_h+1){
		setCanvas($canvas_page.last().data('idx'));
	}

}

// no usges

function setBackgroundColor(color , all=false){
	if(all === true){ //모든 페이지 적용
		const image = new fabric.Image('');
		$.each(aCanvas,function(k , obj){
			if(typeof obj !== 'undefined'){
				//clear
				obj.setBackgroundImage(image, obj.renderAll.bind(obj));
				obj.setBackgroundColor('', obj.renderAll.bind(obj));
				//setColor
				obj.setBackgroundColor(color, obj.renderAll.bind(obj));
			}
		});
	}else{
		clearBackground();
		oCanvas.setBackgroundColor(color, oCanvas.renderAll.bind(oCanvas));
	}

	onUpdate();
}

function procAlignTop(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj[0].set({top:1});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}



function procAlignBottom(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj[0].set({left: oCanvas.height - (curObj[0].height * curObj[0].scaleY)-1});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}


function procAlignCenterAbsolute(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){
		curObj[0].center();

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}

function showModifiedError(data){

	var html  ='<div class="save-caution-area">';
		html +='    <div class="save-caution-bg"></div>';
		html +='    <div class="save-caution-wrap">';
		html +='        <img src="/images/de_caution.png"  alt="caution-mark" />';
		html +='        <h3>저장할 수 없는 디자인입니다.</h3>';
		html +='        <p>'+data.username+' 님이 '+data.last_modified+'에 마지막으로 저장하였습니다.</p>';
		html +='        <p>동시에 편집할 경우 작업내역이 저장되지 않을 수 있습니다.</p>';
		html +='        <div class="button-wrap">';
		html +='            <button class="btn curr-copy" style="letter-spacing: -.1px">현재 작업으로 복사본 만들기</button>';
		html +='            <button class="btn load-recent-data">최신버전 불러오기</button>';
		html +='        </div>';
		html +='    </div>';
		html +='</div>';

	$('body').append(html);

}

$(document).on('click','.curr-copy',function(){
	$('#save_type').val('new');
	var $top_title = $('input[name="top_title"]');
	$top_title.val($top_title.val()+' - 복사본');
	$('.btnSave').click();
});
$(document).on('click','.load-recent-data',function(){
	location.reload();
});


function setContentsWrap(t){

	//ajax load 초기화
	isLoadAjaxEnd = false;
	loc_page = 1;
	//ajax load 초기화

	var $contents_menu_wrap = $('.contents-menu-wrap');
	var $object_wrap = $('.object-wrap');
	if(typeof oCanvas !== 'undefined'){
		// 다른영역에서 _text로 설정이 되는 경우 선택된 객체가 풀려 문제발생 > 주석처리 @240826 황기석
		// oCanvas.discardActiveObject();
		// oCanvas.renderAll();
	}

	if( $contents_menu_wrap.hasClass('d-none') && $object_wrap.hasClass('d-flex') && $contents_menu_wrap.data('type') === t ){
		$contents_menu_wrap.addClass('d-flex').removeClass('d-none');
		$object_wrap.removeClass('d-flex').addClass('d-none');
		return false;
	}
	$contents_menu_wrap.addClass('d-flex').removeClass('d-none');
	$object_wrap.removeClass('d-flex').addClass('d-none');

	var loader_html  = '<div class="loader-wrap d-flex align-items-center justify-content-center flex-row py-5">';
		loader_html += '    <div class="spinner-grow text-primary" role="status">';
		loader_html += '        <span class="visually-hidden">Loading...</span>';
		loader_html += '    </div>';
		loader_html += '    <div class="ms-2"> 불러오는 중입니다. </div>';
		loader_html += '</div>';
	$contents_menu_wrap.html(loader_html).data('type',t).attr('data-type',t);

	$.ajax({
		type : 'post'
		,   url  : '/Canvas/getContentsWrapPage'
		,   data : {
			m : 'get_contents_wrap_page'
			,   type : t
			,   _csrf : $('input[name="_csrf"]').val()
		}
		,   dataType : 'html'
		,   success : function(result){
			$('.contents-menu-wrap').html(result);
		}
	}).done(function(){

		// var gallery_obj = {
		// 	rowHeight : 88,
		// 	lastRow : 'nojustify',
		// 	border : 0,
		// 	margins : 15,
		// }
		//
		// if(t !== '_upload') gallery_obj.maxRowsCount = 1;
		//
		// $('.justified-gallery').justifiedGallery(gallery_obj);


		//컨텐츠 메뉴 좌우 사이즈 처리
		var $col_resize  = $(".col-resize");
		var $left_menu = $('.left-menu');
		$col_resize.css('left' , parseInt($left_menu.width()));
		$col_resize.draggable({
			axis: "x"
			,   drag : function(e,ui){
				ui.position.left = parseInt($left_menu.width());
			}
		});

		applyDrag();
	});


}

//검색
function setSearchText(str,type){
	$('input[name="search-text"]').val(str);
	setTextCancelIcon();
	getList();
}

//검색에서 x 액션
function setTextCancelIcon(){
	if( $('input[name="search-text"]').val() !== ''){
		$('.icon-text-cancel').show();
	}else{
		$('.icon-text-cancel').hide();
	}
}

function printSearchResult(data, m , isAppend){

	let html = '';

	var classType = 'objItemImg';
	if( m === '_bg') classType = 'objBGImg';
	else if( m === '_template') classType = 'objItemTemplate';

	if(data.length < 1 && $('.result-list-wrap div a').length < 1){ //데이터가 없는 경우

		html += '<div class="d-flex justify-content-center align-items-center">검색 결과가 없습니다.</div>';
		$('.result-list-wrap').html(html).show();

	}else{ //데이터가 있는 경우

		$.each(data,function(k,r){

			// html += '            <a class="' + a_class + ' " style="min-width: 100px;max-width: 300px;overflow-x: hidden">';
			// html += '				<span class="d-flex justify-content-center">';
			// html += '               	<img src="' + rr.thumb_file + '" data-paid_yn="'+ rr.paid_yn +'" data-org_file="' + rr.save_file + '" style=" height: 88px" class="'+img_class+' canvas-img " data-w="' + rr.img_w + '" data-h="' + rr.img_h + '" alt="" />';
			// html += '            	</span>';
			// if(rr.paid_yn === 'Y' && paid_user === 'N'){
			// 	html += '				<span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>';
			// }
			// html += '            </a>';


			if( m === '_template'){
				html += '<a>';
				html += '<img alt="" src="'+r.thumb_file+'" data-tid="'+r.template_id+'" data-paid_yn="'+ r.paid_yn +'" class="'+classType+' ui-draggable ui-draggable-handle canvas-img" data-idx="'+r.template_id+'" alt="'+r.title+'" />';
				if(r.paid_yn === 'Y' && paid_user === 'N'){
				html += ' <span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>';
				}
				html += '</a>';
			}else if(r.save_file.indexOf('pdf') <= -1){
				html += '<a>';
				html += '	<span class="d-flex justify-content-center h-100">';
				html += '		<img alt="" src="'+r.thumb_file+'"  data-cid="'+r.clip_id+'" data-paid_yn="'+ r.paid_yn +'" data-org_file="'+r.save_file+'" class="'+classType+' canvas-img" data-w="'+r.img_w+'" data-h="'+r.img_h+'" alt="'+r.title+'" />';
				if(r.paid_yn === 'Y' && paid_user === 'N'){
				html += '		<span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>';
				}
				html += '	</span>';
				html += '</a>';
			}else{
				console.log('pdf');
			}

		})

		if(isAppend === false) {

			html = '<div class="justified-gallery">'+html+'</div>';

			$('.result-list-wrap').html(html).show();

			$('.contents-menu-wrap .loader-wrap').toggleClass('d-none').toggleClass('d-flex');

			setTimeout(function(){
				$('.justified-gallery').justifiedGallery({
					rowHeight : 88,
					maxRowHeight:88,
					lastRow : 'nojustify',
					border : 0,
					margins : 15
				});
			},300)

		} else {
			$('.result-list-wrap > div').append(html);
			setTimeout(function() {
				$('.justified-gallery').justifiedGallery('norewind');
			});
		}

		applyDrag();

	}

}

function paid_modal()
{
	var $modal = $('#alert-form');

	var html  = '<div class="modal-body text-center position-relative d-flex gap-2 flex-column align-items-center">';
		html += '	<button type="button" class="close btn fs-5 float-end position-absolute" style="top: 15px;;right: 15px;" data-dismiss="modal" aria-label="Close" onclick="$(\'#alert-form\').modal(\'hide\');">';
		html += '   	<i class="fa-solid fa-xmark"></i>';
		html += '	</button>';
		html += '   <h3><i class="fa-solid fa-crown" style="color: #FFD43B"></i> 유료회원 전용입니다. </h3>';
		html += '   <p>다양한 콘텐츠와 기능을 마음껏 이용해 보세요.</p>';
		html += '   <a role="button" target="_blank" href="/Payment/upsertForm" class="btn btn-black" style="width: 35%;">유료회원 가입하기</a>';
		html += '</div>';

	$modal.find('.modal-content').html(html)
	$modal.modal('show');

}
function mobile_modal()
{
	var $modal = $('#alert-form');

	var html  = '<div class="modal-body text-center position-relative d-flex gap-2 flex-column align-items-center">';
		html += '	<button type="button" class="close btn fs-5 float-end position-absolute" style="top: 15px;;right: 15px;" data-dismiss="modal" aria-label="Close" onclick="$(\'#alert-form\').modal(\'hide\');">';
		html += '   	<i class="fa-solid fa-xmark"></i>';
		html += '	</button>';
		html += '   <h3><i class="fa-solid fa-circle-exclamation"></i>&nbsp;&nbsp;NOTICE&nbsp;&nbsp;<i class="fa-solid fa-circle-exclamation"></i></h3>';
		html += '   <p>PC 사용을 권장합니다.<br>모바일 버전에서 작업할 시,<br>오류가 발생할 수 있습니다.</p>';
		html += '</div>';

	$modal.find('.modal-content').html(html)
	$modal.modal('show');

}

//정보 가져오기
function getList(){

	//ajax load 초기화
	isLoadAjaxEnd = false;
	loc_page = 2;

	var str = $('input[name="search-text"]').val();
	var $search_type =  $('input[name="search-type"]');
	if( str !== '' ){

		$('input[name="search-text-hidden"]').val(str);

		$('.contents-list-wrap').hide();
		$('.contents-menu-wrap .loader-wrap').toggleClass('d-none').toggleClass('d-flex');

		if($search_type.length < 0){
			alert('비정상적인 검색');
			location.reload();
			return false;
		}

		var m = $search_type.val();

		$.ajax({
			type: 'post',
			url: "/Canvas/getSearchContents",
			data: {
				m : m
				,   str : str

			},
			dataType: 'json',
			success: function(result){
				printSearchResult(result.data , m , false);
			}

		});


	}else{

		$('.contents-list-wrap').show();
		$('.result-list-wrap').hide();

	}
}

function getLoadAjax(act){

	var type = $('.icon-menu li div.active').data('val');
	var search_text = '';
	var $search_text_hidden = $('.contents-menu-wrap input[name="search-text-hidden"]');
	if( $search_text_hidden.length > 0){
		search_text = $search_text_hidden.val();
	}

	var obj = { page : loc_page , type : type , act : act , search_text : search_text};

	$.ajax({
		type: 'post',
		url: "/Canvas/getLoadAjax",
		data: obj,
		dataType: 'json',
		async: false,
		success: function(result){
			if(result.data.aList.length < per_page) isLoadAjaxEnd = true; //리스트가 마지막이라면 더이상 ajax 함수 실행안하도록

			if(act === 'category') printAddListCategory(result.data.aList , type);
			else printSearchResult(result.data.aList , type , true);
		}
	}).done(function(){

		loc_page++;
		page_ing = false;

	});

}

function printAddListCategory(data , type){

	var html = '' , a_class = '' , img_class = 'objItemImg';

	var jg_obj = {
		rowHeight : 88,
		lastRow : 'nojustify',
		border : 0,
		margins : 15,
		maxRowsCount : 1
	};

	if(type === '_bg' || type === '_clip') {

		$.each(data, function (k, r) {

			html += '<div class="contents-list-wrap position-relative">';
			html += '    <p class="d-flex justify-content-between">' + r.title + '<span class="_more d-inline-block d-flex align-items-center text-primary" style="font-size: 13px;cursor: pointer" onclick="setSearchText(\'' + r.title + '\')">더보기</span></p>';
			html += '    <div class="overflow-hidden">';
			html += '        <div class="image-list" style="overflow: hidden;width: 100vw">';
			html += '            <div class="image-list-inner justified-gallery editor_imglistall">';

			$.each(r.clips, function (kk, rr) {
				if(kk === 0) a_class = 'active';
				if(type === '_bg') img_class = 'objBGImg';

				html += '            <a class="' + a_class + ' " style="min-width: 100px;max-width: 300px;overflow-x: hidden">';
				html += '				<span class="d-flex justify-content-center">';
				html += '               	<img src="' + rr.thumb_file + '"  data-cid="'+rr.clip_id+'" data-paid_yn="'+ rr.paid_yn +'" data-org_file="' + rr.save_file + '" style=" height: 88px" class="'+img_class+' canvas-img " data-w="' + rr.img_w + '" data-h="' + rr.img_h + '" alt="" />';
				html += '            	</span>';
				if(rr.paid_yn === 'Y' && paid_user === 'N'){
				html += '				<span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>';
				}
				html += '            </a>';
			});

			html += ' 				<div class="list-ignore d-none align-items-center justify-content-end" style="cursor: pointer" onclick="setSearchText(\'' + r.title + '\')"><a>더보기</a></div>';
			html += '            </div>';
			html += '        </div>';
			html += '    </div>';
			html += '    <button class="image-prev"> <i class="fa-solid fa-angle-left"></i> </button>';
			html += '    <button class="image-next"> <i class="fa-solid fa-angle-right"></i> </button>';
			html += '</div>';
		});

	}else if(type === '_upload'){

		jg_obj.maxRowsCount = 0;

		$.each(data, function(k , r) {
			html += '<a>';
			html += '	<img src="' + r.image_file + '"  data-mid="'+r.myimg_id+'" data-org_file="' + r.image_file + '" data-paid_yn="N" data-w="' + r.w + '" data-h="' + r.h + '" class="objItemImg objItemImgMy canvas-img" />';
			html += '	<span class="myimg-delete" onclick="myupload_delete(\''+r.myimg_id+'\');">';
			html += '		<img src="/img/canvas_myimg_del.png" alt="" />';
			html += '	</span>';
			html += '</a>';

		});

	}else{ //template

		$.each(data, function(k , r){

			html += '<div class="contents-list-wrap position-relative">';
			html += '    <p class="d-flex justify-content-between">'+r.title+'<span class="d-inline-block d-flex align-items-center text-primary" style="font-size: 13px;cursor: pointer" onclick="setSearchText(\''+r.title+'\')">더보기</span></p>';
			html += '    <div class="overflow-hidden">';
			html += '        <div class="image-list" style="overflow: hidden;width: 100vw">';
			html += '            <div class="image-list-inner justified-gallery editor_imglistall">';

			$.each(r.templates , function(kk, rr){
				if(kk === 0) a_class = 'class="active"';
				else a_class = '';
				html += '            <a '+a_class+'>';
				html += '                	<img src="'+rr.thumb_file+'"  data-paid_yn="'+ rr.paid_yn +'" class="objItemTemplate canvas-img" data-idx="'+rr.template_id+'"  alt="" />';
				if(rr.paid_yn === 'Y' && paid_user === 'N'){
				html += '					<span><img class="paid-mark position-absolute"  src="/img/paid_mark.png" alt="유료마크" /></span>';
				}
				html += '            </a>';

			});

			html += '                <div class="list-ignore d-none align-items-center justify-content-end" style="cursor: pointer" onclick="setSearchText(\''+r.title+'\')"><a>더보기</a></div>';
			html += '            </div>';
			html += '        </div>';
			html += '    </div>';
			html += '    <button class="image-prev"> <i class="fa-solid fa-angle-left"></i> </button>';
			html += '    <button class="image-next"> <i class="fa-solid fa-angle-right"></i> </button>';
			html += '</div>';

		});

	}

	$('.contents-list-container').append(html);
	setTimeout(function(){
		$('.justified-gallery').justifiedGallery(jg_obj);
	},300)


	applyDrag();

}

function cancel_contents_lists(){
	// var val = $('.icon-menu > li > div.active').data('val');
	// setContentsWrap(val);
	$('input[name="search-text"]').val('');
	$('.contents-list-wrap').toggle();
	$('.result-list-wrap').toggle();
}

function dragging(event) {
	var min_w = 260;
	var max_w = 500;
	if( parseInt(event.clientX)-73 > min_w && parseInt(event.clientX)-73 <= max_w  ){
		$('.contents-menu-wrap').css('width' , (parseInt(event.clientX)-73)+'px');
	}
}

// ----------------------- 외곽선
function setStrokeWidth()
{
	if($('#active-stroke').prop('checked') === true){//외곽선 설정
		if (typeof curObj !== 'undefined') { //객체확인
			if (curObj[0].type === 'textbox') {//텍스트박스확인
				var val = $('input[name="stroke-width"]').val() < 1 ? 1 : $('input[name="stroke-width"]').val();
				var scale = curObj[0].get('scaleX')/10;
				var strokeWidth = (val / 10) * scale;
				strokeWidth = strokeWidth < 1 ? 1 : strokeWidth;
				curObj[0].set({strokeWidth: strokeWidth});
				oCanvas.renderAll();
				onUpdate();
			}
		}
	}
}

// ----------------------- delete upload file
function myupload_delete(myimg_id){

	if(confirm('선택하신 이미지를 삭제하시곘습니까?')){

		$.ajax({
			url: "/Canvas/userUploadDelete",
			data: { _csrf : $('input[name="_csrf"]').val() , myImg_id : myimg_id },
			method: "post",
			dataType: "json",
			async: false,
			success: function (result) {
				if(result.msg) alert(result.msg);
				if(result.success){
					$('.icon-menu div[data-val="_upload"]').trigger('click');
				}
			}
		});
	}

}


$(document).on('change','#active-stroke',function(){

	if (typeof curObj !== 'undefined') {
		if (curObj[0].type === 'textbox') {

			//if( $('#accordionStroke .accordion-collapse').hasClass('show') == false ){
			if($(this).prop('checked') === true){
				if( $('#accordionStroke .accordion-collapse').hasClass('show') == false )
					$('.accordion-button[aria-controls="stroke-wrap"]').trigger('click');
				$('input[name="stroke-width-range"]').trigger('change');
			}else{
				curObj[0].set({stroke: null, strokeWidth: null});
				oCanvas.renderAll();
				onUpdate();
			}

		}else{
			$(this).prop('checked',false);
		}
	}else{
		$(this).prop('checked',false);
	}
});

$(document).on('change','input[name="stroke-width-range"]',function() {

	$('input[name="stroke-width"]').val($(this).val()).trigger('change');

	if (typeof curObj !== 'undefined' && curObj[0]) {
		if (curObj[0].type === 'textbox') {

			$('#active-stroke').prop('checked',true);

			var scale = curObj[0].get('scaleX');
			var rgb = $('input[name="stroke-color"]').val();
			var strokeWidth = ($(this).val() / 10) * scale;

			curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
			oCanvas.renderAll();
			onUpdate();
		}

	}

});

$(document).on('keyup','input[name="stroke-width"]',function() {

	if (typeof curObj !== 'undefined') {
		if (curObj[0].type === 'textbox') {
			$('#active-stroke').prop('checked',true);

			var scale = curObj[0].get('scaleX');
			var rgb = $('input[name="stroke-color"]').val();
			var strokeWidth = ($(this).val() / 10) * scale;

			curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
			oCanvas.renderAll();
			onUpdate();
		}
	}

});

$(document).on('change','input[name="stroke-color"]',function() {

	if(typeof curObj !== 'undefined' && curObj[0]) {

		if (curObj[0].type === 'textbox') {
			$('#active-stroke').prop('checked',true);
			var scale = curObj[0].get('scaleX');
			var rgb = $(this).val();
			var strokeWidth = ($('input[name="stroke-width"]').val() / 10) * scale;

			curObj[0].set({stroke: rgb, strokeWidth: strokeWidth});
			oCanvas.renderAll();
			onUpdate();
		}

	}

});


// ----------------------- 그림자

$(document).on('change','#active-shadow',function(){

	if (typeof curObj !== 'undefined' && curObj[0]) {
		if (curObj[0].type === 'textbox') {

			//if( $('#accordionStroke .accordion-collapse').hasClass('show') == false ){
			if($(this).prop('checked') === true){
				if( $('#accordionShadow .accordion-collapse').hasClass('show') == false )
					$('.accordion-button[aria-controls="shadow-wrap"]').trigger('click');
				$('input[name="shadow-blur-range"]').trigger('change');

			}else{
				curObj[0].set({shadow: null});
				oCanvas.renderAll();
				onUpdate();
			}

		}else{
			$(this).prop('checked',false);
		}
	}else{
		$(this).prop('checked',false);
	}
});

$(document).on('change','input[name="shadow-blur-range"]',function() {

	$('input[name="shadow-blur"]').val($(this).val()).trigger('change');

	if (typeof curObj !== 'undefined' && curObj[0]) {

		if (curObj[0].type === 'textbox') {

			var rgb = $('input[name="shadow-color"]').val();
			var x = 5, y = 5;
			var blur = $(this).val();
			var $activeObj = $('.shadow-direct li.active');

			if ($activeObj.length > 0) {
				y = $activeObj.data('y');
				x = $activeObj.data('x');
			} else {
				$('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
			}

			var shadow = new fabric.Shadow({
				blur: blur,
				color: rgb,
				offsetX: x,
				offsetY: y

			});

			curObj[0].set({shadow: shadow});
			oCanvas.renderAll();
			onUpdate();
		}

	}

});

$(document).on('keyup','input[name="shadow-blur"]',function() {

	if (typeof curObj !== 'undefined' && curObj[0]) {
		if (curObj[0].type === 'textbox') {

			var val = $(this).val() < 5 ? 5 : $(this).val();

			var rgb = $('input[name="shadow-color"]').val();
			var x = 5, y = 5;
			var blur = $(this).val();
			var $activeObj = $('.shadow-direct li.active');

			if ($activeObj.length > 0) {
				y = $activeObj.data('y');
				x = $activeObj.data('x');
			} else {
				$('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
			}

			var shadow = new fabric.Shadow({
				blur: blur,
				color: rgb,
				offsetX: x,
				offsetY: y

			});

			curObj[0].set({shadow: shadow});
			oCanvas.renderAll();
			onUpdate();
		}

	}

});

$(document).on('change','input[name="shadow-color"]',function() {

	if(typeof curObj !== 'undefined' && curObj[0]) {
		if (curObj[0].type === 'textbox') {
			var rgb = $(this).val();
			var x = 5, y = 5;
			var blur = $('input[name="shadow-blur"]').val();
			var $activeObj = $('.shadow-direct li.active');

			if ($activeObj.length > 0) {
				y = $activeObj.data('y');
				x = $activeObj.data('x');
			} else {
				$('.shadow-direct li[data-x="' + x + '"][data-y="' + y + '"]').addClass('active');
			}

			var shadow = new fabric.Shadow({
				blur: blur,
				color: rgb,
				offsetX: x,
				offsetY: y
			});

			curObj[0].set({shadow: shadow});
			oCanvas.renderAll();
			onUpdate();
		}
	}

});

$(document).on('click','.shadow-direct li',function() {

	if (typeof curObj !== 'undefined' && curObj[0]) {

		if (curObj[0].type === 'textbox') {

			var shadow = null;
			var bool_active = $(this).hasClass('active');
			$('.shadow-direct li').removeClass('active');

			if( bool_active === false ) {

				var x = $(this).data('x');
				var y = $(this).data('y');
				var rgb = $('input[name="shadow-color"]').val();
				var blur = $('input[name="shadow-blur"]').val();

				$(this).addClass('active');

				shadow = new fabric.Shadow({
					color: rgb,
					blur: blur,
					offsetX : x,
					offsetY : y
				});

			}

			curObj[0].set({shadow: shadow});
			oCanvas.renderAll();
			onUpdate();

		}

	}

});
