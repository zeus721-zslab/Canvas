<?php
/**
 * @var string $title 'form 제목'
 * @var array $data '데이터'
 * @var boolean $isUpdate 'update 여부'
 *
 */

?>

<div id="upsertFormModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="upsertFormModal" aria-hidden="true">
    <div class="modal-dialog modal-xxl">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?=$title?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#upsertFormModal').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <form id="upsertForm" name="upsertForm" action="/GroupManagement/upsert" method="post" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <input type="hidden" name="group_id" value="<?=$data['group_id']?>">
                    <input type="hidden" name="ok_arr" value="">
                    <input type="hidden" name="no_arr" value="">

                    <div class="container-fluid">
                        <div class="row">

                            <!-- 기본정보 -->
                            <div class="col-4">


                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 보이는 영역</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-3">
                                            <div class="d-flex gap-2">
                                                <input type="radio" name="view_type" id="view_type_canvas" value="canvas" title="view_type" <?=$data['view_type'] == 'canvas' ? 'checked': ''?> />
                                                <label for="view_type_canvas">캔버스</label>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <input type="radio" name="view_type" id="view_type_menu" value="menu" title="view_type" <?=$data['view_type'] == 'menu' ? 'checked': ''?> />
                                                <label for="view_type_menu">메뉴</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-9 px-3 py-1 offset-3" >
                                        <div class="view_type_example overflow-hidden p-2" style="height: 150px;border: 1px solid #aaa;border-radius: 5px;">
                                            <?php if(!empty($data['view_type'])){?>
                                                <img src="/images/group_view_type_<?=$data['view_type']?>.jpg" style="width: 100%;" />
                                            <?php } else {?>
                                                <img src="https://placehold.co/300x150?text=NO_IMG" style="width: 100%;" />

                                            <?php }?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 menu-type-wrap" style="<?=$data['view_type'] != 'menu' ? 'display: none;' : '' ?>">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 메뉴 영역</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="d-flex gap-2">
                                            <?php if($isUpdate && $data['menu_type'] == 'month'){ // 월별디자인은 등록불가 / 월별디자인인 경우 menu_type 변경불가 ?>
                                            <div class="d-flex gap-1">
                                                <input type="radio" name="menu_type" id="menu_type_month" value="month" title="menu_type" <?=$data['menu_type'] == 'month' ? 'checked': ''?> />
                                                <label for="menu_type_month">월별디자인</label>
                                            </div>
                                            <?php } ?>

                                            <?php if($data['menu_type'] != 'month'){?>
                                            <div class="d-flex gap-1">
                                                <input type="radio" name="menu_type" id="menu_type_event" value="event" title="menu_type" <?=$data['menu_type'] == 'event' ? 'checked': ''?> />
                                                <label for="menu_type_event">행사</label>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <input type="radio" name="menu_type" id="menu_type_play" value="play" title="menu_type" <?=$data['menu_type'] == 'play' ? 'checked': ''?> />
                                                <label for="menu_type_play">놀이</label>
                                            </div>

                                            <div class="d-flex gap-1">
                                                <input type="radio" name="menu_type" id="menu_type_env" value="env" title="menu_type" <?=$data['menu_type'] == 'env' ? 'checked': ''?> />
                                                <label for="menu_type_env">환경구성</label>
                                            </div>

                                            <div class="d-flex gap-1">
                                                <input type="radio" name="menu_type" id="menu_type_notice" value="notice" title="menu_type" <?=$data['menu_type'] == 'notice' ? 'checked': ''?> />
                                                <label for="menu_type_notice">안내문</label>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 카테고리</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="category" class="form-control" title>
                                            <option value="clip" <?=$data['view_type'] == 'menu' ? 'disabled' : '' ?>  <?php if($data['category'] == 'clip'){?>selected<?php }?>>클립</option>
                                            <option value="bg" <?=$data['view_type'] == 'menu' ? 'disabled' : '' ?> <?php if($data['category'] == 'bg'){?>selected<?php }?>>배경</option>
                                            <option value="template" <?php if($data['category'] == 'template'){?>selected<?php }?>>템플릿</option>
                                        </select>
                                    </div>

                                    <div class="col-md-9 offset-3">
                                        <p class="callout callout-danger fs-8 m-0 p-2 mb-2">
                                            &middot;&nbsp;카테고리를 변경하는 경우 기존에 등록된 컨텐츠가 초기화 됩니다.<br>
                                            &middot;&nbsp;변경은 저장을 했을 경우 반영이 됩니다.<br>
                                            &nbsp;&nbsp;&nbsp;( 카테고리를 변경했다하여 바로 저장된 컨텐츠가 초기화되지 않음 )
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 제목</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="title" class="form-control form-control-border" placeholder="제목" value="<?=$data['title']?>" title="title" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label><i title="필수입력" class="nav-icon far fa-circle text-danger"></i> 사용여부</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="use_flag" class="form-control" title>
                                            <option value="Y" <?php if($data['use_flag'] == 'Y'){?>selected<?php }?>>사용함</option>
                                            <option value="N" <?php if($data['use_flag'] == 'N'){?>selected<?php }?>>사용안함</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label>노출 순서</label>
                                    </div>
                                    <div class="col-md-9">
                                        <?=$data['seq'] == 999 ? '순서적용안됨' : $data['seq'] ?>
                                    </div>
                                    <div class="col-md-9 offset-3">
                                        <p class="callout callout-danger fs-8 m-0 p-2 mb-2">
                                            &middot;&nbsp;오름차순<br>
                                            &middot;&nbsp;같은 수인 경우 먼저 등록된 순으로 노출
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3 d-flex align-items-center justify-content-end">
                                        <label>컨텐츠 추가하기</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group input-group-sm">
                                            <input name="form-search-text" class="form-control" value="" placeholder="검색단어를 입력해주세요." title autocomplete="off" />
                                            <button class="btn btn-success go-form-search" type="button">검색하기</button>
                                        </div>
                                    </div>

                                    <div class="col-md-9 offset-3 mt-2">
                                        <ul class="search-result d-flex flex-column p-2 border gap-2" style="max-height: 300px;overflow-y: auto;border-radius: 5px">
                                            <li class="d-flex justify-content-center fs-7">검색어를 입력해주세요!</li>
                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <!-- 순서 미등록 컨텐츠 / seq = 99 -->
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header mb-2"> 순서 미등록 컨텐츠 </div>

                                    <ul class="d-flex flex-column no-sort-list px-3">
                                    <?php if(count($aList) > 0){ ?>
                                        <?php foreach ($aList as $r) {?>
                                            <?php if($r['seq'] == 999){?>
                                                <li class="d-flex flex-row align-items-center border-bottom py-2  gap-2" style="<?=in_array($r['use_flag'],['I','N'])?'background-color:#f1aeb5':''?>" data-use_flag="<?=$r['use_flag']?>" data-id="<?=isset($r['clip_id']) ? $r['clip_id'] : $r['template_id']?>">
                                                    <img src="<?=$r['thumb_file']?>" class="img-thumbnail" alt style="height: 50px"  />
                                                    <div class="d-flex justify-content-between w-100 align-items-centerga">
                                                        <span><?=$r['title']?></span>
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-xs btn-danger py-1 remove-content"><i class="fa-solid fa-xmark"></i></button>
                                                            <button type="button" class="btn btn-xs btn-info py-1 sort_move" data-act="to_ok"><i class="fa-solid fa-angles-right"></i></button>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- 순서 등록 컨텐츠 / 오름차순 처리-->
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header mb-2"> 순서 등록 컨텐츠 </div>
                                    <ul class="d-flex flex-column ok-sort-list px-3">
                                        <?php if(count($aList) > 0){?>
                                            <?php foreach ($aList as $r) {?>
                                                <?php if($r['seq'] < 999){?>
                                                    <li class="d-flex flex-row align-items-center border-bottom py-2  gap-2" style="<?=in_array($r['use_flag'],['I','N'])?'background-color:#f1aeb5':''?>" data-use_flag="<?=$r['use_flag']?>" data-id="<?=isset($r['clip_id']) ? $r['clip_id'] : $r['template_id']?>">
                                                        <img src="<?=$r['thumb_file']?>" class="img-thumbnail" alt style="height: 50px" />
                                                        <div class="d-flex justify-content-between w-100 align-items-center">
                                                            <span><?=$r['title']?></span>
                                                            <div class="d-flex gap-2">


                                                                <?php if($r['paid_yn'] == 'Y'){?>
                                                                    <button type="button" class="btn btn-xs btn-outline-primary py-1 change-paid" data-paid_yn="<?=$r['paid_yn']?>" data-id="<?=$r['template_id']?>">유료</button>
                                                                <?php }else {?>
                                                                    <button type="button" class="btn btn-xs btn-success py-1 change-paid" data-paid_yn="<?=$r['paid_yn']?>" data-id="<?=$r['template_id']?>">무료</button>
                                                                <?php }?>

                                                                <button type="button" class="btn btn-xs btn-danger py-1 remove-content"><i class="fa-solid fa-xmark"></i></button>
                                                                <button type="button" class="btn btn-xs btn-info py-1 sort_move" data-act="to_no"><i class="fa-solid fa-angles-left"></i></button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#upsertFormModal').modal('hide');">닫기</button>
                <button type="button" class="btn btn-primary" onclick="fn_UpsertForm();">저장</button>
            </div>

        </div>
    </div>
</div>

<style>
        .ok-sort-list li:hover
    ,   .no-sort-list li:hover {background-color: #f8f8f8;}
</style>
<script type="text/javascript">

    var prev_category;

    $(function(){

        //초기 카테고리 정보
        prev_category = $('#upsertForm select[name="category"]').val();

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
        });

        $('input[name="_csrf"]').val('<?=csrf_hash()?>');

        $('input[name="view_type"]').on('change',function(){

            var val = $(this).val();

            let file = '/images/group_view_type_'+val+'.jpg';
            $('.view_type_example img').attr('src',file);

            if(val === 'menu') {
                $('.menu-type-wrap').show();
                $('select[name="category"] option[value="template"]').prop('selected',true);
                $('select[name="category"] option[value="bg"]').prop('disabled',true);
                $('select[name="category"] option[value="clip"]').prop('disabled',true);
            }
            else {
                $('.menu-type-wrap').hide();
                $('select[name="category"] option[value="bg"]').prop('disabled',false);
                $('select[name="category"] option[value="clip"]').prop('disabled',false);
            }

        });

        setSortable();

    });

</script>


