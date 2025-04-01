<?php

/**
 * @var string $ext '외부 html'
 *
 */

?>

<main>
    <div class="container-fluid w-1560">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center">내 정보</h1>
        </div>

        <div class="row mt-5">
            <div class="col-12">

                <?=$ext?>

                <ul class="d-flex border-bottom my-info-tap mt-5">
                    <li style="border:1px solid #ddd; border-bottom: none;">
                        <a class="d-inline-block py-2 px-5" href="/My/history">결제내역 조회</a>
                    </li>
                    <li class="active" style="border:1px solid #ddd; border-bottom: none;border-left:none;">
                        <a class="d-inline-block py-2 px-5" href="/My/info">회원정보 수정</a>
                    </li>
                </ul>
            </div>

            <div class="offset-md-3 col-md-6 col-10 offset-1 mt-5">
                <form id="confirmForm" method="post" action="/Auth/modifyCheck" onsubmit="return chkValid();">
                    <div class="fw-bold mb-2"> 회원정보 변경을 위해 비밀번호 확인를 입력해주세요.</div>
                    <div class="mb-3 d-flex input-group">
                        <div class="form-floating ">
                            <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required>
                            <label for="floatingPasswordInput"><?= lang('Auth.passwordConfirm') ?></label>
                        </div>
                        <button type="submit" class="btn btn-black" style="width: 100px;">확인</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</main>

<script type="text/javascript">

    function chkValid(){
        var $password = $('.password');
        if($password.val() === ''){
            alert('비밀번호를 입력해주세요!');
            $password.focus();
            return false;
        }
    }

</script>