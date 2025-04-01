<style>
    .form-control:read-only {
        background-color: var(--bs-secondary-bg);
        opacity: 1;
    }
    input{border-radius: 0!important;}
</style>

<div class="container d-flex justify-content-center py-5 px-md-5">

    <div class="card col-12 col-md-6 border-0">
        <div class="card-body">

            <div class="main-title border-bottom mb-2 ">
                <a href="/" class="d-flex justify-content-center mb-3"><img src="/img/kinder_logo.png" alt="" style="width: 60%; "/></a>
                <h2 class="text-center mt-5 mb-4">비밀번호 찾기</h2>
            </div>

            <div class="submit-alert d-none">
                <div class="d-flex col-12 offset-0 col-md-10 offset-md-1 mt-3">
                    <div class="alert alert-danger w-100" role="alert"></div>
                </div>
            </div>
            <div class="submit-success d-none">
                <div class="d-flex col-12 offset-0 col-md-10 offset-md-1 mt-3">
                    <div class="alert alert-success w-100 text-center" role="alert"></div>
                </div>
            </div>

            <div class="d-flex col-12 offset-0 col-md-10 offset-md-1 pt-4">
                <form id="find_id" action="<?=route_to('Find::process','pw')?>" method="post" class="w-100" >
                    <?= csrf_field() ?>
                    <input type="hidden" name="send_sms" value="N">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingIdInput" name="login_id" inputmode="login_id" autocomplete="login_id" placeholder="아이디" value="<?= old('login_id') ?>" required>
                        <label for="floatingIdInput">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" maxlength="11" maxlenthCheck class="form-control" id="floatingIdInput" name="cell_tel" inputmode="cell_tel" autocomplete="cell_tel" placeholder="휴대폰번호" value="<?= old('cell_tel') ?>" required>
                        <label for="floatingIdInput">휴대폰</label>
                    </div>

                    <div class="btn-group d-flex">
                        <button type="button" class="btn btn-black flex-grow-0 sendCertNumber">인증번호 전송</button>
                        <div class="form-floating flex-grow-1">
                            <input type="number" class="form-control" id="floatingIdInput" name="cert_num" inputmode="cert_num" autocomplete="cert_num" placeholder="인증번호" value="<?= old('cert_num') ?>" required>
                            <label for="floatingIdInput">인증번호</label>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-gray btn-lg w-100 certify">인증하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){

        // $('input[name="login_id"]').val('zeus721');
        // $('input[name="cell_tel"]').val('01020552355');
        // $('input[name="send_sms"]').val('Y');

        $('.sendCertNumber').on('click',function(e){
            e.preventDefault();

            $('.submit-alert').addClass('d-none').find('div>div').html('');
            $('.submit-success').addClass('d-none').find('div>div').html('');

            var $login_id = $('input[name="login_id"]');
            var $cell_tel = $('input[name="cell_tel"]');
            var $_csrf = $('input[name="_csrf"]');

            var obj = {
                _csrf : $_csrf.val()
                ,   login_id : $login_id.val()
                ,   cell_tel : $cell_tel.val()
            };

            if(obj.cell_tel === '' || obj.login_id === ''){
                alert('회원정보를 입력해주세요.');
                return false;
            }

            $.ajax({
                url: "/Find/pw/getUser",
                data: obj,
                method: "post",
                dataType: "json",
                async: false,
                success: function (result) {
                    $_csrf.val(result.csrf);
                    if(result.msg) alert(result.msg);
                    if(result.success){
                        $('input[name="send_sms"]').val('Y');
                        $login_id.prop('readOnly',true);
                        $cell_tel.prop('readOnly',true)
                    }
                }
            });

        });

        $('#find_id').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            beforeSubmit : function(){
                $('.submit-alert').addClass('d-none').find('div>div').html('');
                $('.submit-success').addClass('d-none').find('div>div').html('');
                if( $('input[name="send_sms"]').val() === 'N' ) {
                    alert('인증번호 확인 후 인증해주세요.');
                    return false;
                }
            },
            success : function(result) {
                $('input[name="_csrf"]').val(result.csrf);
                if(result.msg) alert(result.msg);

                var html = '';

                if(result.success === false){
                    if(result.error_msg){
                        $.each(result.error_msg , function(k,v){
                            if(k > 0) html += '<br>';
                            html += v;
                        })
                    }
                    $('.submit-alert').toggleClass('d-none').find('div>div').html(html);
                }else{

                    $('.submit-success').toggleClass('d-none').find('div>div').html(result.success_msg);

                }



            }
        });

    })

</script>
<!-- jquery   -->
<?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>
<!-- JS Form -->
<?=link_src_html('/js/jquery.form.js','js') ?>
