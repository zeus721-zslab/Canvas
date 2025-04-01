<?php
/**
 * @var string $NAVER_REQUEST_URL '네이버로그인 URL'
 * @var string $KAKAO_REQUEST_URL '카카오로그인 URL'
 */

?>

<div class="container d-flex justify-content-center py-5 px-md-5">

    <div class="card col-12 col-md-6 border-0">
        <div class="card-body">

            <div class="main-title text-center pb-4">
                <a href="/"><img src="/img/kinder_logo.png" alt="" style="width: 60%; "/></a>
            </div>

            <?php if (session('error') !== null) : ?>
            <div class="d-flex col-12 offset-0 col-md-10 offset-md-1 mt-3">
                <div class="alert alert-danger w-100" role="alert"><?= session('error') ?></div>
            </div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="d-flex col-12 offset-0 col-md-10 offset-md-1  mt-3">
                <div class="alert alert-danger w-100" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
                </div>
            <?php endif ?>


        <?php if (session('message') !== null) : ?>
        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
        <?php endif ?>
        <div class="d-flex col-12 offset-0 col-md-10 offset-md-1 pt-4">
            <form action="<?= url_to('login') ?>" method="post" class="w-100" >
                <?= csrf_field() ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingIdInput" name="login_id" inputmode="login_id" autocomplete="login_id" placeholder="<?= lang('Auth.login_id') ?>" value="<?= old('login_id') ?>" required>
                    <label for="floatingIdInput">아이디</label>
                </div>
                <!-- Password -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                </div>
                <div class="d-flex justify-content-between mb-5">
                    <!-- Remember me -->
                    <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                    <div class="main-checkbox sm">
                        <div class="round">
                            <input type="checkbox" name="remember" id="remember" title="" class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?> />
                            <label for="remember"></label>
                        </div>
                        <label for="remember" class="fw-normal zs-cp"><?= lang('Auth.rememberMe') ?></label>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex gap-2">
                        <a href="<?=route_to('Find::id')?>">아이디 찾기</a>
                        <span>|</span>
                        <a href="<?=route_to('Find::pw')?>">비밀번호 찾기</a>
                    </div>
                </div>
                <div class="d-flex col-12 col-md-8 mx-auto m-3 flex-column gap-3 pb-4">
                    <button type="submit" class="btn btn-lightgray btn-block" style="border-radius: 0;"><?= lang('Auth.login') ?></button>
                    <a role="button" class="btn btn-gray btn-block" href="<?= url_to('RegisterController::guide_register') ?>">회원가입</a>
                </div>

                <div class="d-flex col-12 col-md-8 mx-auto m-3 gap-3 justify-content-between">
                    <span class="mid-line d-flex align-items-center" style="width: 25%;">
                        <span class="line border-top border-bottom w-100"></span>
                    </span>
                    <span style="opacity: .5">SNS 간편 로그인</span>
                    <span class="mid-line d-flex align-items-center" style="width: 25%;">
                        <span class="line border-top border-bottom w-100"></span>
                    </span>
                </div>


                <div class="col-12 col-md-8 mx-auto row justify-content-between">
                    <div class="d-flex justify-content-center align-items-center p-0" style="width: 48%;"> <a class="d-inline-block w-100" href="<?=$NAVER_REQUEST_URL?>"><img src="/images/sns_login/naver_login.png?t" alt="네이버로그인" class="w-100"/></a> </div>
                    <div class="d-flex justify-content-center align-items-center p-0" style="width: 48%;"> <a class="d-inline-block w-100" href="<?=$KAKAO_REQUEST_URL?>"><img src="/images/sns_login/kakao_login.png?t" alt="카카오로그인"  class="w-100"/></a> </div>
                </div>

                <?php if (setting('Auth.allowRegistration')) : ?>

                <?php endif ?>

            </form>
        </div>
        </div>
    </div>
</div>

<!-- jquery   -->
<?=link_src_html('/js/jquery-3.7.1.min.js','js')?>
<!-- Custom js-->
<?=link_src_html('/js/custom.js','js')?>