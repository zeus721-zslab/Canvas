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


    .board-wrap > div {width: 95%}
    #result-list {width: 95%}
    .board-search {width: 50%;}
    @media (min-width: 992px) {
        .board-wrap > div {width: 75%}
        #result-list {width: 75%}
        .board-search {width: 25%;}
    }


</style>
<main>
    <div class="container-fluid w-1560 d-flex flex-column align-items-center board-wrap">
        <div class="d-flex flex-column justify-content-center mb-4">
            <div class="mb-5">
                <h1 class="text-center">공지사항</h1>
            </div>
        </div>
        <div>
            <table class="table table-bordered notice-view">
                <tr>
                    <th class="bg-main text-center">제목</th>
                    <td colspan="3"><?=$aInfo['title']?></td>
                </tr>
                <tr>
                    <?php if($aFileInfo){?>
                    <th style="width: 120px;" class="bg-main text-center">첨부파일</th>
                    <td>
                        <a data-id="<?=$aFileInfo['file_id']?>" class="d-flex gap-2 align-items-lg-center zs-cp fileDownload flex-column flex-lg-row">
                            <i class="fas fa-paperclip d-none d-lg-inline-block"></i>
                            <span><?=$aFileInfo['o_f_name']?></span>
                            <span>(<?=number_to_size($aFileInfo['f_size'])?>)<span>
                        </a>
                    </td>
                    <?php }?>
                    <th style="width: 120px;" class="bg-main text-center d-none d-lg-table-cell">등록일</th>
                    <td class="d-none d-lg-table-cell"><?=view_date_format($aInfo['reg_date'])?></td>
                </tr>
                <tr class="d-lg-none d-table-row">
                    <th style="width: 120px;" class="bg-main text-center">등록일</th>
                    <td colspan="3"><?=view_date_format($aInfo['reg_date'])?></td>
                </tr>
                <tr>
                    <td colspan="4" class="content ck-content" style="min-height: 150px;height: 150px;vertical-align: top"><?=$aInfo['content']?></td>
                </tr>
            </table>
            <div class="d-flex justify-content-end">
                <button class="btn px-4 history-back" style="background-color: var(--lightbrown-color);color:#fff;border-radius: 0">목록</button>
            </div>
        </div>
    </div>
</main>
<?=csrf_field()?>

<script type="text/javascript">

    $(function(){
        $('.history-back').on('click',function(){
            history.back();
        });
        $('.fileDownload').on('click',function(){
            single_download(this);
        })
    });

</script>