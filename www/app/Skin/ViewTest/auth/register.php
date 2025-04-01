<?php
$cell_tel1 = $cell_tel2 = $cell_tel3 = '';
if(old('cell_tel')) list($cell_tel1,$cell_tel2,$cell_tel3) = explode('-',old('cell_tel'));
?>
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

            <form action="<?= url_to('register') ?>" method="post" onsubmit="return validFrm();">
                <?=csrf_field()?>
                <input type="hidden" name="user_email" value="">

                <div class="mt-5 userForm">

                    <div class="d-flex justify-content-end">
                        <label><span style="color: var(--logo-red);">*</span>&nbsp;&nbsp;필수입력사항</label>
                    </div>

                    <!-- 아이디 -->
                    <div class="d-flex flex-column gap-2">
                        <label class="require" for="login_id">아이디</label>
                        <input type="text" value="<?=old('login_id')?>" name="login_id" id="login_id" placeholder="아이디를 입력하세요." class="form-control" title="아이디" required>
                    </div>

                    <!-- 이메일 -->
                    <div class="d-flex flex-column gap-2">
                        <label for="email" class="require">이메일</label>
                        <input type="email" id="email" name="email" placeholder="이메일을 입력하세요." class="form-control" title="이메일" value="<?=old('email')?>">
                    </div>

                    <!-- 비밀번호 -->
                    <div class="d-flex flex-column gap-2">
                        <label for="password" class="require">비밀번호</label>
                        <input type="password" name="password" id="password" placeholder="비밀번호을 입력하세요." class="form-control" title="비밀번호" required>
                    </div>

                    <!-- 비밀번호 확인 -->
                    <div class="d-flex flex-column gap-2">
                        <label for="password_confirm" class="require">비밀번호 확인</label>
                        <input type="password" name="password_confirm" id="password_confirm" placeholder="비밀번호 확인을 입력하세요.(비밀번호는 8자 이상이어야 합니다.)" class="form-control" title="비밀번호 확인" required>
                    </div>

                    <!-- 이름 -->
                    <div class="d-flex flex-column gap-2">
                        <label for="username" class="require">이름</label>
                        <input type="text" name="username" id="username" value="<?=old('username')?>" placeholder="이름을 입력하세요." class="form-control" title="이름" required>
                    </div>

                    <!-- 연락처 -->
                    <div class="d-flex flex-column gap-2">
                        <label class="require">연락처</label>
                        <div class="d-flex gap-3">
                            <input type="number" value="<?=$cell_tel1?>" class="form-control" maxlenthCheck maxlength="3" onkeyup="moveFocus(this,3,'floatingCell_tel2Input')" id="floatingCell_tel1Input" name="cell_tel1" inputmode="text" autocomplete="cell_tel1" placeholder="연락처" title="연락처1" required>
                            <input type="number" value="<?=$cell_tel2?>" class="form-control" maxlenthCheck maxlength="4" onkeyup="moveFocus(this,4,'floatingCell_tel3Input')" id="floatingCell_tel2Input" name="cell_tel2" inputmode="text" autocomplete="cell_tel2" placeholder="연락처" title="연락처2" required>
                            <input type="number" value="<?=$cell_tel3?>" class="form-control" maxlenthCheck maxlength="4" id="floatingCell_tel3Input" name="cell_tel3" inputmode="text" autocomplete="cell_tel3" placeholder="연락처" title="연락처3" required>
                        </div>
                        <input type="hidden" name="cell_tel" value="">
                    </div>

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

        $('#all_yn').on('click',function(){
           var bool = $(this).prop('checked');
           $('.agree-wrap input[type="checkbox"]').prop('checked',bool);
        });

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

    function chkLoginID(){

        $('[name="login_id"]').removeClass('is-valid').removeClass('is-invalid').parent().find('span').remove();

        var login_id = $('input[name="login_id"]').val();
        if(login_id === '') {
            return false;
        }

        $.ajax({
                type : 'post'
            ,   url  : '/register/check_value'
            ,   data : { login_id : login_id }
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

        return true;

    }

</script>

