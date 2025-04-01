<?php
/**
 * @var array $data '회원정보' 
 * @var string $title '모달 제목'
 * @var bool $isUpdate '업데이트 여부'
 * @var bool $isAbleSSO 'SSO 가능여부'
 *
 ***/

?>

<div id="upsertFormModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/AdminManagement/upsert" method="post">
                    <?=csrf_field()?>
                    <input type="hidden" name="id" value="<?=$data['id']?>">

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><?php if(!$isUpdate){?><i title="필수입력" class="nav-icon far fa-circle text-danger"></i><?php } ?>아이디</label>
                        </div>
                        <div class="col-md-10">
                            <?php if(!$isUpdate){?>
                                <input type="email" name="email" class="form-control form-control-border" placeholder="아이디" value="" title="email" autocomplete="off" />
                            <?php } else {?>
                                <span class="form-control-plaintext">
                                    <span><?=$data['secret']?></span>
                                </span>
<!--                                <input type="hidden" name="email" value="--><?php //=$data['secret']?><!--">-->
                            <?php }?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><?php if(!$isUpdate){?><i title="필수입력" class="nav-icon far fa-circle text-danger"></i><?php } ?> 비밀번호</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="password" class="form-control form-control-border" placeholder="비밀번호" value="" title="password" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end fs-7">
                            <label><?php if(!$isUpdate){?><i title="필수입력" class="nav-icon far fa-circle text-danger"></i><?php } ?> 비밀번호 확인</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="password_confirm" class="form-control form-control-border" placeholder="비밀번호 확인" value="" title="password_confirm" autocomplete="off" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 이름</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="username" class="form-control form-control-border" placeholder="이름" value="<?=$data['username']?>" title="username" autocomplete="off" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 상태</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" title="active" name="active">
                                <option value="1" <?=$data['active'] == 1 ? 'selected': '' ?>  >정상</option>
                                <option value="0" <?=$data['active'] == 0 ? 'selected': '' ?>>비활성화</option>
                            </select>
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


