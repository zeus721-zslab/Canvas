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
        <tr >
            <th class="bg-light">VNO</th>
            <th class="bg-light">구매상품</th>
            <th class="bg-light">구매자</th>
            <th class="bg-light">결제금액</th>
            <th class="bg-light">결제방법</th>
            <th class="bg-light">연락처</th>
            <th class="bg-light">결제상태</th>
            <th class="bg-light">이용기간</th>
            <th class="bg-light">취소정보</th>
            <th class="bg-light">관리</th>
        </tr>
        </thead>
        <tbody>
        <?php if(count($data) < 1){?>
            <tr>
                <td colspan="9" style="line-height: 150px;">
                    정보가 없습니다.
                </td>
            </tr>
        <?php }else{?>
            <?php foreach ($data as $k => $r) { ?>

                <tr>
                    <td><?=$r['VNO']?></td>
                    <td>
                        <?=$r['good_name']?><br>
                        ( <?=$r['order_id']?> )
                    </td>
                    <td class="position-relative">
                        <div class="d-flex justify-content-center align-items-center gap-2 ">
                            <span class="d-flex align-items-center"><?=$r['username']?> </span>
                            <a role="button" class="show-meminfo-more d-flex align-items-center px-1 text-decoration-none text-center" style="height:15px;width:15px;  font-size: .7rem; border-radius: 3px;background-color: #ccc;" title="더보기">+</a>
                        </div>

                        <?php if($r['sns_site'] == 1){?>
                            <span class="bg-warning text-white px-1" style="border-radius: 3px;">K</span>
                        <?php }else if($r['sns_site'] == 2){?>
                            <span class="bg-success text-white px-1" style="border-radius: 3px;">N</span>
                        <?php }else{?>
                            <span>( <?=$r['login_id']?> )</span>
                        <?php }?>
                        <div class="bg-white position-absolute meminfo-more d-none flex-column border shadow-sm py-2 px-3" style="z-index: 9; font-size: .75rem;_width: 300px;margin: 0 auto;">
                            <span>주문자 이름 : <?=$r['o_name']?></span>
                            <span>주문자 연락처 : <?=$r['o_celltel']?></span>
                            <span>주문자 이메일 : <?=$r['o_email']?></span>
                        </div>
                    </td>
                    <td><?=number_format($r['amount'])?>원</td>
                    <td>
                        <?php
                        if($r['o_paymethod'] == 'vcnt'){
                            echo '<span>무통장 입금</span>';
                        }else if($r['o_paymethod'] == 'card'){
                            echo '<span>신용카드</span>';
                        }else if($r['o_paymethod'] == 'fixed_vacc'){
                            echo '<span>고정계좌</span>';
                        }else if($r['o_paymethod'] == 'phone'){
                            echo '<span>휴대폰결제</span>';
                        }
                        ?>
                    </td>
                    <td><?=$r['o_celltel']?></td>
                    <td>
                        <?php
                        if($r['pay_flag'] == 'Y'){
                            echo '<button class="btn btn-xs btn-success">결제완료</button>';
                        }else if($r['pay_flag'] == 'N'){
                            echo '<button class="btn btn-xs btn-danger">결제 전</button>';
                        }else if($r['pay_flag'] == 'W'){
                            echo '<button class="btn btn-xs btn-warning">입금 대기</button>';
                        }else if($r['pay_flag'] == 'C'){
                            echo '<button class="btn btn-xs btn-danger">결제 취소</button>';
                        }
                        ?>
                    </td>
                    <td>

                        <?php if($r['pay_flag'] == 'Y'){ ?>
                            <div class="d-flex flex-column">
                                <span><?=view_date_format($r['user_s_use_date'],5)?> ~ <?=view_date_format($r['user_e_use_date'],5)?></span>
                                <span style="font-size: .8rem">
                                <?php $reference = ['template_cnt' => '템플릿' , 'clip_cnt' =>'요소' , 'mycvs_cnt' => '내보관함'];?>
                                <?php if($r['use_log']){ $isFirst = true;?>
                                    (
                                    <?php foreach ($r['use_log'] as $kk => $vv) { if($vv > 0){?>
                                        <?=!$isFirst?',&nbsp;&nbsp;':''?><?=$reference[$kk]?> : <?=number_format($vv)?>건
                                        <?php $isFirst=false;} }?>
                                    )
                                <?php }?>
                                </span>
                            </div>
                        <?php } ?>
                    </td>

                    <td>
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <?php if($r['req_cancel_complete'] == 'Y'){?>
                                <button class="btn btn-primary btn-xs">취소완료</button>
                                <span style="font-size: .8rem">(취소 완료일 : <?=view_date_format($r['req_cancel_complete_date'])?>)</span>
                            <?php }else{ ?>
                                <button class="btn btn-danger btn-xs">취소요청</button>
                            <?php } ?>
                            <span style="font-size: .8rem">(취소 요청일 : <?=view_date_format($r['req_cancel_date'])?>)</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-2 justify-content-center">
                            <button class="btn btn-primary btn-xs reqCancel" data-order_id="<?=$r['order_id']?>" data-req="Y" data-status="<?=$r['pay_flag']?>">취소하기</button>
                            <button class="btn btn-danger btn-xs reqCancel" data-order_id="<?=$r['order_id']?>" data-req="C">취소요청 원복</button>
                        </div>
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
