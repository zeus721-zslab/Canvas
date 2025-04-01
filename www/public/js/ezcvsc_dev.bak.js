var aCanvas = new Array(100);
var nCanvasNo = 0;
var nCurPageNo = 0;
var oCanvas;
var curObj;
var nHistory = -1;
var aHistory = new Array();
var nPage = 0;
// var nCanvasWidth;
// var nCanvasHeight;
var bSave = false;
var nCurZoom = null;
var _clipboard = null;
var isFirst = true; // InitCanvas 시 처음인 경우에만 zoom처리하기 위한 flag

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
				if(r !== null) aNewCanvas.push(r);
			});
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
		console.log('a' , aCanvas[nIdx].toDatalessJSON());
		addPage(aCanvas[nIdx].toDatalessJSON());
	}

});

// 배경적용
$(document).on("click",".objBGImg",function (e){
	e.stopImmediatePropagation();
	// console.log($(this).data("org_file"));
	// setBackgroundImg($(this).attr("src"));

	setBackgroundImg($(this).data("org_file"));

});

// 이미지 추가
$(document).on("click",".objItemImg",function (e){
	e.stopImmediatePropagation();

	$('.dummy_img').attr('src',$(this).data('org_file'));
	var thisobj = $(this);

	setTimeout(function(){
		addImage('object',thisobj.get(0));
	},100)

});

