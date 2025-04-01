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
            <th class="bg-light" style="width: 30px;"><input type="checkbox" id="checkAll" /></th>
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >카테고리</th>
<!--            <th class="bg-light" >mime</th>-->
            <th class="bg-light" >썸네일</th>
            <th class="bg-light" >제목</th>
            <th class="bg-light" >사용 횟수</th>
            <th class="bg-light" >사용 여부</th>
            <th class="bg-light ">등록일<br>(수정일)</th>
            <th class="bg-light" style="width: 120px" >관리</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="8" style="line-height: 150px;">
                    정보가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) { ?>
                <tr>
                    <td><input type="checkbox" name="clip_id" value="<?=$r['clip_id']?>" /></td>
                    <td><?=$r['VNO']?></td>
                    <td>
                        <?php if( $r['category'] == 'topper' ){?>
                            <button type="button" class="btn btn-outline-secondary btn-xs">토퍼</button>
                        <?php }else if( $r['category'] == 'bg' ){?>
                            <button type="button" class="btn btn-outline-success btn-xs">배경</button>
                        <?php }else if( $r['category'] == 'clip' ){?>
                            <button type="button" class="btn btn-outline-primary btn-xs">클립</button>
                        <?php } ?>
                    </td>
                    <!--<td><?=$r['file_mime']?></td>-->
                    <td> <img class="img-thumbnail bg-light goViewImg" src="<?=$r['thumb_file']?>" data-org_src="<?=$r['save_file']?>" style="width: 50px;" alt=""></td>
                    <td><a class="text-decoration-none" href="javascript:upsertForm('<?=$r['clip_id']?>');"><?=$r['title']?></a></td>
                    <td><?=number_format($r['hit'])?></td>
                    <td>
                        <?php if($r['use_flag'] == 'Y'){?>
                            <button type="button" class="btn btn-sm btn-success btn-xs">사용함</button>
                        <?php }else{?>
                            <button type="button" class="btn btn-sm btn-danger btn-xs">사용안함</button>
                        <?php }?>
                    </td>
                    <td>
                        <?=view_date_format($r['reg_date'])?>
                        <?php if(!empty($r['mod_date'])){?>
                            <br>(<?=view_date_format($r['mod_date'])?>)
                        <?php } ?>
                    </td>
                    <td>
                        <a role="button" class="btn btn-success copy-clip btn-xs w-100" data-idx="<?=$r['clip_id']?>">복사하기</a>
                    </td>
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
