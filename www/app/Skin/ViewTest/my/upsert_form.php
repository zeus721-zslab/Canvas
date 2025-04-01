<?php

/**
 * @var object $oUserInfo '회원정보'
 */

$cell_tel1=$cell_tel2=$cell_tel3 = '';
if($oUserInfo->cell_tel) list($cell_tel1,$cell_tel2,$cell_tel3) = explode('-',$oUserInfo->cell_tel);

?>

<main>
    <div class="container-fluid">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center">회원정보 수정</h1>
        </div>

        <form name="userModifyForm" id="userModifyForm" method="post" action="/My/modify">
            <?=csrf_field()?>
            <input type="hidden" name="user_email" value="">

            <div class="row mt-5 userForm ">

                <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex justify-content-end">
                    <label><span style="color: var(--logo-red);">*</span>필수입력사항</label>
                </div>

                <?php if($oUserInfo->sns_site < 1){ //sns 로그인 대상자가 아닌 경우 ?>
                    <!-- 아이디 -->
                    <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                        <label>아이디</label>
                        <div class="form-control-plaintext"><?=$oUserInfo->login_id?></div>
                    </div>

                    <!-- 비밀번호 -->
                    <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                        <label for="password"  class="require">비밀번호</label>
                        <input type="password" name="password" id="password" placeholder="비밀번호을 입력하세요." class="form-control" title="비밀번호" required>
                    </div>

                    <!-- 비밀번호 확인 -->
                    <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                        <label for="password_confirm" class="require">비밀번호 확인</label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="비밀번호 확인을 입력하세요." class="form-control" title="비밀번호 확인" required>
                    </div>
                <?php } else {?>
                    <input type="hidden" name="password" />
                    <input type="hidden" name="password_confirm" />
                <?php } ?>
                <!-- 이름 -->
                <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                    <label for="username" class="require">이름</label>
                    <input type="text" name="username" id="username" value="<?=$oUserInfo->username?>" placeholder="이름을 입력하세요." class="form-control" title="이름" required>
                </div>

                <!-- 이름 -->
                <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                    <label class="require">연락처</label>
                    <div class="d-flex gap-3">
                        <input type="number" value="<?=$cell_tel1?>" class="form-control" maxlenthCheck maxlength="3" onkeyup="moveFocus(this,3,'floatingCell_tel2Input')" id="floatingCell_tel1Input" name="cell_tel1" inputmode="text" autocomplete="cell_tel1" placeholder="연락처" title="연락처1" required>
                        <input type="number" value="<?=$cell_tel2?>" class="form-control" maxlenthCheck maxlength="4" onkeyup="moveFocus(this,4,'floatingCell_tel3Input')" id="floatingCell_tel2Input" name="cell_tel2" inputmode="text" autocomplete="cell_tel2" placeholder="연락처" title="연락처2" required>
                        <input type="number" value="<?=$cell_tel3?>" class="form-control" maxlenthCheck maxlength="4" id="floatingCell_tel3Input" name="cell_tel3" inputmode="text" autocomplete="cell_tel3" placeholder="연락처" title="연락처3" required>
                    </div>
                    <input type="hidden" name="cell_tel" value="">
                </div>

                <!-- 이메일 -->
                <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column gap-2">
                    <label for="email" class="require">이메일</label>
                    <input type="email" id="email" name="email"  placeholder="이메일을 입력하세요." class="form-control" title="이메일" value="<?=$oUserInfo->user_email?>">
                </div>


                <div class="col-10 offset-1 col-md-6 offset-md-3" >

                    <div class="p-3 d-flex flex-column gap-4 agree-wrap">

                        <!--
                        <div class="d-flex flex-column gap-2">
                            <label for="email_yn">이메일 수신동의</label>
                            <div class="main-checkbox sm">
                                <div class="round">
                                    <input type="checkbox" name="email_yn" id="email_yn" value="Y" title="" <?=$oUserInfo->email_yn == 'Y' ? 'checked':''?> />
                                    <label for="email_yn"></label>
                                </div>
                                <label for="email_yn" class="d-none d-md-inline-block fw-normal zs-cp">정보성 이메일에 대한 수신을 동의합니다.</label>
                                <label for="email_yn" class="d-inline-block d-md-none fw-normal">정보성 이메일에 대한 수신을 동의</label>
                            </div>

                        </div>

                        <div class="d-flex flex-column gap-2">
                            <label for="sms_yn">SMS 수신동의</label>
                            <div class="main-checkbox sm">
                                <div class="round">
                                    <input type="checkbox" name="sms_yn" id="sms_yn" value="Y" title="" <?=$oUserInfo->sms_yn == 'Y' ? 'checked':''?> />
                                    <label for="sms_yn"></label>
                                </div>
                                <label for="sms_yn" class="d-none d-md-inline-block fw-normal zs-cp">정보성 SMS에 대한 수신을 동의합니다.</label>
                                <label for="sms_yn" class="d-inline-block d-md-none fw-normal">정보성 SMS에 대한 수신을 동의</label>
                            </div>
                        </div>
                        -->
                        <div class="d-flex flex-column gap-2">
                            <label for="advert_yn">광고 수신동의</label>
                            <div class="main-checkbox sm">
                                <div class="round">
                                    <input type="checkbox" name="advert_yn" id="advert_yn" value="Y" title="" <?=$oUserInfo->advert_yn == 'Y' ? 'checked':''?> />
                                    <label for="advert_yn"></label>
                                </div>
                                <label for="advert_yn" class="d-none d-md-inline-block fw-normal zs-cp">광고에 대한 수신을 동의합니다.</label>
                                <label for="advert_yn" class="d-inline-block d-md-none fw-normal">광고에 대한 수신을 동의</label>
                            </div>
                            <?php if($oUserInfo->advert_yn == 'Y'){?>
                                <span class="fs-7 text-secondary" style="padding-left: 2rem;">광고 수신동의일 : <?=view_date_format($oUserInfo->advert_date)?></span>
                            <?php }?>
                        </div>

                    </div>
                </div>

                <div class="col-6 offset-3 col-lg-2 offset-lg-5 d-flex flex-column gap-2">
                    <button type="button" class="btn btn-black form_submit">회원정보 수정</button>
                </div>
                <div class="col-10 offset-1 col-md-6 offset-md-3 text-end" >
                    <button type="button" class="btn btn-danger memWithdraw">탈퇴하기</button>
                </div>

            </div>
        </form>
    </div>
