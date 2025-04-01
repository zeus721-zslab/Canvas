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

<div class="card-body table-responsive p-0" style="_height: 300px;">
    <table class="table table-head-fixed text-nowrap text-center list-table">
        <thead>
        <tr>
            <th class="bg-light" >VNO</th>
            <th class="bg-light" >아이디</th>
            <th class="bg-light" >이름</th>
            <th class="bg-light ">이메일</th>
            <th class="bg-light ">연락처</th>
            <th class="bg-light ">이용기간</th>
            <th class="bg-light ">꼬망세연동</th>
            <th class="bg-light ">상태</th>
            <th class="bg-light ">관리</th>
            <th class="bg-light ">CS메모</th>
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
            <?php foreach ($data as $k => $r) {  ?>

                <tr>
                    <td><?=$r['VNO']?></td>
                    <td>
                        <?php if($r['sns_site'] == 1){?>
                            <button class="btn btn-xs btn-warning">카카오</button>
                        <?php } else if($r['sns_site'] == 2){?>
                            <button class="btn btn-xs btn-success">네이버</button>
                        <?php } else {?>
                            <?=$r['login_id']?>
                        <?php } ?>
                    </td>
                    <td><a class="meminfo-win" style="cursor:pointer;" data-id="<?=$r['id']?>"><?=$r['username']?></a></td>
                    <td><?=$r['user_email']?></td>
                    <td><?=$r['cell_tel']?></td>
                    <td>
                        <?php if($r['e_use_date']){?>
                            <?=view_date_format($r['s_use_date'],5)?><br>~ <?=view_date_format($r['e_use_date'],5)?>
                        <?php } else{ ?>
<!--                            무료회원-->
                        <?php } ?>
                    </td>

                    <td>
                        <?php if($r['cmc_vcID']){?>
                            <span class="text-primary">꼬망세 연동회원</span>
                            <br>
                            <span>(<?=$r['cmc_vcID']?>)</span>
                        <?php }else{ ?>
                            <span>일반가입 회원</span>
                        <?php }?>
                    </td>

                    <td>
                        <?php if($r['deleted_at']){?>
                            <span class='text-danger'>탈퇴<br>(탈퇴일: <?=$r['deleted_at']?>)</span>
                        <?php }else{?>
                            <span>정상<br>(가입: <?=view_date_format(onlynumber($r['created_at']),5)?>)</span>
                        <?php }?>
                    <td><button class="btn btn-xs btn-primary" onclick="upsertForm('<?=$r['id']?>');" >수정하기</button></td>
                    <td>
                        <input type="text" class="form-control" data-id="<?=$r['id']?>" placeholder="입력 후 엔터 입력하여 저장" name="userCsMemo" title="userCsMemo" value="<?=$r['cs_memo']?>" />
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
