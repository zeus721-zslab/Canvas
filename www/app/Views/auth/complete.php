<?php
/**
 * @var string $login_id '로그인 아이디 | __sns :sns회원가입 인 경우 '
 *
 **/

?>
<style>
    .main-title img{ width: 75%; }
    @media (min-width: 992px) { .main-title img{ width: 480px } }
</style>
<main style="margin-top: 8rem;">
    <div class="container-fluid">

        <div class="main-title mb-4">
            <h1 style="font-weight: 600;" class="text-center">
                <a class="d-inline-block" href="/"><img src="/img/kinder_logo.png" alt="" style="width: "/></a>
            </h1>
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex flex-column align-items-center justify-content-center ">
                <span style="color:var(--gray-color);font-size: 5.5rem"><i class="fa-solid fa-circle-check"></i></span>
                <h4 class="mb-3 mt-2">회원가입이 완료되었습니다.</h4>
                <div>회원가입을 축하합니다.</div>

                <?php if($login_id == '__sns'){?>
                    <div class="mb-5">sns 회원가입</div>
                <?php }else{?>
                    <div class="mb-5">아이디는 <span style="color:var(--gray-color);" class="fw-bold"><?=$login_id?></span>입니다.</div>
                <?php } ?>

                <div class="d-flex gap-4">
                    <a role="button" href="/" class="btn btn-black" style="width: 200px;padding: .75rem 0;">시작하기</a>
                    <a role="button" href="<?=route_to('Payment::upsertForm')?>" class="btn btn-gray" style="width: 200px;padding: .75rem 0;">결제하기</a>
                </div>
            </div>

        </div>
    </div>
</main>
