<?php
/**
 * @var int $tot_page '전체페이지'
 *
 */

?>

<style>
    main .board-wrap {width: 95%}
    main #result-list {width: 95%}
    main .board-search {width: 50%;}
    @media (min-width: 992px) {
        main .board-wrap {width: 75%}
        main #result-list {width: 75%}
        main .board-search {width: 25%;}
    }
</style>

<main>
    <div class="container-fluid w-1560 d-flex flex-column align-items-center">
        <div class="d-flex flex-column justify-content-center mb-4 board-wrap">
            <div class="mb-3">
                <h1 class="text-center">공지사항</h1>
            </div>
            <div class="d-flex justify-content-end">
                <div class="board-search input-group">
                    <input type="text" name="search_text" class="form-control" value="" title="검색단어" style="border-radius: 0;" autocomplete="off">
                    <button class="btn goSearch" type="button" style="background-color: var(--lightbrown-color);color:#fff;border-radius: 0;">검색</button>
                </div>
            </div>
        </div>

        <div id="result-list"></div>
    </div>
</main>
<?=csrf_field()?>

<script type="text/javascript">

    var loc_page    = 1;
    var total_page  = <?=$tot_page?>;

    $(function(){
        getList(loc_page);

        $('input[name="search_text"]').on('keyup',function(e){
            if( e.keyCode === 13 ) {
                // if($(this).val() === ''){
                //     alert('검색하실 단어를 입력해주세요!');
                //     return false;
                // }
                getList(1); //검색창 enter 액션
            }
        });
        $('.goSearch').on('click',function(e){
            e.preventDefault();

            var $search_text = $('input[name="search_text"]');
            // if($search_text.val() === ''){
            //     alert('검색하실 단어를 입력해주세요!');
            //     $search_text.focus();
            //     return false;
            // }
            getList(1); //검색창 enter 액션
        })

    });

    function getList(page){

        loc_page = page;

        var search_text = $('input[name="search_text"]').val();
        var _csrf       = $('input[name="_csrf"]').val();

        let data = {
              page          : page
            , search_text   : search_text
            , _csrf         : _csrf
        };

        $.ajax({
            type: 'post',
            url: '/Notice/get',
            data: data,
            dataType: 'html',
            async: false,
            success: function(result){
                $('#result-list').html(result);
            }

        });

    }

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();

        var set_page;
        if($(this).data('page_seq') === 'first') set_page = 1;
        else if($(this).data('page_seq') === 'prev') set_page = (loc_page - 1) < 1 ? 1 : (loc_page - 1);
        else if($(this).data('page_seq') === 'next') set_page = (loc_page + 1) > total_page ? total_page : (loc_page + 1);
        else if($(this).data('page_seq') === 'last') set_page = total_page;
        else set_page = $(this).data('page_seq');

        if(loc_page === set_page) return false;

        getList(set_page);

        $(window).scrollTop(0);

    });

</script>