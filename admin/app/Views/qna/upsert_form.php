
<?php
/**
 * @var array $data '회원정보'
 * @var array $aFileInfo '첨부파일 정보'
 * @var string $title '모달 제목'
 * @var bool $isUpdate '업데이트 여부'
 *
 ***/

?>
<style>.ck-editor__editable {min-height: 300px;}
    :root {
        --ck-z-default: 100;
        --ck-z-panel: calc( var(--ck-z-default) + 999 );
    }

</style>
<script> var editor; /* using main.js */ </script>
<script type="module" src="/plugins/ckeditor-bundle/main.js?<?=time()?>"></script>
<div id="upsertFormModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/QnaManagement/upsert" method="post">
                    <?=csrf_field()?>
                    <input type="hidden" name="id" value="<?=$data['qna_id']?>">

                    <div class="row mb-3 flex-column">
                        <div class="col-md-2 d-flex align-items-center ">제목</div>
                        <div class="col-md-12">
                            <input type="text" class="form-control w-100" disabled value="<?=$data['title']?>" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center ">문의</div>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="6" title="" disabled><?=$data['content']?></textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center ">답변</div>
                        <div class="col-md-12">
                            <textarea name="answer" id="ckeditor" class="form-control " placeholder="1:1문의 답변" title="1:1문의 답변" autocomplete="off"><?=$data['answer']?></textarea>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#upsertFormModal').modal('hide');">닫기</button>
                <button type="button" class="btn btn-primary" onclick="fn_UpsertForm();">저장</button>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">

    $(function(){

        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
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
                if(result.success){
                    //modal off
                    $('#upsertFormModal').modal('hide');
                    var msg = result.msg ? result.msg : '정상적으로 저장되었습니다.';
                    Toast.fire({
                        icon: 'success',
                        title: msg
                    });
                    getList(loc_page);
                }else if(result.msg) alert(result.msg);
            }
        });

        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

    });
</script>



