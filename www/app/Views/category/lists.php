<?php
/**
 * @var array $aList  '컨텐츠리스트'
 * @var array $aInput '입력값'
 * @var object $encrypter '암호화object'
 * @var int $per_page '페이지당 갯수'
 */
?>

<style>
    .category-sub-title {font-size: 20px;font-weight: 600;}
    .contents-lists img.paid-mark{width: 30px!important;top: 15px;right:15px;}
    @media (min-width: 992px) {
        .contents-lists img.paid-mark{width: 40px!important;top: 15px;right:15px;}
    }

    .ratio-P{aspect-ratio: 53/75} /*세로*/
    .ratio-L{aspect-ratio: 106/75} /*가로*/
    .ratio-S{aspect-ratio: 1} /*정*/

</style>
<script src="/js/isotope.pkgd.js"></script>

<main class="main-ctgr">
    <div class="container-fluid px-lg-5">
        <div class="main-title">
            <h1 style="font-weight: 600" class="text-center"><?=$aInput['page_title']?></h1>
        </div>
        <div class="d-flex flex-column mt-5 gap-5 contents-lists">

            <?php if($aInput['menu_type'] == 'event' || $aInput['menu_type'] == 'play'){?>
            <div class="d-flex justify-content-between">
                <a class="category-sub-title d-flex align-items-center"></a>
            </div>
            <?php } ?>

            <ul class="grid p-0"> </ul>

        </div>
        <?php if($aInput['menu_type'] == 'event' || $aInput['menu_type'] == 'play'){?>
        <div class="d-inline-block position-sticky justify-content-end float-end"  style="bottom: 1rem;">
            <div style="z-index: 10;bottom: 0;right:0;width: 100px;">
                <a class="d-flex align-items-center justify-content-center  fw-bold goBack zs-cp">
                    <img src="/images/goback.png" alt="goback" style="width: 100%;" />
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
</main>

<script type="text/javascript">
    var per_page = '<?=$per_page?>';
    var menu_type = '<?=$aInput['menu_type']?>';
    var group_id = '<?=$aInput['group_id']?>';
</script>

<?=link_src_html('/js/isoto.js' , 'js')?>