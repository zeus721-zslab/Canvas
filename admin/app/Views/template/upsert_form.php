<?php
$encrypter = \Config\Services::encrypter();
$strEnc = sprintf("%s_template_0_%s",date('YmdHis'),$data["template_id"]);
$sEnc = urlencode($encrypter->encrypt($strEnc));

$aKeyword = [];
if ($data['keyword']) $aKeyword = explode(',', $data['keyword']); //키워드
?>
<div id="upsertFormModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/TemplateManagement/upsert" method="post" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <input type="hidden" name="template_id" value="<?=$data['template_id']?>">
                    <input type="hidden" name="save_type" value="form">
                    <input type="hidden" name="keyword" value="">

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 제목</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="title" class="form-control form-control-border" placeholder="제목" value="<?=$data['title']?>" title="title" autocomplete="off" />
                        </div>
                    </div>

                    <?php if($data['rotate']){?>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label>형태</label>
                        </div>
                        <div class="col-md-10 d-flex align-items-center justify-content-start">
                            <?php if($data['rotate'] == 'L'){?>
                                가로형
                            <?php }else if($data['rotate'] == 'P'){?>
                                세로형
                            <?php }else if($data['rotate'] == 'S'){?>
                                정사각형
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>


                    <?php if($isUpdate){?>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 사용여부</label>
                        </div>
                        <div class="col-md-10 ">
                            <select name="use_flag" class="form-control" title>
                                <option value="Y" <?php if($data['use_flag'] == 'Y'){?>selected<?php }?>>사용함</option>
                                <option value="I" <?php if($data['use_flag'] == 'I'){?>selected<?php }?>>작성중</option>
                                <option value="N" <?php if($data['use_flag'] == 'N'){?>selected<?php }?>>사용안함</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label>기타</label>
                        </div>
                        <div class="col-md-10 d-flex align-items-center justify-content-start gap-2">
                            <span> 사용 횟수 : <?=number_format($data['hit'])?>회</span>
                            <span>/</span>
                            <span> 총 : <?=number_format($data['page'])?>페이지</span>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end" style="height: 38px">
                            <label>미리보기</label>
                        </div>
                        <div class="col-md-3 d-flex flex-column gap-2">
                            <?php if($data['thumb_file']){?>
                                <img src="<?=$data['thumb_file']?>" alt class="img-thumbnail bg-light" />
                                <a href="/Canvas?e=<?=$sEnc?>" target="_blank" role="button" class="goUpsertTemplate btn btn-primary btn-xs" >수정하러가기</a>
                            <?php }else{ ?>
                                <a href="/Canvas?e=<?=$sEnc?>" target="_blank" role="button" class="goUpsertTemplate btn btn-primary btn-xs" >등록하러가기</a>
                            <?php } ?>
                        </div>
                    </div>

                    <?php } ?>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 유/무료</label>
                        </div>
                        <div class="col-md-10 ">
                            <select name="paid_yn" class="form-control" title>
                                <option value="Y" <?php if($data['paid_yn'] == 'Y' || $data['paid_yn'] == ''){?>selected<?php }?>>유료</option>
                                <option value="N" <?php if($data['paid_yn'] == 'N'){?>selected<?php }?>>무료</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label>키워드</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="keyword_str" class="form-control form-control-border" placeholder="키워드를 입력하고 엔터를 눌러주세요!" value="" title="input keyword" autocomplete="off" />
                        </div>
                        <div class="offset-2 col-md-10 keywordList gap-1 flex-wrap d-flex">
                            <?php if(!empty($aKeyword)){?>
                                <?php foreach ($aKeyword as $v) {?>
                                    <button type="button" class="btn btn-info text-white fs-7 py-1 pb-1 pt-2 mt-2"  data-val="<?=$v?>"><?=$v?></button>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div class="offset-2 col-md-10 keywordList-callout-wrap <?php if(empty($aKeyword)){ ?>d-none<?php }?>">
                            <p class="callout callout-danger fs-8 py-2 mb-0 mt-2 pb-1 pt-2">&middot;&nbsp;키워드를 클릭하시면 기존 키워드를 제거할 수 있습니다.<br>&middot;&nbsp;키워드 변경 > 저장 후 반영이 됩니다.</p>
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


