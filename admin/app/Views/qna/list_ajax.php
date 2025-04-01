<?php

/**
 * @var int $tot_cnt '데이터 총 건수'
 * @var int $per_page '페이지당 노출 row'
 * @var array $data '리스트'
 * @var bool $isAbleSSO 'SSO 가능여부'
 * @var int $tot_page '전체 페이지'
 * @var string $pagination_html '$pagination_html'
 *
 *
 ***/

?>
<!-- result table-->
<div class="card-header">
    <h3 class="card-title"> 총 <?=number_format($tot_cnt)?>건 </h3>
    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">
            <select name="per_page" onchange="getList(1);" class="form-control">
                <option value="10" <?php if($per_page == 10){?>selected<?php }?>>페이지당 10개</option>
                <option value="20" <?php if($per_page == 20){?>selected<?php }?>>페이지당 20개</option>
                <option value="30" <?php if($per_page == 30){?>selected<?php }?>>페이지당 30개</option>
                <option value="50" <?php if($per_page == 50){?>selected<?php }?>>페이지당 50개</option>
                <option value="100" <?php if($per_page == 100){?>selected<?php }?>>페이지당 100개</option>
            </select>
        </div>
    </div>
</div>

<div class="card-body table-responsive p-0">
    <table class="table table-head-fixed text-nowrap text-center list-table">
        <colgroup>
            <col style="width: 60px;">
            <col style="width: 80px;">
            <col style="width: 120px;">
            <col style="width: auto;">
            <col style="width: 120px;">
            <col style="width: 90px;">
            <col style="width: 90px;">
            <col style="width: 100px;">

        </colgroup>
        <thead>
        <tr>
            <th class="bg-light" ><input type="checkbox" id="checkAll" /></th>
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >등록자</th>
            <th class="bg-light" >제목</th>
            <th class="bg-light ">등록일</th>
            <th class="bg-light ">답변여부</th>
            <th class="bg-light ">삭제여부</th>
            <th class="bg-light ">관리</th>
        </tr>
        </thead>
        <tbody>
            <?php if(count($data) > 0){?>
                <?php foreach ($data as $k => $r) { ?>
                    <tr>
                        <td class="text-center">
                            <div class="icheck-success">
                                <input type="checkbox" value="<?=$r['qna_id']?>" class="del_chk" id="check<?=$r['qna_id']?>">
                                <label for="check<?=$r['qna_id']?>"></label>
                            </div>
                        </td>
                        <td class="text-center"><?=$r['VNO']?></td>
                        <td class="text-center">
                            <a class="meminfo-win" style="cursor:pointer;" data-id="<?=$r['user_id']?>"><?=$r['username']?></a>
                            <br>
                            <?php if($r['sns_site'] == 1){?>
                                <span class="bg-warning text-white px-1" style="border-radius: 3px;">K</span>
                            <?php }else if($r['sns_site'] == 2){?>
                                <span class="bg-success text-white px-1" style="border-radius: 3px;">N</span>
                            <?php }else{?>
                            <span>( <?=$r['login_id']?> )</span>
                            <?php }?>

                        </td>

                        <td class="text-start" style="padding: .3rem 1rem ">
                            <span style="text-decoration: underline;cursor: pointer;" class="updateQna" data-seq="<?=$r['qna_id']?>"><?=$r['title']?></span>
                        </td>
                        <td class="text-center"><?=view_date_format($r['reg_date'])?></td>
                        <td>
                            <?php if($r['answer']){?>
                                <span class="text-primary">
                                    답변완료<br>
                                    (<?=view_date_format($r['answer_date'])?>)
                                </span>
                            <?php }else {?>
                                <span class="text-danger">답변예정</span>
                            <?php }?>
                        </td>
                        <td>
                            <?php if($r['del_yn'] == 'Y'){?>
                                <span class="text-danger">
                                    삭제<br>
                                    (<?=view_date_format($r['del_date'])?>)
                                </span>
                            <?php }else {?>
                                -
                            <?php }?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-xs updateQna" data-seq="<?=$r['qna_id']?>">확인</button>
                        </td>
                    </tr>

                <?php } ?>
            <?php } else {?>
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px 0"> 검색결과가 없습니다. </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
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
