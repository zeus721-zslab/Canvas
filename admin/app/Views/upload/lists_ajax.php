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

<div class="card-body table-responsive p-0" style="_height: 300px;">
    <table class="table table-head-fixed text-nowrap text-center list-table">
        <thead>
        <tr >
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >썸네일</th>
            <th class="bg-light" >사용자정보</th>
            <th class="bg-light ">등록일</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="4" style="line-height: 150px;">
                    정보가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) { ?>
                <tr>
                    <td><?=$r['VNO']?></td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a class="d-inline-block overflow-hidden" style="max-height: 100px;max-width: 150px;">
                            <img class="img-thumbnail bg-light goViewImg" src="<?=$r['image_file']?>" data-org_src="<?=$r['image_file']?>" style="width: 50px;" alt="">
                        </a>
                    </td>
                    <td><?=$r['username']?><br>(<?=$r['group']?>)</td>
                    <td> <?=view_date_format($r['reg_date'])?> </td>
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
