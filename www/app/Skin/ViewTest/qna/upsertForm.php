<?php
/**
 * @var array $aInfo '1:1문의 정보'
 */

?>
<style>
table{width: 90%;}
th{width: 20%}
@media (min-width: 992px) {
    table{width: 75% !important;}
    th{width: 10%}
}
</style>
<main>
    <div class="container-fluid w-1560 d-flex flex-column align-items-center board-wrap">
        <div class="d-flex flex-column justify-content-center mb-4">
            <div class="mb-5">
                <h1 class="text-center">1:1 문의하기</h1>
            </div>
        </div>
        <form id="upsertForm" name="upsertForm" method="post" action="/Qna/upsert" class="w-100" onsubmit="return form_valid();">
            <input type="hidden" name="id" value="<?=$aInfo['qna_id']?>">
            <div class="w-100 d-flex align-items-center flex-column">

                <table class="table table-bordered">
                    <tr>
                        <th class="bg-main text-center" >제목</th>
                        <td> <input type="text" class="form-control" title="title" name="title" value="<?=$aInfo['title']?>" style="border-radius: 0;" /> </td>
                    </tr>
                    <tr>
                        <th class="bg-main text-center" >문의내용</th>
                        <td colspan="2" class="content" style="min-height: 150px;vertical-align: top">
                            <textarea name="content" class="form-control" rows="12" title="content" style="border-radius: 0;"><?=$aInfo['content']?></textarea>
                        </td>
                    </tr>
                </table>
                <div class="d-flex justify-content-center w-100 gap-5">
                    <button type="submit" class="btn px-4 upsert" style="background-color: var(--lightbrown-color);color:#fff;border-radius: 0">등록하기</button>
                    <button type="button" class="btn px-4 history-back" style="border-radius: 0">목록으로 가기</button>
                </div>
            </div>
        </form>
    </div>
</main>
<?=csrf_field()?>

<!-- JS Form -->
<?=link_src_html('/js/jquery.form.js','js') ?>
<script type="text/javascript">

    function form_valid(){
        if( $('input[name="title"]').val() === '' ){
            alert('제목을 입력해주세요');
            $('input[name="title"]').focus();
            return false;
        }
        if( $('textarea[name="content"]').val() === '' ){
            alert('내용을 입력해주세요');
            $('textarea[name="content"]').focus();
            return false;
        }
    }

    $(function(){

        $('input,textarea').on('focus',function(){
            $(this).removeClass('is-invalid').removeClass('is-valid');
        });

        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            cache: false,
            success : function(result, status) {
                $('input[name="_csrf"]').val(result.csrf);

                //validation msg
                if(result.error_msg){
                    $.each(result.error_msg , function(k,v){
                        var html = '<span class="error invalid-feedback">'+v+'</span>';
                        $('[name="'+k+'"]').addClass('is-invalid').parent().append(html);
                    })
                }
                if(result.msg) alert(result.msg);
                if(result.success) location.href = "<?=route_to('Qna::index')?>";
            }
        });

        $('.history-back').on('click',function(){
            history.back();
        });
    });

</script>
