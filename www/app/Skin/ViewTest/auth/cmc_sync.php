<?php

/**
 * @var array $aInfo '꼬망세 회원 정보'
 * @var array $is '입력 필요 항목' ['email' => $isEmail , 'id' => $isID]
 * @var string $KAKAO_REQUEST_URL '카카오시작하기 URL'
 *
 **/


?>
<style>
    .main-color {color:var(--bs-danger)}
</style>
<div class="container d-flex justify-content-center py-5 px-md-5">

    <div class="card col-11 col-md-6 border-0 ">
        <div class="card-body">

            <div class="main-title border-bottom">
                <a href="/" class="d-flex justify-content-center mb-3"><img src="/img/kinder_logo.png" alt="" style="width: 60%; "/></a>
                <p class="text-center m-0">킨더캔버스를 방문해 주셔서 감사합니다.</p>
                <p class="text-center">회원가입을 통해 편리한 이용과<br>다양한 혜택을 받아보세요.</p>
            </div>

            <?php if (session('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
            <?php endif ?>

            <?php if($KAKAO_REQUEST_URL){ //꼬망세 카카오 로그인을 사용하는 사람인 경우 ?>

                <div class="d-flex justify-content-center">
                    <a href="<?=$KAKAO_REQUEST_URL?>" class="d-inline-block w-75" style="padding:5rem 0 ">
                        <img src="/images/sns_login/kakao_login_large_wide.png" alt="카카오로그인" class="w-100">
                    </a>
                </div>
            <?php } else { // 일반회원?>

                <form action="/register/cmc" method="post" onsubmit="return validFrm();">
                    <?=csrf_field()?>
                    <input type="hidden" name="user_email" value="<?=$aInfo['vcEmail']?>">
                    <input type="hidden" name="s_use_date" value="<?=$aInfo['s_use_date']?>">
                    <input type="hidden" name="e_use_date" value="<?=$aInfo['e_use_date']?>">
                    <input type="hidden" name="cmc_vcID" value="<?=$aInfo['vcID']?>">

                    <div class="mt-5 userForm">

                        <div class="d-flex justify-content-end">
                            <label><span style="color: var(--logo-red)">*</span>&nbsp;&nbsp;필수입력사항</label>
                        </div>

                        <?php if($aInfo['scd']){ $str_year = $aInfo['scd'] == 12 ? '1년' : '2년';//scd가 있는 경우, 기간설정에 대한 noti ?>
                            <div class="alert alert-success" role="alert">
                                회원연동 시 <b><?=$str_year?></b> 기간이 자동 설정됩니다.
                            </div>
                        <?php } ?>


                        <!-- 아이디 -->
                        <?php if($is['id']){?>
                            <div class="d-flex flex-column gap-2">
                                <label class="require" for="login_id">아이디</label>
                                <input type="text" value="<?=$aInfo['vcID']?>" name="login_id" id="login_id" placeholder="아이디를 입력하세요." class="form-control is-invalid" title="아이디" required autocomplete="off">
                                <span class="error invalid-feedback">같은 아이디이(가) 존재합니다.</span>
                            </div>
                        <?php } else {?>
                            <input type="hidden" name="login_id" value="<?=$aInfo['vcID']?>">
                        <?php }?>

                        <!-- 이메일 -->
                        <?php if($is['email']){?>
                            <div class="d-flex flex-column gap-2">
                                <label for="email" class="require">이메일</label>
                                <input type="email" id="email" name="email" placeholder="이메일을 입력하세요." class="form-control is-invalid" title="이메일" value="<?=$aInfo['vcEmail']?>" autocomplete="off">
                                <span class="error invalid-feedback">같은 이메일이(가) 존재합니다.</span>
                            </div>
                        <?php } else {?>
                            <input type="hidden" name="email" value="<?=$aInfo['vcEmail']?>">
                        <?php }?>
                        <!-- 비밀번호 -->
                        <div class="d-flex flex-column gap-2">
                            <label for="password" class="require">비밀번호</label>
                            <input type="password" name="password" id="password" placeholder="비밀번호을 입력하세요.(비밀번호는 8자 이상이어야 합니다.)" class="form-control" title="비밀번호" required autocomplete="off">
                        </div>

                        <!-- 비밀번호 확인 -->
                        <div class="d-flex flex-column gap-2">
                            <label for="password_confirm" class="require">비밀번호 확인</label>
                            <input type="password" name="password_confirm" id="password_confirm" placeholder="비밀번호 확인을 입력하세요." class="form-control" title="비밀번호 확인" required>
                        </div>

                        <!-- 이름 -->
                        <input type="hidden" name="username" value="<?=$aInfo['vcName']?>" >
                        <!-- 연락처 -->
                        <input type="hidden" name="cell_tel" value="<?=$aInfo['vcMobile']?>">

                        <!-- 수신동의 -->
                        <div class="p-md-3 d-flex flex-column gap-4 agree-wrap p-2 mb-5">

                            <div class="main-checkbox">
                                <div class="round">
                                    <input type="checkbox" id="all_yn" />
                                    <label for="all_yn"></label>
                                </div>
                                <label for="all_yn" class="fs-5 zs-cp">전체 동의합니다.</label>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between">
                                    <label for="cmc_sync_yn">꼬망세 회원 연동 약관&nbsp;<span class="fs-7" style="color: var(--gray-color);">(필수)</span></label>
                                    <a role="button" onclick="$('#popupCmcSyncAgreeContents').modal('show');" class="d-flex align-items-center main-color fs-7" style="color: var(--gray-color);">약관보기&nbsp;<i class="fa-solid fa-angle-right" style="padding-top: 2px;"></i></a>
                                </div>
                                <div class="main-checkbox sm">
                                    <div class="round">
                                        <input type="checkbox" name="cmc_sync_yn" id="cmc_sync_yn" value="Y" title="" <?=old('cmc_sync_yn') == 'Y' ? 'checked':''?> />
                                        <label for="cmc_sync_yn"></label>
                                    </div>
                                    <label for="cmc_sync_yn" class="d-none d-md-inline-block fw-normal zs-cp">연동약관에 동의합니다.</label>
                                    <label for="cmc_sync_yn" class="d-inline-block d-md-none fw-normal">연동약관에 동의</label>
                                </div>

                            </div>

                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between">
                                    <label for="term_yn">이용약관&nbsp;<span class="fs-7" style="color: var(--gray-color);">(필수)</span></label>
                                    <a href="/termOfUs" class="d-flex align-items-center fs-7" style="color: var(--gray-color);" target="_blank">약관보기&nbsp;<i class="fa-solid fa-angle-right" style="padding-top: 2px;"></i></a>
                                </div>
                                <div class="main-checkbox sm">
                                    <div class="round">
                                        <input type="checkbox" name="term_yn" id="term_yn" value="Y" title="" <?=old('term_yn') == 'Y' ? 'checked':''?> />
                                        <label for="term_yn"></label>
                                    </div>
                                    <label for="term_yn" class="d-none d-md-inline-block fw-normal zs-cp">이용약관에 동의합니다.</label>
                                    <label for="term_yn" class="d-inline-block d-md-none fw-normal">이용약관에 동의</label>
                                </div>

                            </div>

                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between">
                                    <label for="privacy_yn">개인정보 처리방침&nbsp;<span class="fs-7" style="color: var(--gray-color);">(필수)</span></label>
                                    <a href="/privacy" class="d-flex align-items-center fs-7" style="color: var(--gray-color);" target="_blank">개인정보 처리 방침 보기&nbsp;<i class="fa-solid fa-angle-right" style="padding-top: 2px;"></i></a>
                                </div>
                                <div class="main-checkbox sm">
                                    <div class="round">
                                        <input type="checkbox" name="privacy_yn" id="privacy_yn" value="Y" title="" <?=old('privacy_yn') == 'Y' ? 'checked':''?> />
                                        <label for="privacy_yn"></label>
                                    </div>
                                    <label for="privacy_yn" class="d-none d-md-inline-block fw-normal zs-cp">개인정보 수집&middot;이용에 동의합니다.</label>
                                    <label for="privacy_yn" class="d-inline-block d-md-none fw-normal">개인정보 수집&middot;이용에 동의</label>
                                </div>
                            </div>

                            <!--
                        <div class="d-flex flex-column gap-2">
                            <label for="email_yn">이메일 수신</label>

                            <div class="main-checkbox sm">
                                <div class="round">
                                    <input type="checkbox" name="email_yn" id="email_yn" value="Y" title="" <?=old('email_yn') == 'Y' ? 'checked':''?> />
                                    <label for="email_yn"></label>
                                </div>
                                <label for="email_yn" class="d-none d-md-inline-block fw-normal zs-cp">정보성 이메일에 대한 수신을 동의합니다.</label>
                                <label for="email_yn" class="d-inline-block d-md-none fw-normal">정보성 이메일에 대한 수신을 동의</label>
                            </div>

                        </div>

                        <div class="d-flex flex-column gap-2">
                            <label for="sms_yn">SMS 수신</label>
                            <div class="main-checkbox sm">
                                <div class="round">
                                    <input type="checkbox" name="sms_yn" id="sms_yn" value="Y" title="" <?=old('sms_yn') == 'Y' ? 'checked':''?> />
                                    <label for="sms_yn"></label>
                                </div>
                                <label for="sms_yn" class="d-none d-md-inline-block fw-normal zs-cp">정보성 SMS에 대한 수신을 동의합니다.</label>
                                <label for="sms_yn" class="d-inline-block d-md-none fw-normal">정보성 SMS에 대한 수신을 동의</label>
                            </div>
                        </div>
                        -->
                            <div class="d-flex flex-column gap-2">
                                <label for="advert_yn">광고 수신</label>
                                <div class="main-checkbox sm">
                                    <div class="round">
                                        <input type="checkbox" name="advert_yn" id="advert_yn" value="Y" title="" <?=old('advert_yn') == 'Y' ? 'checked':''?> />
                                        <label for="advert_yn"></label>
                                    </div>
                                    <label for="advert_yn" class="d-none d-md-inline-block fw-normal zs-cp">광고에 대한 수신을 동의합니다.</label>
                                    <label for="advert_yn" class="d-inline-block d-md-none fw-normal">광고에 대한 수신을 동의</label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-4">
                        <button type="submit" class="btn btn-gray btn-block"><?= lang('Auth.register') ?></button>
                        <p class="text-center"><?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>
                    </div>

                </form>

            <?php }?>



        </div>
    </div>
</div>

<div id="popupCmcSyncAgreeContents" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="popupCmcSyncAgreeContents" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content ">

            <div class="modal-header d-flex justify-content-between">
                <h4 class="modal-title m-0">꼬망세 회원 연동 약관</h4>
                <button type="button" style="border: none;background: #fff;font-size: 2rem;" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#popupCmcSyncAgreeContents').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body fs-6">
                <p class="mb-0">1. 회사는 회원의 동의를 받아 회원이 보유하고 있는 개인정보를 "킨더 캔버스"에 제공할 수 있습니다.</p>
                <p class="mb-0">- 제공되는 정보</p>
                <p class="mb-0">아이디</p>
                <p class="mb-0">이름</p>
                <p class="mb-0">휴대폰 번호</p>
                <p>이메일 주소</p>
                <p>2. 이전되는 정보는 "킨더 캔버스"에 한정되어 저장된다.</p>
                <p>3. 회사는 서비스 제공으로 알게 된 회원의 신상정보를 본인의 동의 없이 제3자에게 누설, 배포하지 않습니다.</p>
                <p>4. 회사는 회원의 전체 또는 일부 정보를 업무와 관련된 통계 자료로 사용할 수 있습니다.</p>
                <p>5. 회사는 양질의 서비스를 제공하기 위해 여러 비즈니스 파트너와 제휴를 맺어 회원 정보를 위탁관리 하게 할 수 있습니다.<br>그럴 경우 회사는 약관에 위탁관리 업체명 및 목적, 내용을 밝혀 회원의 동의를 받습니다.<br>자세한 개인정보 위탁관리 업체는 개인정보 취급 방침에서 확인하실 수 있습니다.</textarea></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#popupCmcSyncAgreeContents').modal('hide');">닫기</button>
            </div>
        </div>
    </div>
</div>
<!-- jquery   -->
<?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>

<script type="text/javascript">

    $(function(){

        $('input[name="login_id"]').on('keyup keydown',function(e){
            if(e.keyCode === 13){
                if(e.type === 'keydown') e.preventDefault();
                else chkLoginID();
            }
        });

        $('input').on( "focus", function() {
            $(this).removeClass('is-valid').removeClass('is-invalid').parent().find('span').remove();
        });

        $('input[name="login_id"]').on( "blur", chkLoginID );
        $('input[name="email"]').on( "blur", chkEmail );


        <?php
        if(is_array(session('errors'))){
        foreach (session('errors') as $k => $msg) {
        ?>
        $('[name="<?=$k?>"]').addClass('is-invalid').parent().append('<span class="error invalid-feedback"><?=$msg?></span>');
        <?php
        }
        }
        ?>

        // $('#sms_yn').on('change',function(){
        //     if( $(this).prop('checked') === true ) {
        //         $('#advert_yn').prop('checked',true)
        //     }else{
        //         if($('#email_yn').prop('checked') === false ){
        //             $('#advert_yn').prop('checked',false)
        //         }
        //     }
        // });
        // $('#email_yn').on('change',function(){
        //     if( $(this).prop('checked') === true ) {
        //         $('#advert_yn').prop('checked',true)
        //     }else{
        //         if($('#sms_yn').prop('checked') === false ){
        //             $('#advert_yn').prop('checked',false)
        //         }
        //     }
        // });
        // $('#advert_yn').on('change',function(){
        //     var b = $(this).prop('checked');
        //     $('#email_yn').prop('checked' , b);
        //     $('#sms_yn').prop('checked' , b);
        // });


        $('#all_yn').on('click',function(){
            var bool = $(this).prop('checked');
            $('.agree-wrap input[type="checkbox"]').prop('checked',bool);
        });

        <?php if(!isTest()){?>
        window.history.replaceState({} , '', window.location.pathname);//querystring 제거
        <?php }?>

    });

    function chkEmail(){

        $('[name="email"]').removeClass('is-valid').removeClass('is-invalid').parent().find('span').remove();

        var email = $('input[name="email"]').val();
        if(email === '') {
            return false;
        }

        $.ajax({
            type : 'post'
            ,   url  : '/register/check_value'
            ,   data : { email : email , check_type : 'cmc' }
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

    function chkLoginID(){

        $('[name="login_id"]').removeClass('is-valid').removeClass('is-invalid').parent().find('span').remove();

        var login_id = $('input[name="login_id"]').val();
        if(login_id === '') {
            return false;
        }

        $.ajax({
            type : 'post'
            ,   url  : '/register/check_value'
            ,   data : { login_id : login_id , check_type : 'cmc' }
            ,   dataType : 'json'
            ,   success : function(result){
                var html = '';
                if(result.success === true){ //사용가능 아이디
                    html = '<span class="success valid-feedback">'+result.msg+'</span>';
                    $('[name="login_id"]').addClass('is-valid').parent().append(html);
                }else{
                    html = '<span class="error invalid-feedback">'+result.msg+'</span>';
                    $('[name="login_id"]').addClass('is-invalid').parent().append(html);
                }
            }
        });

    }

    function validFrm(){

        if($('input[name="cmc_sync_yn"]:checked').val() !== 'Y'){
            alert('꼬망세 이용약관에 동의해주세요!');
            return false;
        }
        if($('input[name="term_yn"]:checked').val() !== 'Y'){
            alert('이용약관에 동의해주세요!');
            return false;
        }
        if($('input[name="privacy_yn"]:checked').val() !== 'Y'){
            alert('개인정보처리방침에 동의해주세요!');
            return false;
        }

        $('input[name="user_email"]').val($('input[name="email"]').val());
        return true;
    }


</script>

