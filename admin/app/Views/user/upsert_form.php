<?php
/**
 * @var array $data '회원정보' 
 * @var string $title '모달 제목'
 * @var bool $isUpdate '업데이트 여부'
 * @var bool $isAbleSSO 'SSO 가능여부'
 *
 ***/

$celltel1=$celltel2=$celltel3= '';
if( $data['cell_tel'] ) list($celltel1,$celltel2,$celltel3) = explode('-',$data['cell_tel']);
?>

<?=link_src_html('/plugins/moment/moment.min.js' , 'js')?>
<?=link_src_html('/plugins/moment/locale/ko.js' , 'js')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.css' , 'css')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.js' , 'js')?>

<div id="upsertFormModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/UserManagement/upsert" method="post" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <input type="hidden" name="id" value="<?=$data['id']?>">

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><?php if(!$isUpdate){?><i title="필수입력" class="nav-icon far fa-circle text-danger"></i><?php } ?>아이디</label>
                        </div>
                        <div class="col-md-10">
                            <?php if(!$isUpdate){?>
                                <input type="text" name="login_id" class="form-control form-control-border" placeholder="아이디" value="" title="login_id" autocomplete="off" />
                            <?php } else {?>
                                <span class="form-control-plaintext d-flex justify-content-between">
                                    <span><?=$data['login_id']?></span>
                                    <?php if($isAbleSSO){?>
                                    <a role="button" class="btn btn-xs btn-danger" href="https://www.kindercanvas.co.kr/auth/a/verify?login_id=<?=$data['login_id']?>" target="_blank" >로그인</a>
                                    <?php }?>
                                </span>
                            <?php }?>
                        </div>
                    </div>
                    
                    <?php if($data['sns_site'] == 0){//회원가입이 sns인 경우 비밀번호 변경 불가  ?>
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
                    <?php }?>
                    
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
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 연락처</label>
                        </div>
                        <div class="col-md-10 d-flex gap-2">
                            <input type="number" value="<?=$celltel1?>" class="form-control" maxlenthCheck maxlength="3" onkeyup="moveFocus(this,3,'floatingCell_tel2Input')" id="floatingCell_tel1Input" name="cell_tel1" inputmode="text" autocomplete="cell_tel1" placeholder="연락처" title="연락처1" required>
                            <input type="number" value="<?=$celltel2?>" class="form-control" maxlenthCheck maxlength="4" onkeyup="moveFocus(this,4,'floatingCell_tel3Input')" id="floatingCell_tel2Input" name="cell_tel2" inputmode="text" autocomplete="cell_tel2" placeholder="연락처" title="연락처2" required>
                            <input type="number" value="<?=$celltel3?>" class="form-control" maxlenthCheck maxlength="4" id="floatingCell_tel3Input" name="cell_tel3" inputmode="text" autocomplete="cell_tel3" placeholder="연락처" title="연락처3" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 이메일</label>
                        </div>
                        <div class="col-md-10">
                            <input type="email" name="email" class="form-control form-control-border" placeholder="이메일" value="<?=$data['user_email']?>" title="user_email" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 상태</label>
                        </div>
                        <div class="col-md-10">

                            <?php if(!$data['deleted_at']){?>
                                <span class="text-primary">정상</span>
                            <?php }else {?>
                                <span class="text-danger">탈퇴</span>
                                <br>
                                <span class="text-danger"><?=$data['deleted_at']?></span>
                            <?php }?>

                            <!--
                            <select class="form-control" title="active" name="active">
                                <option value="1" <?=$data['active'] ? 'selected': '' ?>>정상</option>
                                <option value="0" <?=!$data['active'] ? 'selected': '' ?>>탈퇴</option>
                            </select>
                            -->
                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label>이용기간</label>
                        </div>
                        <div class="col-md-10 d-flex gap-2">
                            <div class="input-group date w-25" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="s_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?=view_date_format($data['s_use_date'],5)?>">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;" ><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <span class="d-flex align-items-center">~</span>
                            <div class="input-group date w-25" id="reservationdate" data-target-input="nearest">
                                <input type="text" name="e_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?=view_date_format($data['e_use_date'],5)?>">
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;" ><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-info btn-xs add-1year" data-target="s_use_date|e_use_date">1년추가</button>
                            <button type="button" class="btn btn-info btn-xs add-6month" data-target="s_use_date|e_use_date">6개월추가</button>

                        </div>

                    </div>

                    <?php if($isUpdate){?>

                        <div class="row mb-3 ">
                            <div class="col-md-2 d-flex align-items-center justify-content-end">
                                <label>메모</label>
                            </div>
                            <div class="col-md-10 d-flex gap-2">
                                <textarea name="memo" rows="6" class="form-control"><?=$data['memo']?></textarea>
                            </div>
                        </div>



                    <?php } ?>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#upsertFormModal').modal('hide');">닫기</button>
                <button type="button" class="btn btn-primary" onclick="fn_UpsertForm();">저장</button>
            </div>

        </div>
    </div>
</div>


<script>moment.locale('ko');</script>
<script type="text/javascript">

    $(function(){

        $('.datetimepicker-input').daterangepicker({
            autoclose: true,
            singleDatePicker: true,
            autoUpdateInput: false,
            changeYear: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: '취소',
                applyLabel:'확인'
            }
        });

        $('input[name="s_use_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="e_use_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

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
            , error : function (request,status,error){
                alert("처리 중 문제가 발생하였습니다\n다시시도해주세요.");
                // location.reload();
            }
        });

        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

    });

</script>


