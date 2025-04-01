<?php
/**
 * @var array $data '회원정보'
 * @var string $title '모달 제목'
 * @var bool $isUpdate '업데이트 여부'
 * @var bool $isAbleSSO 'SSO 가능여부'
 *
 ***/

?>

<?=link_src_html('/plugins/moment/moment.min.js' , 'js')?>
<?=link_src_html('/plugins/moment/locale/ko.js' , 'js')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.css' , 'css')?>
<?=link_src_html('/plugins/daterangepicker/daterangepicker.js' , 'js')?>

<div id="upsertFormModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/PaymentManagement/upsert" method="post">
                    <?=csrf_field()?>
                    <input type="hidden" name="id" value="<?=$data['idx']?>">


                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">상품명</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext"><?=$data['good_name']?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">구매자명</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext"><?=$data['o_name']?></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">결제금액</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext"><?=number_format($data['amount'])?>원</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">결제방법</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext">
                                <?php
                                if($data['o_paymethod'] == 'vcnt'){
                                    echo '<span>무통장 입금</span>';
                                }else if($data['o_paymethod'] == 'card'){
                                    echo '<span>신용카드</span>';
                                }else if($data['o_paymethod'] == 'fixed_vacc'){
                                    echo '<span>고정계좌</span>';
                                }else if($data['o_paymethod'] == 'phone'){
                                    echo '<span>휴대폰결제</span>';
                                }
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">연락처</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext"><?=$data['o_celltel']?></span>
                        </div>
                    </div>


                    <?php if($data['pay_flag'] == 'Y'){ ?>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">이용기간</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext"><?=view_date_format($data['s_use_date'],5)?> ~ <?=view_date_format($data['e_use_date'],5)?></span>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">결제여부</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="pay_flag" title="pay_flag">
                                <option value="W" <?=$data['pay_flag']=='W'?'selected':''?>>결제대기</option>
                                <option value="Y" <?=$data['pay_flag']=='Y'?'selected':''?>>결제완료</option>
                                <!--<option value="C" <?=$data['pay_flag']=='C'?'selected':''?>>결제취소</option>-->
                            </select>
                        </div>

                        <?php if($data['pay_flag'] != 'Y'){?>
                        <div class="col-md-10 offset-2 d-none align-items-center mt-2 send_sms_wrap fs-7">
                            <label><input type="checkbox" name="send_sms" value="Y">결제완료 문자 발송(체크시 발송)</label>
                        </div>
                        <?php }?>

                    </div>


                    <?php if($data['pay_flag']=='Y'){?>
                    <div class="row mb-3 d-none payment-cancel-wrap">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">결제취소<br>추가정보</label>
                        </div>
                        <div class="col-md-10">

                            <div class="card w-75">
                                <div class="card-header">이용기간 변경 <button type="button" class="btn btn-xs btn-danger initUseDate">종료일 초기화</button></div>
                                <div class="card-body d-flex gap-2">

                                    <div class="input-group date w-50" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="s_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?=$data['user_s_use_date']?>" autocomplete="off">
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <span class="d-flex align-items-center">~</span>
                                    <div class="input-group date w-50" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="e_use_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?=$data['user_e_use_date']?>" autocomplete="off">
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text" style="border-top-left-radius: 0;border-bottom-left-radius: 0;height: 100%;border-left:0;"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <?php }?>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">메모</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="memo" class="form-control" rows="3"><?=$data['memo']?></textarea>
                        </div>
                    </div>
                    <?php if($data['pay_flag'] == 'Y'){ ?>
                    <div class="row mb-3">
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            <label class="fw-bold">결제일</label>
                        </div>
                        <div class="col-md-10">
                            <span class="form-control-plaintext">
                                <?=view_date_format($data['pay_date'])?>
                            </span>
                        </div>
                    </div>
                    <?php }?>

                    <?php if($data['o_paymethod'] == 'vcnt' || $data['o_paymethod'] == 'fixed_vacc' || $data['o_paymethod'] == 'phone'){?>


                        <div class="row mb-3">
                            <div class="col-md-2 d-flex align-items-start justify-content-end">
                                <label class="fw-bold">추가정보</label>
                            </div>
                            <div class="col-md-10">

                                <div class="d-flex justify-content-between mb-3 gap-2">

                                    <?php if($data['cash_receipt'] == 'Y' ){?>

                                        <div class="card w-50">
                                            <div class="card-header">세금계산서 정보</div>

                                            <div class="card-body">
                                                <dl class="d-flex gap-3">
                                                    <dt>사업자 등록번호</dt>
                                                    <dd><?=$data['cash_no']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3">
                                                    <dt>상호명</dt>
                                                    <dd><?=$data['cash_name']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3">
                                                    <dt>대표자</dt>
                                                    <dd><?=$data['cash_ceo']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3">
                                                    <dt>이메일</dt>
                                                    <dd><?=$data['cash_email']?></dd>
                                                </dl>
                                                <dl class="d-flex flex-column gap-0 mb-0">
                                                    <dt>주소</dt>
                                                    <dd><?=$data['cash_address']?></dd>
                                                </dl>
                                            </div>

                                        </div>

                                    <?php } ?>

                                    <?php if($data['o_paymethod'] == 'vcnt' || $data['o_paymethod'] == 'fixed_vacc' ){?>

                                        <div class="card w-50">
                                            <div class="card-header">입금 계좌 정보</div>
                                            <div class="card-body">
                                                <dl class="d-flex gap-3">
                                                    <dt>입금 은행</dt>
                                                    <dd><?=$data['bank']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3">
                                                    <dt>계좌번호</dt>
                                                    <dd><?=$data['bankacct']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3">
                                                    <dt>예금주</dt>
                                                    <dd><?=$data['deposit']?></dd>
                                                </dl>
                                                <dl class="d-flex gap-3 mb-0">
                                                    <dt>입금 기한</dt>
                                                    <dd><?=view_date_format($data['vacc_limit'])?></dd>
                                                </dl>
                                            </div>

                                        </div>

                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                    <?php } ?>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#upsertFormModal').modal('hide');">닫기</button>
                <button type="button" class="btn btn-primary" onclick="fn_UpsertForm();">저장</button>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">

    $(function(){

        $('.datetimepicker-input').daterangepicker({
            autoclose: true,
            singleDatePicker: true,
            autoUpdateInput: false,
            changeYear: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: '취소',
                applyLabel:'확인'
            }
        });

        $('input[name="s_use_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="e_use_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });



        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result, status) {

                $('input[name="_csrf"]').val(result.csrf);

                //validation msg
                if(result.error_msg){
                    $.each(result.error_msg , function(k,v){
                        var html = '<span class="error invalid-feedback">'+v+'</span>';
                        $('[name="'+k+'"]').addClass('is-invalid').parent().append(html);
                    })
                }
                if(result.success){
                    //modal off
                    $('#upsertFormModal').modal('hide');
                    var msg = result.msg ? result.msg : '정상적으로 저장되었습니다.';
                    Toast.fire({
                        icon: 'success',
                        title: msg
                    });
                    getList(loc_page);
                }else if(result.msg) alert(result.msg);
            }
            , error : function (request,status,error){
                alert("처리 중 문제가 발생하였습니다\n다시시도해주세요.");
                // location.reload();
            }
        });

        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

    });

</script>


