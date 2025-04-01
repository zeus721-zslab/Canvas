<?php

/**
 * @var object $aOrderInfo '주문정보'
 * */

?>

<main>
    <div class="container-fluid">

        <div class="row">

            <div class="col-10 offset-1 col-md-6 offset-md-3 d-flex flex-column align-items-center justify-content-center gap-5 ">

                <div class="d-flex flex-column gap-4 border-bottom w-100 ">
<!--                    <h1 style="font-weight: 600;" class="text-center">-->
<!--                        <img src="/images/check_icon.png"  alt="check_icon" />-->
<!--                    </h1>-->
                    <span style="color:var(--gray-color);font-size: 5.5rem;text-align: center"><i class="fa-solid fa-circle-check"></i></span>
                    <div class="fw-bold mb-3 text-center fs-3"  style="color: var(--main-check-color);">결제가 정상적으로 완료되었습니다.</div>
                </div>

                <div class="payment-complete-info">
                    
                    <?php if($aOrderInfo->o_paymethod == 'vcnt' || $aOrderInfo->o_paymethod == 'fixed_vacc'){?>

                    <dl class="d-flex">
                        <dt>이용기간</dt>
                        <dd>입금일로부터 1년</dd>
                    </dl>
                        
                    <dl class="d-flex">
                        <dt>입금은행</dt>
                        <dd><?=$aOrderInfo->bank?></dd>
                    </dl>

                    <dl class="d-flex">
                        <dt>계좌번호</dt>
                        <dd><?=$aOrderInfo->bankacct?></dd>
                    </dl>

                    <dl class="d-flex">
                        <dt>예금주</dt>
                        <dd><?=$aOrderInfo->deposit?></dd>
                    </dl>
                    <dl class="d-flex">
                        <dt>입금기한</dt>
                        <dd><?=view_date_format($aOrderInfo->vacc_limit)?></dd>
                    </dl>

                    <?php } else{ ?>

                        <dl class="d-flex">
                            <dt>이용기간</dt>
                            <dd><?=view_date_format($aOrderInfo->s_use_date,4)?> ~ <?=view_date_format($aOrderInfo->e_use_date,4)?></dd>
                        </dl>

                    <?php } ?>
                    <dl class="d-flex align-items-center">
                        <dt>결제금액</dt>
                        <dd class="d-flex align-items-center m-0"><span class="fs-5" style="color:var(--main-check-color)"><?=number_format($aOrderInfo->amount)?></span>원</dd>
                    </dl>

                </div>

            </div>

        </div>
    </div>
</main>
