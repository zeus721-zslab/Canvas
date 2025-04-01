<?php
/**
 * @var string $ddy '남은 일수'
 * @var string $username '이름'
 * @var string $s_use_date '시작일'
 * @var string $e_use_date '종료'
 *
 **/
$char_num = rand(1,3);
?>

<div class="border shadow p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-4 gap-md-0 px-lg-5 ">

        <div class="d-flex flex-column flex-lg-row justify-content-start align-items-start gap-3 gap-lg-5" >
            <div class="d-flex justify-content-center">
                <img src="/img/char<?=$char_num?>.png"   style="height: 90px; <?=$char_num == 2 ? 'transform: scale(-1,1)' : ''?>"  />
            </div>
            <div class="d-flex flex-column">
                <h3><?=$username?>님 반갑습니다.</h3>
                <div>구독 기간 동안 무제한으로 디자인 캔버스를 경험하실 수 있습니다.</div>
                <?php if(session('isPay')){?> <div>구독 기간 : <?=view_date_format($s_use_date,4)?> ~ <?=view_date_format($e_use_date,4)?></div> <?php } ?>
            </div>
        </div>
        <div class="d-flex align-items-center pe-5">
            <h1>D-<?=$ddy?></h1>
        </div>

    </div>
</div>
