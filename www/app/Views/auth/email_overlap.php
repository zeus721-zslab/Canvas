<?php
/**
 * @var string $aInfo '회원정보'
 */

?>
<style>
    dl dt {min-width: 100px;text-align: right}
    dl dd {min-width: 200px;}
</style>

    <div class="container d-flex justify-content-center py-5 px-md-5">

    <div class="col-12 col-md-6 border-0">

        <div class="main-title text-center pb-4">
            <a href="/"><img src="/img/kinder_logo.png" alt="" style="width: 60%; "/></a>
        </div>

        <div class="d-flex justify-content-center flex-column">

            <p class="text-center">이미 같은 이메일로 등록된 회원정보가 있습니다.</p>

            <?php if($aInfo['sns_site'] == 1){?>
            <dl class="d-flex flex-row gap-4 align-items-center mb-0 py-2 justify-content-center">
                <dt>로그인 정보</dt>
                <dd> <span style="background-color: #FEE500;" class="d-inline-block text-black px-3">카카오</span> </dd>
            </dl>
            <?php }else if($aInfo['sns_site'] == 2){?>
            <dl class="d-flex flex-row gap-4 align-items-center mb-0 py-2 justify-content-center">
                <dt>로그인 정보</dt>
                <dd> <span style="background-color: #2DB400;" class="d-inline-block text-white px-3">네이버</span> </dd>
            </dl>
            <?php } else {?>
            <dl class="d-flex flex-row gap-4 align-items-center mb-0 py-2 justify-content-center">
                <dt>아이디</dt>
                <dd><?=$aInfo['login_id']?></dd>
            </dl>
            <?php } ?>

            <dl class="d-flex flex-row gap-4 align-items-center mb-0 py-2 justify-content-center">
                <dt>이름</dt>
                <dd><?=$aInfo['username']?></dd>
            </dl>

            <dl class="d-flex flex-row gap-4 align-items-center mb-0 py-2 justify-content-center">
                <dt>이메일</dt>
                <dd><?=$aInfo['user_email']?></dd>
            </dl>

            <div class="d-flex justify-content-center mt-5">
                <a role="button" class="btn btn-black px-5" href="<?=route_to('login')?>">로그인하러 가기</a>
            </div>

        </div>



    </div>
</div>

<!-- jquery   -->
<?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>