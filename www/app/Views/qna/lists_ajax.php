<?php
/**
 * @var int $tot_cnt '데이터 총 건수'
 * @var array $data '리스트'
 * @var int $tot_page '전체 페이지'
 * @var string $pagination_html '$pagination_html'
 *
 ***/
?>
<style>
    table,tr,td,th{border-color: var(--main-color)!important;;}

    .list-table thead th:nth-child(2) {width: auto; }
    .list-table thead th:nth-child(4) {width: 100px; }
    @media (min-width: 992px) {
        .list-table thead th:nth-child(1) {width: 100px; }
        .list-table thead th:nth-child(2) {width: auto; }
        .list-table thead th:nth-child(3) {width: 100px; }
        .list-table thead th:nth-child(4) {width: 200px; }
    }
</style>

<div class="card-body table-responsive p-0">
    <table class="table table-bordered table-head-fixed text-nowrap text-center list-table">
        <thead>
        <tr>
            <th class="bg-main d-none d-lg-table-cell">번호</th>
            <th class="bg-main">제목</th>
            <th class="bg-main d-none d-lg-table-cell">답변여부</th>
            <th class="bg-main">날짜</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="4" style="line-height: 150px;">
                    1:1문의가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) {  ?>
                <tr>
                    <td class="d-none d-lg-table-cell"><?=$r['VNO']?></td>
                    <td class="text-start"><a href="<?=route_to('Qna::view',$r['qna_id'])?>"><?=$r['title']?></a></td>
                    <td class="d-none d-lg-table-cell">
                        <?php if($r['answer']){?>
                            <span>답변완료</span>
                        <?php } else{?>
                            <span style="color:var(--logo-red)">답변예정</span>
                        <?php } ?>
                    </td>
                    <td class="d-none d-lg-table-cell"><?=view_date_format($r['reg_date'])?></td>
                    <td class="d-table-cell d-lg-none"><?=view_date_format($r['reg_date'],4)?></td>
                </tr>
            <?php } ?>
        <?php }?>
        </tbody>
    </table>

    <div>
        <a href="<?=route_to('Qna::upsertForm')?>" role="button" class="btn goWrite" style="background-color: var(--lightbrown-color);color:#fff;border-radius: 0;">문의하기</a>
    </div>
</div>

<?php if(count($data) > 0 && $tot_page > 1){?>
    <div class="row">
        <div class="col-md-12">
            <?=$pagination_html?>
        </div>
    </div>
<?php } ?>

<script>
    $(function(){
        total_page = '<?=$tot_page?>';
        $('input[name="_csrf"]').val('<?=csrf_hash()?>');
    })
</script>