</main>

<div id="popupWithdraw" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="popupWithdraw" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content ">

            <div class="modal-header">
                <h4 class="m-0">정말 회원 탈퇴하겠습니까? </h4>
            </div>
            <div class="modal-body fs-6"> 탈퇴 시, 계정 및 유료 이용 기간은 삭제되며 회원 서비스, 사용 이력이 복구되지 않습니다. </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#popupWithdraw').modal('hide');">닫기</button>
                <button type="button" class="btn btn-danger" onclick="onWithdraw();">탈퇴</button>
            </div>
        </div>
    </div>
</div>

<!-- JS Form -->
<?=link_src_html('/js/jquery.form.js','js') ?>

<form action="<?=route_to('My::withdraw')?>" id="frmWithdraw" name="frmWithdraw" method="post"></form>

<script type="text/javascript">

    function onWithdraw(){
        $('#frmWithdraw').submit();
    }
    function chkEmail(){

        $('[name="email"]').removeClass('is-valid').removeClass('is-invalid').parent().find('span').remove();

        var email = $('input[name="email"]').val();
        if(email === '') {
            return false;
        }

        $.ajax({
            type : 'post'
            ,   url  : '/My/check_email'
            ,   data : { email : email }
            ,   dataType : 'json'
            ,   success : function(result){
                var html = '';
                if(result.success === true){ //사용가능 이메일
                    html = '<span class="success valid-feedback">'+result.msg+'</span>';
                    $('[name="email"]').addClass('is-valid').parent().append(html);
                }else{
                    html = '<span class="error invalid-feedback">'+result.msg+'</span>';
                    $('[name="email"]').addClass('is-invalid').parent().append(html);
                }
            }
        });

    }
    $(function(){

        $('input[name="email"]').on( "blur", chkEmail );

        $('.memWithdraw').on('click',function(){

            var $modal = $('#popupWithdraw');
            $modal.modal({backdrop : 'static'});
            $modal.modal('show');

        })

        // $('input[name="sms_yn"]').on('change',function(){
        //     if( $(this).prop('checked') === true ){
        //         $('input[name="advert_yn"]').prop('checked' , true)
        //     }else if($('input[name="email_yn"]').prop('checked') === false) {
        //         $('input[name="advert_yn"]').prop('checked', false)
        //     }
        // });
        // $('input[name="email_yn"]').on('change',function(){
        //     if( $(this).prop('checked') === true ){
        //         $('input[name="advert_yn"]').prop('checked' , true)
        //     }else if($('input[name="sms_yn"]').prop('checked') === false){
        //         $('input[name="advert_yn"]').prop('checked' , false)
        //     }
        // });
        // $('input[name="advert_yn"]').on('change',function(){
        //     $('input[name="sms_yn"]').prop('checked',$(this).prop('checked'));
        //     $('input[name="email_yn"]').prop('checked',$(this).prop('checked'));
        // });

        var errors = '<?=session('errors')?>';
        if(errors !== '') alert(errors);

        $('#userModifyForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result) {
                $('input[name="_csrf"]').val(result.csrf);
                if(result.msg) alert(result.msg);

                //validation msg
                if(result.error_msg){
                    $.each(result.error_msg , function(k,v){
                        var html = '<span class="error invalid-feedback">'+v+'</span>';
                        $('[name="'+k+'"]').addClass('is-invalid').parent().append(html);
                    })
                }

                if(result.success) location.href = '<?=route_to('My::index','info')?>';
            }
        });


        $('.form_submit').on('click',function(e){
            e.preventDefault();

            var     celltel1 = $('input[name="cell_tel1"]')
                ,   celltel2 = $('input[name="cell_tel2"]')
                ,   celltel3 = $('input[name="cell_tel3"]');


            if( celltel1.val() === '' ){
                alert('연락처를 입력해주세요.');
                celltel1.focus();
                return false;
            }
            if( celltel1.val().length !== 3 ){
                alert('연락처를 확인해주세요');
                celltel1.focus();
                return false;
            }

            if( celltel2.val() === '' ){
                alert('연락처를 입력해주세요.');
                celltel2.focus();
                return false;
            }
            if( celltel2.val().length < 3 || celltel2.val().length > 4){
                alert('연락처를 확인해주세요');
                celltel2.focus();
                return false;
            }

            if( celltel3.val() === '' ){
                alert('연락처를 입력해주세요.');
                celltel3.focus();
                return false;
            }
            if( celltel3.val().length !== 4){
                alert('연락처를 확인해주세요');
                celltel3.focus();
                return false;
            }

            var cellTel = celltel1.val()+'-'+celltel2.val()+'-'+celltel3.val();
            $('input[name="cell_tel"]').val(cellTel);
            $('input[name="user_email"]').val($('input[name="email"]').val());

            $('form[name="userModifyForm"]').submit();

        });

    });
</script>




