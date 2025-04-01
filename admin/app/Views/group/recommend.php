<style>
    .l-contents div
    ,.r-contents div{ height: 266px;cursor: pointer;}
    .l-contents div:not(.w-100)
    ,.r-contents div:not(.w-100){width: calc(50% - 0.5rem);}
    .l-contents div:hover
    ,.r-contents div:hover{box-shadow: 0 .5rem 1rem rgba(0,0,0, .15);transition: ease-out .1s;}
    .card-body:after{display: none;}
    [data-rotate='S']{height: 380px!important;}
</style>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">이달의 추천 템플릿</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> <a href="/GroupManagement">그룹 관리</a> </li>
                        <li class="breadcrumb-item active" aria-current="page"> 이달의 추천 템플릿 </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-12 d-flex">
                    <div class="card w-100">

                        <div class="card-body d-flex gap-2 flex-column">
                            <div class="d-flex gap-2 align-items-center">
                                <label style="width: 100px;">년/월</label>
                                <select name="show_Y" class="form-control" id="show_Y" style="display: inline-block;width: 120px;" title>
                                    <?php for ($i = 2024; $i <= ((int)date('Y')+1) ; $i++) {?>
                                        <option value="<?=$i?>" <?=date('Y') == $i ? 'selected' : ''?>><?=$i?>년</option>
                                    <?php }?>
                                </select>

                                <select name="show_M" class="form-control" id="show_M" style="display: inline-block;width: 120px;" title>
                                    <?php for ($i = 1; $i <= 12 ; $i++) { $v = sprintf('%02d',$i);?>
                                        <option value="<?=$v?>" <?=date('m') == $i ? 'selected' : ''?>><?=$v?>월</option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 d-flex">
                    <div class="card p-3">
                        <div class="card-header border-bottom-0">
                            <button type="button" class="btn btn-success goSave" style="width: 100%;" >저장하기</button>
                        </div>
                        <div class="card-body d-flex" style="gap:5rem">
                            <div class="d-flex flex-wrap gap-3 l-contents" style="width: 380px;">
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="1" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="2" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="3" data-rotate="L">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="4" data-rotate="S">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="5" data-rotate="L">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="6" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="7" data-rotate="P">
                                    이미지 등록
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-3 r-contents" style="width: 380px;">
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="1" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="2" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="3" data-rotate="L">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="4" data-rotate="S">
                                    이미지 등록
                                </div>
                                <div class="w-100  border d-flex justify-content-center align-items-center p-3" data-sort="5" data-rotate="L">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="6" data-rotate="P">
                                    이미지 등록
                                </div>
                                <div class=" border d-flex justify-content-center align-items-center p-3" data-sort="7" data-rotate="P">
                                    이미지 등록
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->

<input type="hidden" name="rotate" value="" /> <!-- reference data -->
<input type="hidden" name="field" value="" /> <!-- reference data -->
<input type="hidden" name="sort" value="" /> <!-- reference data -->

<form id="upsertForm" action="/GroupManagement/recommendUpsert" method="post">
    <input type="hidden" name="group_id" value="" title="" />
    <input type="hidden" name="show_YM" value="" title="보여지는 년/월" />
    <input type="hidden" name="recommend_l1" value="" />
    <input type="hidden" name="recommend_l2" value="" />
    <input type="hidden" name="recommend_l3" value="" />
    <input type="hidden" name="recommend_l4" value="" />
    <input type="hidden" name="recommend_l5" value="" />
    <input type="hidden" name="recommend_l6" value="" />
    <input type="hidden" name="recommend_l7" value="" />
    <input type="hidden" name="recommend_r1" value="" />
    <input type="hidden" name="recommend_r2" value="" />
    <input type="hidden" name="recommend_r3" value="" />
    <input type="hidden" name="recommend_r4" value="" />
    <input type="hidden" name="recommend_r5" value="" />
    <input type="hidden" name="recommend_r6" value="" />
    <input type="hidden" name="recommend_r7" value="" />
</form>

<!-- modal -->
<div id="selectTemplate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="selectTemplate" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">템플릿 선택</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#selectTemplate').modal('hide');"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input class="form-control" name="search_text" title="" autocomplete="off">
                    <button class="btn btn-outline-info goSearch">검색</button>
                </div>
                <ul class="modal-result d-flex px-0 py-3 flex-column"></ul>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button class="btn" onclick="$('#selectTemplate').modal('hide');">닫기</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function(){

        $('.goSave').on('click',function(){
            var show_YM = $('select[name="show_Y"]').val() + $('select[name="show_M"]').val();
            $('input[name="show_YM"]').val(show_YM);
            $('#upsertForm').submit()
        });

        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            cache: false,
            success : function(result, status) {
                if(result.msg) alert(result.msg);
                // if(result.success) location.href = '/GroupManagement';
            }
        });

        $('.r-contents div , .l-contents div').on('click',function(){
            var loc = $(this).parent().hasClass('l-contents') === true ? 'l' : 'r';
            var sort = $(this).data('sort');
            var rotate = $(this).data('rotate');
            var field = loc+sort;
            $('input[name="field"]').val(field);
            $('input[name="rotate"]').val(rotate);
            $('input[name="sort"]').val(sort);

            $('#selectTemplate').modal({backdrop : 'static'}).modal('show');
        });

        $('input[name="search_text"]').on('keyup',function(e){
            if (e.keyCode === 13){
                $('.goSearch').trigger('click');
            }
        });

        $('.goSearch').on('click',function(){

            var val = $('input[name="search_text"]').val();
            if(val === ''){
                alert('검색할 단어를 입력해주세요');
                return false;
            }

            var obj = {
                    search_text: val
                ,   rotate : $('input[name="rotate"]').val()
                ,   _csrf : $('input[name="_csrf"]').val()
            };

            $.ajax({
                url: "/TemplateManagement/getList",
                data: obj,
                method: "post",
                dataType: "json",
                success: function (result) {
                    print(result.data);
                }
            });

        });

        $('#selectTemplate').on('hidden.bs.modal',function () {//animation 후 처리
            $('#selectTemplate input').val('');
            $('.modal-result').html('');
        });

        $('select[name="show_Y"]').on('change' , getGroupInfo )
        $('select[name="show_M"]').on('change' , getGroupInfo )
        getGroupInfo();

    });

    function getGroupInfo(){

        var show_YM = $('select[name="show_Y"]').val() + $('select[name="show_M"]').val();

        $.ajax({
            url: "/GroupManagement/getInfo",
            data: {show_YM : show_YM , view_type : 'recommend' , use_flag : 'Y'},
            method: "post",
            dataType: "json",
            success: function (result) {
                setGroupInfo(result.data);
            }
        });

    }

    function setGroupInfo(data){

        var $group_id = $('#upsertForm input[name="group_id"]');
        //초기화
        $group_id.val('');
        $('.r-contents > div').html('이미지 등록')
        $('.l-contents > div').html('이미지 등록')

        for(var i = 1 ; i < 8 ; i++){
            $('input[name="recommend_l'+i+'"]').val('');
            $('input[name="recommend_r'+i+'"]').val('');
        }

        if(typeof data.mapp_data !== 'undefined'){

            $group_id.val(data.group_id);

            $.each(data.mapp_data , function(k , r){
                var seq = parseInt(r.seq);

                if( seq > 7 ){ //right
                    var r_seq = seq - 7;
                    $('input[name="recommend_r'+r_seq+'"').val(r.template_id);
                    $('.r-contents > div[data-sort="'+r_seq+'"]').html('<img src="'+r.thumb_file+'" alt="'+r.title+'" class="h-100" />');

                }else{ // left
                    $('input[name="recommend_l'+seq+'"').val(r.template_id);
                    $('.l-contents > div[data-sort="'+seq+'"]').html('<img src="'+r.thumb_file+'" alt="'+r.title+'" class="h-100" />');
                }

            });

        }

    }

    function print(data){

        var html = '';

        if(data.length < 1){
            html += '<li class="text-center p-5 list-unstyled w-100">검색결과가 없습니다.</li>';
        }else{

            $.each(data,function(k,r){
                html += '<li class="d-flex gap-2 pb-2 mb-2 align-items-center justify-content-start border-bottom list-unstyled">';
                html += '   <img class="img-thumbnail" style="width: 120px;" src="'+r.thumb_file+'" alt />';
                html += '   <span>'+r.title+'</span>';
                html += '   <button class="btn btn-outline-primary selceted" data-idx="'+r.template_id+'">선택</button>';
                html += '</li>';
            });

        }

        $('.modal-result').html(html);

    }

    $(document).on('click','.selceted',function(){

        var img_path = $(this).parent().find('img').attr('src');
        var template_id = $(this).data('idx');
        var field = $('input[name="field"]').val();
        var temp = field.split('');

        $('input[name="recommend_'+field+'"]').val(template_id);
        var html = '<img src="'+img_path+'" class="h-100" alt="" />';

        $('.'+temp[0]+'-contents').find('[data-sort="'+temp[1]+'"]').html(html);

        $('#selectTemplate').modal('hide');

    });
</script>

<?=csrf_field()?>
