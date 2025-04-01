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

<div class="card-body table-responsive p-0" style="">
    <table class="table table-head-fixed text-nowrap text-center list-table">
        <thead>
        <tr>
            <th class="bg-light" ><input type="checkbox" id="checkAll" /></th>
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >아이디</th>
            <th class="bg-light" >이름</th>
            <th class="bg-light ">상태</th>
            <th class="bg-light ">관리</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="7" style="line-height: 150px;">
                    정보가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) {   ?>

                <tr>
                    <td><input type="checkbox" name="id" value="<?=$r['id']?>" /></td>
                    <td><?=$r['VNO']?></td>
                    <td><?=$r['secret']?></td>
                    <td><?=$r['username']?></td>
                    <td>
                        <?php
                        if(!$r['deleted_at']) echo '정상';
                        else echo '비활성화';
                        ?>
                    </td>
                    <td><button class="btn btn-xs btn-primary" onclick="upsertForm('<?=$r['id']?>');" >수정하기</button></td>
                </tr>

            <?php } ?>
        <?php }?>
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
