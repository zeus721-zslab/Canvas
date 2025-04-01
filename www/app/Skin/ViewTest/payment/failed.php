<?php

/**
 * @var string $message '실패 메시지'
 **/


?>


<main>
    <div class="container-fluid">

        <div class="row">

            <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column align-items-center justify-content-center gap-5 ">

                <div class="d-flex flex-column gap-4 border-bottom w-100 ">
                    <div class="fw-bold mb-3 text-center fs-3"  style="color: var(--main-check-color);">결제가 실패되었습니다.</div>
                </div>

                <div class="payment-complete-info">
                    <dl class="d-flex">
                        <dt>메시지</dt>
                        <dd><?=$message?></dd>
                    </dl>
                </div>

            </div>

        </div>
    </div>
</main>
