<?php

/**
 * @var array $aMrtgImg 'mrtg img string';
 * @var array $aPaymentStatic_day '매출 통계 - 일별'
 * @var array $aQnaList '답변예정 문의'
 * @var array $aCanceOrderList '취소요청 리스트'
 *
 **/
?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->

            <div class="row gap-3 gap-md-0 mb-3">

                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header bg-success text-white ">
                            <span>일 매출</span>
                            <a role="button" class="float-end text-white text-decoration-none" href="#" target="_blank">바로가기 > </a>
                        </div>
                        <div class="card-body d-flex gap-3 flex-column">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <span>트래픽</span>
                            <a role="button" class="float-end text-white text-decoration-none" href="http://61.74.195.215:8080/" target="_blank">바로가기 > </a>
                        </div>
                        <div class="card-body d-flex gap-3 flex-column">
                            <?php foreach ($aMrtgImg as $r) {?>
                                <a class="d-block text-decoration-none text-black" href="http://61.74.195.215:8080/61.74.195.215_eno1.html" target="_blank">
                                    <div class="d-flex justify-content-between gap-0 fs-7">
                                        <span><?=$r['traffic_name']?></span>
                                        <span>최종수정시간&nbsp;:&nbsp;<?=$r['last_modified']?></span>
                                    </div>
                                    <img src="<?=$r['data']?>" style="width: 100%;" alt="<?=$r['last_modified']?>" />
                                </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gap-3 gap-md-0">

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <span>답변예정 문의</span>
                            <a role="button" class="float-end text-white text-decoration-none" href="/QnaManagement">바로가기 > </a>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <?php if(empty($aQnaList)){?>
                                    <li class="text-center fs-7">
                                        답변 예정중인 문의가 없습니다.
                                    </li>
                                <?php }else{?>
                                    <?php foreach ($aQnaList as $r) {?>
                                        <li>
                                            <a href="/QnaManagement?id=<?=$r['qna_id']?>" class="text-decoration-none text-black d-flex justify-content-between fs-7 border-bottom py-2">
                                                <span><?=$r['title']?></span>
                                                <span><?=view_date_format($r['reg_date'],5)?></span>
                                            </a>
                                        </li>
                                    <?php }?>
                                <?php }?>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <span>취소요청</span>
                            <a role="button" class="float-end text-white text-decoration-none" href="/PaymentManagement/reqCancel">바로가기 > </a>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">

                                <?php if(empty($aCanceOrderList)){?>
                                    <li class="text-center fs-7">
                                        처리해야 할 취소요청이 없습니다.
                                    </li>
                                <?php }else{?>
                                    <?php foreach ($aCanceOrderList as $r) {

                                        $paymethod = '<span class="badge bg-info">고정계좌</span>';
                                        if($r['o_paymethod'] == 'card') $paymethod = '<span class="badge bg-primary">카드</span>';
                                        else if($r['o_paymethod'] == 'vcnt') $paymethod = '<span class="badge bg-warning">가상계좌</span>';
                                        else if($r['o_paymethod'] == 'phone') $paymethod = '<span class="badge bg-success">휴대폰</span>';

                                    ?>
                                        <li>
                                            <a href="/PaymentManagement/reqCancel" class="text-decoration-none text-black d-flex justify-content-between fs-7 border-bottom py-2">
                                                <span><?=$r['good_name']?>&nbsp;<?=$paymethod?>&nbsp;(&nbsp;<?=$r['o_name']?>&nbsp;/&nbsp;<?=$r['o_celltel']?>&nbsp;)</span>
                                                <span><?=view_date_format($r['req_cancel_date'],5)?></span>
                                            </a>
                                        </li>
                                    <?php }?>
                                <?php }?>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>



        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->

<?php
foreach ($aPaymentStatic_day as $r) {
    $day_arr[] = $r['pay_date_str'];
    $amount_arr[] = $r['tot_amount'];
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script type="text/javascript">

    $(function(){
        Chart.register(ChartDataLabels);
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?=json_encode($day_arr)?>,
                datasets: [{
                    label: '매출',
                    data: <?=json_encode($amount_arr)?>,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        formatter: n => numberWithCommas(n),
                        display: true, // Set to true to display the labels
                        labels: {
                            value: {
                                color: "#000"
                            }
                        }
                    }
                },
            }
        });

    });
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'원';
    }
</script>

