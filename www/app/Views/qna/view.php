<?php
/**
 * @var array $aInfo '공지사항 정보'
 * @var array $aFileInfo '파일정보'
 */

?>
<?=link_src_html('/css/custom_ckeditor_view.css','css')?>
<style>
    table,tr,td,th{border-color: var(--main-color)!important;;}
    table.notice-view .content img{max-width: 100%;height: 100%;  }


    main .board-wrap > div {width: 95%}
    main .board-wrap th{ width: 20%;}
    @media (min-width: 992px) {
        main  .board-wrap > div {width: 75%}
        main .board-wrap th{ width: 10%; }
    }


</style>
<main>
    <div class="container-fluid w-1560 d-flex flex-column align-items-center board-wrap">
        <div class="d-flex flex-column justify-content-center mb-4">
            <div class="mb-5">
                <h1 class="text-center">1:1 문의</h1>
            </div>
        </div>
        <div>
            <table class="table table-bordered notice-view">
                <tr>
                    <th class="bg-main text-center">제목</th>
                    <td><?=$aInfo['title']?></td>
                </tr>
                <tr>
                    <th class="bg-main text-center">문의내용</th>
                    <td colspan="2" class="content" style="vertical-align: top">
                        <div style="min-height: 200px;">
                        <?=nl2br($aInfo['content'])?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th class="bg-main text-center">답변내용</th>
                    <td colspan="2" class="content" style="vertical-align: top">
                        <?php if($aInfo['answer']){?>
                        <div style="min-height: 200px;">
                           <?=$aInfo['answer']?>
                        </div>
                        <?php }else{?>
                        <div class="d-flex justify-content-center align-items-center text-center" style="min-height: 200px;">
                            담당자가 답변을 준비하고 있습니다.<br>잠시만 기다려주세요!
                        </div>
                        <?php }?>
                    </td>
                </tr>

            </table>

            <div class="d-flex justify-content-between gap-5">
                <button type="button" data-id="<?=$aInfo['qna_id']?>" class="text-white btn px-4 delete" style="border-radius: 0;background-color: var(--logo-red);">삭제하기</button>
                <?php if(!$aInfo['answer']){?>
                    <a href="<?=route_to('Qna::upsertForm',$aInfo['qna_id'])?>"  role="button" class="btn px-4 upsert" style="background-color: var(--lightbrown-color);color:#fff;border-radius: 0">수정하기</a>
                <?php } ?>
                <button type="button" class="btn px-4 history-back" style="border-radius: 0">목록으로 가기</button>
            </div>
        </div>
    </div>
</main>
<?=csrf_field()?>

<script type="text/javascript">

    $(function(){
        $('.history-back').on('click',function(){
            location.replace("<?=route_to('Qna::index')?>");
        });

        $('.delete').on('click',function(){

            if(confirm('문의를 삭제하시겠습니까?\n(삭제 후 복원이 불가능합니다.)')){

                var id = $(this).data('id');
                $.ajax({
                    url: "<?=route_to('Qna::delete',$aInfo['qna_id'])?>",
                    data: { _csrf : $('input[name="_csrf"]').val() , id : id },
                    method: "post",
                    dataType: "json",
                    async: false,
                    success: function (result) {
                        if(result.msg) alert(result.msg);
                        if(result.success) location.replace('<?=route_to('Qna::index')?>');
                    }
                });

            }


        });
    });

</script>