<style>
        .ok-sort-list li:hover
    ,   .no-sort-list li:hover {background-color: #f8f8f8;}
    .ok-sort-list li {cursor: move;}
</style>


<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">그룹 정렬</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> <a href="/GroupManagement">그룹 관리</a> </li>
                        <li class="breadcrumb-item active" aria-current="page"> 정렬순서 변경 </li>
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

                        <form name="upsertForm" id="upsertForm" method="post" action="/GroupManagement/upsert_sort">
                            <?=csrf_field()?>
                            <input type="hidden" name="ok_list" value="" />
                            <input type="hidden" name="no_list" value="" />

                            <div class="card-body d-flex gap-2 flex-column">
                                <div class="d-flex gap-2 align-items-center">
                                    <label for="view_type" style="width: 100px;">보이는 영역</label>
                                    <select name="view_type" class="form-control" id="view_type" style="display: inline-block;width: 120px;" title>
                                        <option value="canvas">캔버스</option>
                                        <option value="menu">메뉴</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2 align-items-center category-wrap">
                                    <label for="category" style="width: 100px;">정렬 카테고리</label>
                                    <select name="category" class="form-control" id="category" style="display: inline-block;width: 120px;" title>
                                        <option value="template">템플릿</option>
                                        <option value="clip">클립</option>
                                        <option value="bg">배경</option>
                                    </select>
                                </div>

                                <div class="d-none gap-2 align-items-center menu-type-wrap">
                                    <label for="menu_type" style="width: 100px;">메뉴타입</label>
                                    <select name="menu_type" class="form-control" id="menu_type" style="display: inline-block;width: 120px;" title>
                                        <option value="month">월별디자인</option>
                                        <option value="event">행사</option>
                                        <option value="play">놀이</option>
                                        <option value="env">환경구성</option>
                                        <option value="notice">안내문</option>
                                    </select>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-3">
                    <div class="card">
                        <div class="card-header text-center"> 순서정렬x </div>
                        <div class="card-body">
                            <ul class="d-flex flex-column no-sort-list px-3 list-unstyled"> </ul>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-header text-center"> 순서정렬o </div>
                        <div class="card-body">
                            <ul class="d-flex flex-column ok-sort-list px-3 list-unstyled"> </ul>
                        </div>
                    </div>
                </div>
                <div class="col-1 d-flex flex-column gap-3">
                    <button class="btn btn-success py-3" type="button">저장</button>
                    <a role="button" href="/GroupManagement" class="btn btn-outline-warning btn-xs" type="button">목록</a>
                </div>
            </div>

        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->

<script type="text/javascript">
    var html_no_def  = '<li class="p-2 d-flex align-items-center justify-content-center no-data">';
        html_no_def += '순서정렬을 안하는 그룹이 없습니다.';
        html_no_def += '</li>';

    var html_ok_def  = '<li class="p-2 d-flex align-items-center justify-content-center no-data">';
        html_ok_def += '순서정렬을 하는 그룹이 없습니다.';
        html_ok_def += '</li>';

    $(document).on('click','.sort_move',function(){
        var act = $(this).data('act');
        var html = $(this).parent().parent().get(0);

        if(act === 'to_ok') {

            $(html).find('.sort_move').data('act' , 'to_no').attr('data-act' , 'to_no').html('<i class="fa-solid fa-angles-left" aria-hidden="true"></i>');

            if( $('.ok-sort-list').find('li.no-data').length > 0 ) $('.ok-sort-list').html(html);
            else $('.ok-sort-list').prepend(html); // to ok

            if($('.no-sort-list li').length < 1) $('.no-sort-list').html(html_no_def);

        } else {

            $(html).find('.sort_move').data('act' , 'to_ok').attr('data-act' , 'to_ok').html('<i class="fa-solid fa-angles-right" aria-hidden="true"></i>');

            if( $('.no-sort-list').find('li.no-data').length > 0 ) $('.no-sort-list').html(html);
            else $('.no-sort-list').prepend(html); // to no

            if($('.ok-sort-list li').length < 1) $('.ok-sort-list').html(html_ok_def);

        }

        setSortable();

    });

    $(function(){
        getList();
        $('select[name="category"]').on('change', getList );
        $('select[name="menu_type"]').on('change', getList );
        $('select[name="view_type"]').on('change', function(){

            $('.menu-type-wrap').toggleClass('d-flex').toggleClass('d-none');
            $('.category-wrap').toggleClass('d-flex').toggleClass('d-none');
            if( $(this).val() === 'menu' ) $('select[name="category"]').val('template')

            getList();

        } );


        $('.btn-success').on('click',function(){

            if(!confirm('해당 순서를 저장하시겠습니까?')) return false;

            var ok_obj = $('.ok-sort-list');
            var no_obj = $('.no-sort-list');

            if(ok_obj.find('li').length < 1 && no_obj.find('li').length < 1){
                alert("저장할 데이터가 없습니다.\n그룹생성 후 진행해주세요!");
                return false;
            }

            var ok_arr = [] , no_arr = [];
            if(ok_obj.find('li:not(.no-data)').length > 0){
                ok_obj.find('li:not(.no-data)').each(function(){
                    ok_arr.push($(this).data('group_id'));
                });
            }
            if(no_obj.find('li:not(.no-data)').length > 0){
                no_obj.find('li:not(.no-data)').each(function(){
                    no_arr.push($(this).data('group_id'));
                });
            }

            var ok_str = JSON.stringify(ok_arr);
            var no_str = JSON.stringify(no_arr);

            $('input[name="ok_list"]').val(ok_str);
            $('input[name="no_list"]').val(no_str);

            $('#upsertForm').submit();

        });

        $('#upsertForm').ajaxForm({
            type: 'post',
            dataType: 'json',
            async: false,
            cache: false,
            success : function(result) {
                if(result.msg) alert(result.msg);
                if(result.success){
                    location.replace('/GroupManagement');
                }
            }
        });

    });

    function getList(){
        var category = $('select[name="category"]').val();
        var view_type = $('select[name="view_type"]').val();
        var menu_type = $('select[name="menu_type"]').val();
        $.ajax({
            url : '/GroupManagement/getSortGroup',
            type : 'post',
            data : { category : category , view_type : view_type , menu_type : menu_type},
            dataType : 'json',
            success : function(result){
                print_list(result.data);
            }

        });
    }

    function print_list(data){

        var html_ok = '' , html_no = '';

        $.each(data , function(k,r){
            if( r.seq == '999' ){ //no
                html_no += '<li class="p-2 d-flex justify-content-between align-items-center border-bottom" data-group_id="'+r.group_id+'">';
                html_no += '    <span>'+r.title+'<span class="fs-8">( 그룹ID : '+r.group_id+' )</span></span>';
                html_no += '    <div class="d-flex gap-2">';
                html_no += '        <button type="button" class="btn btn-xs btn-primary py-1 sort_move" data-act="to_ok"><i class="fa-solid fa-angles-right"></i></button>';
                html_no += '    </div>';
                html_no += '</li>';
            }else{ //ok
                html_ok += '<li class="p-2 d-flex justify-content-between align-items-center border-bottom" data-group_id="'+r.group_id+'">';
                html_ok += '    <span>'+r.title+'<span class="fs-8">( 그룹ID : '+r.group_id+' )</span></span>';
                html_ok += '    <div class="d-flex gap-2">';
                html_ok += '        <button type="button" class="btn btn-xs btn-primary py-1 sort_move" data-act="to_no"><i class="fa-solid fa-angles-left"></i></button>';
                html_ok += '    </div>';
                html_ok += '</li>';
            }
        })

        if(html_no === '') html_no = html_no_def;
        if(html_ok === '') html_ok = html_ok_def;

        $('.no-sort-list').html(html_no);
        $('.ok-sort-list').html(html_ok);

        setSortable();
    }

    function setSortable(){
        $('.ok-sort-list').sortable({
            axis: 'y',
            opacity: 0.5,
            tolerance: 'pointer' // 이동 중인 항목이 마우스 포인터 기준으로 다른 항목 위에 있는지 확인
        });
    }

</script>

<?=csrf_field()?>
