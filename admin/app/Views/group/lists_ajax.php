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
        <tr>
            <th class="bg-light" style="width: 30px;"><input type="checkbox" id="checkAll" /></th>
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >순서</th>
            <th class="bg-light" >보이는 영역</th>
            <th class="bg-light" >카테고리</th>
            <th class="bg-light" >제목</th>
            <th class="bg-light" >노출컨텐츠</th>
            <th class="bg-light" >미노출컨텐츠</th>
            <th class="bg-light" >사용 여부</th>
            <th class="bg-light" >등록일<br>(수정일)</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="10" style="line-height: 150px;">
                    정보가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) { ?>
                <tr>
                    <td><input type="checkbox" name="group_id" value="<?=$r['group_id']?>" title /></td>
                    <td><?=$r['VNO']?></td>
                    <td><?=$r['seq'] == 999 ? '순서적용안됨' :  $r['seq']?></td>
                    <td>
                        <?=$r['view_type'] == 'canvas' ? '캔버스' :  '메뉴'?>
                        <?php
                        if(!empty($r['menu_type']) && $r['view_type'] == 'menu' ){
                            if($r['menu_type'] == 'play') echo '<br><span class="fs-8">( 놀이 )</span>';
                            else if($r['menu_type'] == 'event') echo '<br><span class="fs-8">( 행사 )</span>';
                            else if($r['menu_type'] == 'notice') echo '<br><span class="fs-8">( 안내문 )</span>';
                            else if($r['menu_type'] == 'env') echo '<br><span class="fs-8">( 환경구성 )</span>';
                            else if($r['menu_type'] == 'month') echo '<br><span class="fs-8">( 월별디자인 )</span>';
                            else echo 'ERROR';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if( $r['category'] == 'clip' ){?>
                            <button type="button" class="btn btn-outline-secondary btn-xs">클립</button>
                        <?php }else if( $r['category'] == 'bg' ){?>
                            <button type="button" class="btn btn-outline-success btn-xs">배경</button>
                        <?php }else if( $r['category'] == 'template' ){?>
                            <button type="button" class="btn btn-outline-primary btn-xs">템플릿</button>
                        <?php } ?>
                    </td>
                    <td><a class="text-decoration-none" href="javascript:upsertForm('<?=$r['group_id']?>');"><?=$r['title']?></a></td>


                    <td><?=number_format($r['able_cnt'])?></td>
                    <td><?=number_format($r['unable_cnt'])?></td>

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
