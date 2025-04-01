<?php
/**
 * @date 240628
 * @modify 황기석
 * @desc redirect로 이동시 session error 데이터를 전달
 */
$alert_msg = '';
if (is_array(session('errors'))) :
    foreach (session('errors') as $error) :
        $alert_msg .= $error."\n";
    endforeach;
else :
    $alert_msg = session('errors');
endif;

if($alert_msg) alert_script($alert_msg);
?>

<script type="text/javascript">
    function win_open(href){
        let win = window.open("","_blank");
        win.location.href = href;
    }
    $(document).on('click' , '.goCanvas' ,function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        win_open(href);
    })

    $(document).on('click' , '.goBack' ,function(e){
        e.preventDefault();
        history.back();
    })
    var paid_user = '<?=session('isPay') ? 'Y' : 'N' ?>';
</script>
</script>

<!-- 동적처리를 위한 iframe -->
<iframe name='hiddenFrame' id="hiddenFrame" width='0' height='0' style="display: none;"></iframe>

</body>




</html>
