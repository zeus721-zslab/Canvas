<?php /** @var string $token '토큰' */ ?>
<html>
<body onload="document.getElementById('ssoFrm').submit();">
    <form id="ssoFrm" method="post" action="/auth/a/verify">
        <input type="hidden" name="token" value="<?=$token?>" />
    </form>
</body>
</html>