<?php
/**
 * @var array $aList '컨텐츠리스트'
 * @var array $aInput '입력값'
 * @var object $encrypter '암호화object'
 * @var array $aMonthLists '월 정보'
 * @var int $per_page '페이지당 갯수'
 * @var string $curr_month '현재 월'
 *
 */
?>

<style>
    .contents-lists img.paid-mark{width: 30px!important;top: 15px;right:15px;}
    @media (min-width: 992px) {
        .contents-lists img.paid-mark{width: 40px!important;top: 15px;right:15px;}
    }
</style>

<main class="main-ctgr">
    <div class="main-title">
        <h1 style="font-weight: 600" class="text-center">월별 디자인</h1>
        <p class="text-center mt-3" style="font-weight: 600">월별 필요한 디자인을 누구나 쉽게 편집할 수 있어요!</p>
    </div>

    <div class="mt-5 contents-category-wrap d-flex justify-content-center  w-100 position-relative">
        <span class="position-absolute d-none d-md-none align-items-center justify-content-center ctgr-month-left-arrow" style="left: 0;top: 0;height: 100%;width: 32px;border-radius: 100%;background-color: rgba(0,0,0,0.2)"> <i class="fa-solid fa-angle-left"></i> </span>
        <ul class="contents-category d-flex align-items-center">
            <?php foreach ($aMonthLists as $r){?>
                <li class="<?php if($curr_month == $r['title']){?>active<?php } ?> py-2 goGetMonth text-center zs-cp" data-seq="<?=$r['group_id']?>"><a role="button" class="d-inline-block"><?=$r['title']?></a></li>
            <?php } ?>
        </ul>
        <span class="position-absolute d-flex d-md-none align-items-center justify-content-center ctgr-month-right-arrow" style="right: 0;top: 0;height: 100%;width: 32px;border-radius: 100%;background-color: rgba(0,0,0,0.2)"> <i class="fa-solid fa-angle-right"></i> </span>
    </div>

    <div class="contents-lists mt-5 mx-1 mx-lg-5">
        <div class="w-100">
            <?php foreach ($aList as $r) {?>
                <ul class="grid p-0"> </ul>
            <?php } ?>
        </div>
    </div>
</main>

<script type="text/javascript">
    var per_page = '<?=$per_page?>';
    var menu_type = 'month';
    var group_id = '';
</script>

<?=link_src_html('/js/isoto.js' , 'js')?>




