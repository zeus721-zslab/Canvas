<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

return [
    // Exceptions
    'unknownAuthenticator'  => '{0}은(는) 올바른 인증자가 아닙니다.',
    'unknownUserProvider'   => '사용할 사용자 제공자를 결정할 수 없습니다.',
    'invalidUser'           => '지정된 사용자를 찾을 수 없습니다.',
    'bannedUser'            => '현재 사용이 금지되어 있어 로그인할 수 없습니다.',
    'logOutBannedUser'      => '사용이 금지되어 로그아웃 되었습니다.',
    'badAttempt'            => '로그인할 수 없습니다. 아이디나 비밀번호를 확인해주세요.',
    'noPassword'            => '비밀번호가 없는 사용자의 유효성을 검사할 수 없습니다.',
    'invalidPassword'       => '로그인할 수 없습니다. 비밀번호를 확인해주세요.',
    'noToken'               => '모든 요청에는 {0} 헤더에 베어러 토큰이 있어야 합니다.',
    'badToken'              => '접속 토큰이 잘못되었습니다.',
    'oldToken'              => '접속 토큰이 만료되었습니다.',
    'noUserEntity'          => '비밀번호 확인을 위해 사용자 엔티티를 제공해야 합니다.',
    'invalidEmail'          => '기록 중인 이메일과 일치하는 이메일 주소를 확인할 수 없습니다.',
    'unableSendEmailToUser' => '죄송합니다. 이메일을 보내는 중 문제가 발생했습니다. {0}(으)로 이메일을 보낼 수 없습니다.',
    'throttled'             => '이 IP 주소에서 요청이 너무 많습니다. {0}초 후에 다시 시도할 수 있습니다.',
    'notEnoughPrivilege'    => '원하는 작업을 수행하는 데 필요한 권한이 없습니다.',
    // JWT Exceptions
    'invalidJWT'     => '토큰이 잘못되었습니다.',
    'expiredJWT'     => '토큰이 만료되었습니다.',
    'beforeValidJWT' => '아직 토큰을 사용할 수 없습니다.',

    'email'           => '이메일',
    'username'        => '이름',
    'login_id'        => '아이디',
    'password'        => '비밀번호',
    'passwordConfirm' => '비밀번호확인',
    'haveAccount'     => '이미 아이디가 있나요?',
    'token'           => '토큰',

    // Buttons
    'confirm' => '확인',
    'send'    => '보내기',

    // Registration
    'register'         => '회원가입',
    'registerDisabled' => '현재 등록이 불가능합니다.',
    'registerSuccess'  => '어서 오세요!',

    // Login
    'login'              => '로그인',
    'needAccount'        => '아이디가 필요하신가요?',
    'rememberMe'         => '로그인 유지',
    'forgotPassword'     => '비밀번호를 잊어버렸나요?',
    'useMagicLink'       => '로그인링크 사용',
    'magicLinkSubject'   => '로그인 링크',
    'magicTokenNotFound' => '링크를 확인할 수 없습니다.',
    'magicLinkExpired'   => '죄송합니다. 링크가 만료되었습니다.',
    'checkYourEmail'     => '메일 확인!',
    'magicLinkDetails'   => '로그인 링크가 포함된 이메일을 방금 보냈습니다. {0}분 동안만 유효합니다.',
    'magicLinkDisabled'  => 'MagicLink는 현재 사용할 수 없습니다.',
    'successLogout'      => '로그아웃에 성공했습니다.',
    'backToLogin'        => '로그인으로 돌아가기',

    // Passwords
    'errorPasswordLength'       => '비밀번호는 {0, number}자 이상이어야 합니다.',
    'suggestPasswordLength'     => '최대 255자 길이의 암호 문구를 사용하면 기억하기 쉽고 더욱 안전한 암호를 만들 수 있습니다.',
    'errorPasswordCommon'       => '비밀번호는 일반 비밀번호가 아니어야 합니다.',
    'suggestPasswordCommon'     => '일반적으로 사용되는 65,000개 이상의 비밀번호 또는 해킹을 통해 유출된 비밀번호와 비교하여 비밀번호를 확인했습니다.',
    'errorPasswordPersonal'     => '비밀번호에는 개인 정보가 포함될 수 없습니다.',
    'suggestPasswordPersonal'   => '이메일 주소나 사용자 이름을 변형하여 비밀번호로 사용해서는 안 됩니다.',
    'errorPasswordTooSimilar'   => '비밀번호가 사용자 이름과 너무 유사합니다.',
    'suggestPasswordTooSimilar' => '비밀번호에 사용자 이름의 일부를 사용하지 마세요.',
    'errorPasswordPwned'        => '데이터 유출로 인해 비밀번호 {0}이(가) 노출되었으며 유출된 비밀번호 중 {2}에서 {1, number}번 확인되었습니다.',
    'suggestPasswordPwned'      => '{0}은(는) 비밀번호로 사용되어서는 안 됩니다. 어디에서나 사용하는 경우 즉시 변경하십시오.',
    'errorPasswordEmpty'        => '비밀번호가 필요합니다.',
    'errorPasswordTooLongBytes' => '비밀번호는 {param} bytes 를 넘을 수 없습니다.',
    'passwordChangeSuccess'     => '비밀번호가 성공적으로 변경되었습니다.',
    'userDoesNotExist'          => '비밀번호가 변경되지 않았습니다. 사용자가 존재하지 않습니다',
    'resetTokenExpired'         => '죄송합니다. 재설정 토큰이 만료되었습니다.',

    // Email Globals
    'emailInfo'      => '몇 가지 정보:',
    'emailIpAddress' => 'IP Address:',
    'emailDevice'    => 'Device:',
    'emailDate'      => 'Date:',

    // 2FA
    'email2FATitle'       => '2단계 인증',
    'confirmEmailAddress' => '이메일 주소를 확인하세요.',
    'emailEnterCode'      => '이메일을 확인하세요',
    'emailConfirmCode'    => '방금 귀하의 이메일 주소로 전송된 6자리 코드를 입력하세요.',
    'email2FASubject'     => '귀하의 인증 코드',
    'email2FAMailBody'    => '귀하의 인증코드는 다음과 같습니다 :',
    'invalid2FAToken'     => '코드가 잘못되었습니다.',
    'need2FA'             => '2단계 인증을 완료해야 합니다.',
    'needVerification'    => '이메일을 확인하여 계정 활성화를 완료하세요.',

    // Activate
    'emailActivateTitle'    => '이메일 활성화',
    'emailActivateBody'     => '귀하의 이메일 주소를 확인하기 위한 코드가 포함된 이메일을 방금 보내드렸습니다. 해당 코드를 복사하여 아래에 붙여넣으세요.',
    'emailActivateSubject'  => '귀하의 활성화 코드',
    'emailActivateMailBody' => '아래 코드를 사용하여 계정을 활성화하고 사이트 사용을 시작하세요.',
    'invalidActivateToken'  => '코드가 잘못되었습니다.',
    'needActivate'          => '이메일 주소로 전송된 코드를 확인하여 등록을 완료해야 합니다.',
    'activationBlocked'     => '로그인하기 전에 계정을 활성화해야 합니다.',

    // Groups
    'unknownGroup' => '{0}은(는) 유효한 그룹이 아닙니다.',
    'missingTitle' => '그룹에는 제목이 있어야 합니다.',

    // Permissions
    'unknownPermission' => '{0}은(는) 유효한 권한이 아닙니다.',
];
