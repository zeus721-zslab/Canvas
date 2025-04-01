<div class="d-flex py-3 flex-column">

    <form name='frmImgUpload' id='frmImgUpload' method='POST' enctype='multipart/form-data' target='hiddenFrame' action='/Canvas/userUpload'>
        <div class="btn-wrap">
            <label for="upImgFile" role="button" class="w-100 btn btn-full btn-outline-success">업로드</label>
            <input type="file" name="upImgFile" id="upImgFile" class="file_input_hidden upImgFile invisible" accept="image/gif,image/jpg,image/jpeg,image/png"/>
        </div>
    </form>

</div>

<div class="ps-2 mb-2 w-100">
    <div>파일 (<span class="file_cnt"><?=count($aMyImg)?></span>)</div>
</div>

<div class="overflow-x-hidden scroll-ajax upload-file-wrap" data-act="category">

    <?php if(empty($aMyImg) == true){ //<!-- 업로드된 파일이 없는 경우   -->?>

        <div class="myimg-no-data d-flex align-items-center justify-content-center flex-column upload-context" style="margin-top: 8rem;">
            <div class="fa-4x"> <i class="fa-solid fa-cloud-arrow-up" style="color: rgba(0,0,0,0.3);"></i> </div>
            <div>
                <p style="font-weight: bold">파일을 업로드하세요</p>
                <p class="desc" style="font-size: .8rem;text-align: center">JPG, GIF, PNG</p>
            </div>
        </div>

    <?php } else { //<!--  업로드된 파일이 있는 경우  -->?>

        <div class="justified-gallery upload-file-list contents-list-container">
            <!--
            <?php foreach ($aMyImg as $r) {?>
                <a> <img src="<?=$r['image_file']?>" data-org_file="<?=$r['image_file']?>" data-w="<?=$r['w']?>" data-h="<?=$r['h']?>" class="objItemImg objItemImgMy canvas-img" /> </a>
            <?php } ?>
            -->
        </div>
    <?php }?>
</div>

<!-- result  -->
<div class="result-list-wrap" style="display: none;">
    <div class="justified-gallery"></div>
</div>

<script>

    $(function(){

        $('#frmImgUpload').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result, status) {
                $('input[name="_csrf"]').val(result.csrf);

                if(result.msg) alert(result.msg);
                if(result.success) print_my_img(result.data);

            }

        });
        var $scroll_ajax = $('.scroll-ajax');
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
        getLoadAjax($scroll_ajax.data('act'));

        //이미지 상하정렬
        $('.justified-gallery').justifiedGallery({
            rowHeight : 88,
            lastRow : 'nojustify',
            border : 0,
            margins : 15
        });

        applyDrag();
        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

    });

    function print_my_img(data){

        var html = '', wrap_html = '';

        if( $('.upload-file-list').length < 1 && $('.myimg-no-data').length > 0 ){

            $('.myimg-no-data').remove();

            wrap_html += '<div class="overflow-y-scroll overflow-x-hidden scroll-ajax" style="padding-right: 0.75rem;" data-act="category">';
            wrap_html += '<div class="justified-gallery upload-file-list contents-list-container"></div>';
            wrap_html += '</div>';

            $('.upload-file-wrap').append(wrap_html);

            //이미지 상하정렬
            $('.justified-gallery').justifiedGallery({
                rowHeight : 88,
                lastRow : 'nojustify',
                border : 0,
                margins : 15
            });

        }

        html += '<a>';
        html += '   <img data-paid_yn="N" src="'+data.image_file+'" data-org_file="'+data.image_file+'" data-w="'+data.w+'" data-h="'+data.h+'" class="objItemImg objItemImgMy canvas-img" /> ';
        html += '	<span class="myimg-delete" onclick="myupload_delete(\''+data.myimg_id+'\');">';
        html += '		<img src="/images/canvas_myimg_del.png" alt="" />';
        html += '	</span>';
        html += '</a>';

        $('.upload-file-list').append(html).justifiedGallery('norewind');

        $('.file_cnt').html($('.upload-file-list a').length);


    }

</script>