// 템플릿 추가
$(document).on("click",".objItemTemplate",function (e){
	e.stopImmediatePropagation();
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
	$("#objCSVal").html($(this).val());

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
	$("#objLHVal").html($(this).val());

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

function chkScroll(){

	var setSize = $('.emRotate.active').data('val');
	var chkvalue = 300;
	if(setSize === 'P') chkvalue = 180;
	$('#emRotate').val(setSize);

	$('.canvas-page').each(function(k){
		if($(this).offset().top < chkvalue && $(this).offset().top > (chkvalue*-1)){
			if(parseInt(nCurPageNo,10) !== parseInt($(this).data('idx'),10)){
				setCanvas($(this).data('idx'));
			}
		}
	});

}

$(document).on('click','.title-save',function(e){
	e.preventDefault();
	$target = $(this).parent();
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



$(document).ready(function (){

	//하단 사이즈조절
	$('.emRotate').on('click',function(){
		$('.emRotate').removeClass('active');
		var val = $(this).data('val');
		if(val == 'S') {
			nCanvasWidth = 778;
			nCanvasHeight = 778;
		}else if(val == 'P'){
			nCanvasWidth = 778;
			nCanvasHeight = 1100;
		}else{
			nCanvasWidth = 1100;
			nCanvasHeight = 778;
		}
		procZoom(nCurZoom);
		$(this).addClass('active');
		chkScroll();
	});

	//스크롤시 처리
	$('.canvas-scroll').scroll(chkScroll);

	$(".isDraw").click(function (e){
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

	$("#frmSearch").submit(function (e){
		e.stopImmediatePropagation();
		if ($("#txtKeyword").val() == '') return false;
		var vcSearchKind = $("#frmSearch").attr("val");

		$.post("/_proc/procHelper.htm",
			{
				vcKind : vcSearchKind,
				sKeyword : $("#txtKeyword").val(),
				commitType : "search_ezcvs"
			},
			function (data){
				if (data["ret"] == 'succ'){
					$(".right_"+vcSearchKind+"_def").hide();
					$(".right_"+vcSearchKind+"_search").show();
					$(".right_"+vcSearchKind+"_search_result").html("<IMG src='/images/spinner100.gif'>");
					var stmt = '';
					if (vcSearchKind == 'obj'){
						var sObjName = "objItemImg";
					}else{
						var sObjName = "objBGImg";
					}
					$.each(data["list"],function (idx,obj){
						stmt += "<li class='editor_listimg'><img src='"+obj["thumb"]+"' style='height:112px;' class='"+sObjName+"' w='300' /></li>";
					});

					$(".right_"+vcSearchKind+"_search_result").html(stmt);
					applyDrag();
					$(".btnSearchClose").show();

				}else{
					alert('error');
				}
			},
			'json'
		);

		return false;

	});

	$(".btnDownload").click(function (e){
		e.stopImmediatePropagation();
		oCanvas.discardActiveObject();
		oCanvas.renderAll();

		var curZoom = oCanvas.getZoom();
		procZoom(1);

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
		$("#vcSaveTitle").val('test');
		$("#aImgData").val(JSON.stringify(aJson));
		$("#frmDown").submit();

	});

	$(".btnSlide").click(function (e){
		e.stopImmediatePropagation();
		oCanvas.discardActiveObject();
		oCanvas.renderAll();

		var curZoom = oCanvas.getZoom();
		procZoom(1);

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


	$(".btnSave").click(function (e){
		e.stopImmediatePropagation();
		oCanvas.discardActiveObject();
		oCanvas.renderAll();


		if($('input[name="top_title"]').val() == ''){
			alert('제목을 입력하세요.');
			$('input[name="top_title"]').focus();
			return false;
		}

		if(!confirm('저장하시겠습니까?')) return false;

		$('input[name="title"]').val($('input[name="top_title"]').val());

		var curZoom = oCanvas.getZoom();
		procZoom(1);

		var aJson = [];
		var aImgData = [];
		var aImgTitle = [];
		var idx=0;
		var nPage = 0;
		var objThumbCanvas;
		$(".canvas-page").each(function (){
			var nIdx = $(this).data("idx");
			if (parseInt(nIdx) >= 0 && aCanvas[nIdx] != null){
				var temp_json = aCanvas[nIdx].toDatalessJSON();
				var json_data = JSON.stringify(temp_json);
				aJson.push(json_data);
				aImgData.push(aCanvas[nIdx].toDataURL());
				nPage++;
			}
		});

		$("#thumb_file").val(JSON.stringify(aImgData));
		$("#blob_data").val(JSON.stringify(aJson));
		$("#page").val(nPage);
		$("#rotate").val($('.emRotate.active').data('val'));

		procZoom(curZoom);

		$("#frmSave").submit();

	});

	// 요소, 배경
	//사용안함
	$(".btnObjBG").click(function (e){
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


	$(".btnSearchClose").click(function (e){
		e.stopImmediatePropagation();
		$(this).hide();
		$("#txtKeyword").val('');
		var vcSearchKind = $("#frmSearch").attr("val");
		$(".right_"+vcSearchKind+"_search_result").html('');
		$(".right_"+vcSearchKind+"_search").hide();
		$(".right_"+vcSearchKind+"_def").show();

	});


	$(".btnMoreItem").click(function (e){
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



	$(document).on('click',".objItemTxt",function (e){
		e.stopImmediatePropagation();
		addTxt();
	});

	$(document).on('change','.upImgFile', function (e){
		e.stopImmediatePropagation();
		var aFile = $(this).val().split('.');
		var fileExt = aFile[aFile.length-1];
		fileExt = fileExt.toUpperCase();
		if (fileExt == 'JPG' || fileExt == 'PNG' || fileExt == 'GIF' || fileExt == 'JPEG'){
			var nIdx = $(this).attr("nIdx");
			$("#frmImgUpload").submit();
		}else{
			alert('이미지 파일(JPG,PNG,GIF)만 등록가능합니다.');
		}

	});


	$(".btnPageAdd").click(function (e){
		e.stopImmediatePropagation();
		addPage();
	});


	$(".btnUnDo").click(function (e){
		e.stopImmediatePropagation();
		unDo();
	});

	$(".btnReDo").click(function (e){
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


	//### set Font Size
	$(document).on('change',".objFSize",function (e){
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


	$(".objFSize").click(function (e){
		e.stopImmediatePropagation();
		$(".dlFS").toggle();
	});

	$(".objFSize").blur(function (e){
		e.stopImmediatePropagation();
		//$(".dlFS").hide();
	});

	$(".dlFSsub").mouseover(function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"#e5e5e5","color":"#000","font-weight":"bold"});
	});

	$(".dlFSsub").mouseout(function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"","color":"","font-weight":"normal"});
	});


	$(".dlFSsub").click(function (e){
		e.stopImmediatePropagation();
		$(".objFSize").val($(this).attr("val"));

		$(".objFSize").trigger("change");
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

		if ($target.hasClass('d-none')) $target.toggleClass('d-none').toggleClass('d-flex');
	}

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
		if (curObj[0]){
			if (curObj[0].type == 'textbox'){
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
				if (curObj[0].type == 'textbox'){
					//FontloadAndUse(curObj[0],$(this).val());
					curObj[0].set("fontFamily",$(this).val());
					oCanvas.renderAll();
					onUpdate();
				}
			}
		}
	});


	$(".objDelete").click(function (e){
		e.stopImmediatePropagation();
		procDelete();
	});




	$(".btnCT").mouseover(function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"#003399","color":"#fff"});
	});

	$(".btnCT").mouseout(function (e){
		e.stopImmediatePropagation();
		$(this).css({"background-color":"#fff","color":"#000"});
	});

	$(".btnCT").click(function (e){
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



	$(".btnAlign").click(function (e){
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

});






//##### Event Handler ####
$(document).keydown(function (e){
	e.stopImmediatePropagation();
	var pxMove = 1;

	if(isFontLoaded === false) return false;

	curObj = oCanvas.getActiveObjects();

	if (curObj.length){
		switch (e.keyCode){
			case 8:		// backspace
			case 46:	// Delete
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
					object.set('left',(object.get('left') < pxMove) ? 0 : object.get('left')-pxMove);
				});
				oCanvas.renderAll();
				//onUpdate();
				break;
			case 38 :	// Up
				curObj.forEach(function (object) {
					object.set('top',(object.get('top') < pxMove) ? 0 : object.get('top')-pxMove);
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
					ret = procCopy(e);
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

		case 86:	// Ctrl+V
			if (event.ctrlKey){
				procPaste(e);
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

		curObj1 = oCanvas.getActiveObject();
		curObj2 = oCanvas.getActiveObjects();
		//console.log(curObj1);
		//console.log(curObj2);

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




$(document).click(function (e){
	e.stopImmediatePropagation();
	$(".objPopMenu").hide();
});





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

		}
	});

}


//사용안함
function setObjHeight(){
	// var h = $(".editor_tools").height()
	// 		- $(".editor_tooltab").height()
	// 		- $(".editor_search").height()
	// 		- $(".editor_tooladd").height()
	// 		- $(".editor_toolbott").height()
	// 		- parseInt($(".editor_toolsall").css("margin-top"))
	// 		- parseInt($(".editor_tooladd").css("margin-top"));
	//
	// $(".editor_imglistwrap").height(h);
	//
	// var w = $(document).width() - $(".border_listall").width() - $(".editor_tools").width() - parseInt($(".baseCanvas").css("padding-left")) - parseInt($(".baseCanvas").css("padding-right"));
	// $(".baseCanvas").width(w);
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
	addHistory();

	chkObject();
}






function Init(){
	applyDrag();
	InitCanvas(0);
	setCanvas(0);

	var nLoadIdx ;
	if($("#loadType").val() === 'load'){
		nLoadIdx = $("#nDataIdx").val();
	}else{
		nLoadIdx = $("#nLoadIdx").val();
	}

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

	// nCanvasWidth = objCanvas.getWidth();
	// nCanvasHeight = objCanvas.getHeight();


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



	var img = document.createElement('img');
	img.src = "/images/easycanvas/easycv_icon_rotate.png";

	fabric.Object.prototype.controls.mtr = new fabric.Control({
		x: 0,
		y: -0.5,
		offsetY: -40,
		cursorStyle: 'crosshair',
		actionHandler: fabric.controlsUtils.rotationWithSnapping,
		actionName: 'rotate',
		render: renderIcon,
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
		render: renderIcon,
		cornerSize: 34,
		withConnection: false
	});

	// here's where the render action for the control is defined
	function renderIcon(ctx, left, top, styleOverride, fabricObject) {
		var size = this.cornerSize;
		ctx.save();
		ctx.translate(left, top);
		ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
		ctx.drawImage(img, -size / 2, -size / 2, size, size);
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

	$.ajax({
		url : '/Canvas/getEzcvsData',
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

			if (data.success === true && data.blob !== ''){
				if(isFirst){
					reMakePage(data.blob);
				}else{
					var aJSON = data.blob.split("||");
					for (var idx=0;idx<aJSON.length;idx++ ){
						var json = JSON.parse(aJSON[idx]);

						//bg 경로 수정
						if(typeof json.backgroundImage === 'object'){
							if( json.backgroundImage.type === 'image' ){
								json.backgroundImage.src = json.backgroundImage.src.replace('http://www.edupre.co.kr','');
								json.backgroundImage.src = json.backgroundImage.src.replace('https://www.edupre.co.kr','');
							}
						}

						//content 경로 수정
						$.each(json.objects , function(k , r){
							if(json.objects[k].type === 'image'){
								json.objects[k].src = json.objects[k].src.replace('https://www.edupre.co.kr','');
								json.objects[k].src = json.objects[k].src.replace('http://www.edupre.co.kr','');
							}
						});

						addPage(json);
						aCanvas[idx].renderAll();
					}
				}
			}
		}

	});

}


function reMakePage(sData){
	resetAll();
	if (sData == '' || sData == null){
		addPage();
		return;
	}

	var aJSON = sData.split("||");
	for (var idx=0;idx<aJSON.length;idx++ ){

		var json = JSON.parse(aJSON[idx]);

		if(typeof json.backgroundImage === 'object'){
			if( json.backgroundImage.type === 'image' ){
				json.backgroundImage.src = json.backgroundImage.src.replace('http://www.edupre.co.kr','');
				json.backgroundImage.src = json.backgroundImage.src.replace('https://www.edupre.co.kr','');
			}
		}

		$.each(json.objects , function(k , r) {
			if(json.objects[k].type === 'image'){
				json.objects[k].src = json.objects[k].src.replace('https://www.edupre.co.kr','');
				json.objects[k].src = json.objects[k].src.replace('http://www.edupre.co.kr','');
			}
		});

		addPage(json);
		aCanvas[idx].renderAll();
	}

}

function addHistory(){

	if (nHistory < aHistory.length-1){
		for (var idx=nHistory;idx < aHistory.length-1 ; idx++){
			aHistory.pop();
		}
	}



	nHistory++;
	var json_data = JSON.stringify(oCanvas.toDatalessJSON());
	aHistory[nHistory] = new Object;
	aHistory[nHistory]["nCanvasNo"] = parseInt(nCurPageNo);
	aHistory[nHistory]["sCanvasData"] = json_data;

//	console.log(nHistory+"/"+aHistory.length);


	/*

        if (nHistory < aHistory.length-1){
            for (var idx=nHistory;idx < aHistory.length-1 ; idx++){
                aHistory.pop();
            }
        }

        nHistory++;
        var aJson = new Array;
        for (var idx=0;idx<aCanvas.length ;idx++ ){
            if (aCanvas[idx] != null){
                var json_data = JSON.stringify(aCanvas[idx].toDatalessJSON());
                aJson.push(json_data);
            }
        }
        var sCanvasData = aJson.join("||");
        aHistory[nHistory] = new Object;
        aHistory[nHistory]["nCanvasNo"] = parseInt(nCurPageNo);
        aHistory[nHistory]["sCanvasData"] = sCanvasData;

        console.log(nHistory+"/"+aHistory.length);
        console.log(aHistory);

    */

}



function procZoom(nZoom){
	nCurZoom = parseFloat(nZoom);

	$('.canvas-add-page').parent().css('width' , (nCanvasWidth*nCurZoom)+'px');

	$("input.btnZoomScale").val(nZoom*100);
	$(".wrapCanvas").width(nCanvasWidth*nZoom);
	$(".wrapCanvas").height(nCanvasHeight*nZoom);
	try{
		for (var idx=0;idx<aCanvas.length ;idx++ ){
			aCanvas[idx].setZoom(nZoom);
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
		fontSize: 30,
		padding:7,
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
	wrapCanvasHtml += '		<div class="d-flex flex-row align-items-center justify-content-between mb-2">';
	wrapCanvasHtml += '			<div class="d-flex align-items-center justify-content-center">';
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

$(document).on('click', '.mvScroll', function () {
	var idx;
	if ($(this).data('act') === 'up') { //페이지 up
		idx = parseInt($(this).data('idx')) - 1;
	} else {//페이지 다운
		idx = parseInt($(this).data('idx')) + 1;
	}
	mvScroll(idx);
});


function mvScroll(idx) {
	if ($('.canvas-page[data-idx="'+idx+'"]').length > 0 ){
		var target_t = parseInt($('.canvas-page[data-idx="'+idx+'"]').offset().top , 10);
		var curr_t = parseInt($('.canvas-scroll').scrollTop(), 10);
		var correction_val = 82
		target_t -= correction_val;

		$('.canvas-scroll').stop().animate({scrollTop:curr_t + target_t} , 100, 'swing');
	}
}

function mvScrollDown(curr_idx){
	var idx = parseInt(curr_idx)+1;
	if( $('.canvas-page[data-idx="'+idx+'"]').length > 0 ){
		var target_t = parseInt($('.canvas-page[data-idx="'+idx+'"]').offset().top , 10);
		var curr_t = parseInt($('.canvas-scroll').scrollTop(), 10);
		var correction_val = 82
		target_t -= correction_val;

		$('.canvas-scroll').stop().animate({scrollTop:curr_t + target_t} , 100, 'swing');
	}
}

function mvScrollUp(curr_idx){
	var idx = parseInt(curr_idx)-1;
	if( $('.canvas-page[data-idx="'+idx+'"]').length > 0 ){
		var target_t = parseInt($('.canvas-page[data-idx="'+idx+'"]').offset().top , 10);
		var curr_t = parseInt($('.canvas-scroll').scrollTop(), 10);
		var correction_val = 82
		target_t -= correction_val;

		$('.canvas-scroll').stop().animate({scrollTop:curr_t + target_t} , 100, 'swing');
	}
}

function resetPageNo() {

	$(".canvas-wrap .canvas-page").each(function (k , r) {
		var idx = k;
		var page_num = k+1;

		$(this).attr('data-idx' , idx).data('idx' , idx);

		var title_str =  $(this).find('div:eq(0) > div:eq(0) > span.canvas-title-str').text();

		var wrapCanvasHtml  = '';
		wrapCanvasHtml += '<span style="width: 70px;">'+page_num + '&nbsp;페이지</span>';

		$(this).find('div:eq(0) > div:eq(0)').html(wrapCanvasHtml);
		$(this).find('div:eq(0) > div:eq(1) > button[data-idx]').attr('data-idx' , idx).data('idx' , idx);
		$(this).find('#cvBase'+k).attr('id' , 'cvBase'+idx).attr('title' , idx);

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
	console.log('script func paste')
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
		var scaleX = parseFloat(nCurZoom);

		curObj[0].set({left: (oCanvas.width / scaleX) - (curObj[0].width * curObj[0].scaleX)});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
}



function procAlignCenter(){
	curObj = oCanvas.getActiveObjects();
	if (curObj.length){

		var scaleX = parseFloat(nCurZoom);

		curObj[0].set({left: ((oCanvas.width / scaleX) / 2) - ((curObj[0].width * curObj[0].scaleX) / 2)});

		oCanvas.renderAll();
		onUpdate();
		$(".objPopMenu").hide();
	}
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

	if(curObj.length == 1){//obj가 1개만 클릭

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

				$('.object-wrap').removeClass('d-flex').addClass('d-none');
				$('.contents-menu-wrap').addClass('d-flex').removeClass('d-none');

				if($('.contents-menu-wrap').data('type') != '_text'){
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
		$('.objFSize').val(30);
		$('#objCS').val(0);
		$('#objLH').val(1.16);
		//$('.objFF').val('Nanum Gothic');

		$('.contents-menu-wrap').addClass('d-flex').removeClass('d-none');
		$('.object-wrap').removeClass('d-flex').addClass('d-none');

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


function setBackgroundColor(color){
	clearBackground();
	oCanvas.setBackgroundColor(color, oCanvas.renderAll.bind(oCanvas));
	onUpdate();
}


function clearBackground(){
	const image = new fabric.Image('');
	oCanvas.setBackgroundImage(image, oCanvas.renderAll.bind(oCanvas));
	oCanvas.setBackgroundColor('', oCanvas.renderAll.bind(oCanvas));
	onUpdate();
}

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