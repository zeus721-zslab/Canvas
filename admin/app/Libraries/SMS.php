<?php
namespace App\Libraries;

class SMS
{

    /**
     * @var string $send_data['send_date'] '발송일'
     * @var string $send_data['DEST_INFO'] '수신자이름&연락처' //연락처는 숫자만
     * @var string $send_data['msg'] '메시지'
     */
    public function sendSMS(array $arrayParams) : bool
    {

        $sms_db = db_connect('sms');

        $aBindParams = [
                "USER_ID"		=> "edupre3497"
            ,   "SCHEDULE_TYPE"	=> ($arrayParams['send_date'] > date('YmdHis')) ? "1":"0"
            ,   "SEND_DATE"		=> $arrayParams['send_date']
            ,   "DEST_INFO"		=> $arrayParams['DEST_INFO']
            ,   "SMS_MSG"		=> $arrayParams['msg']
            ,   "RESERVED1"		=> "KINDER_CANVAS"
        ];

        $sql = "INSERT INTO `SDK_SMS_SEND`
                SET
                    USER_ID = :USER_ID:
                ,   SCHEDULE_TYPE = :SCHEDULE_TYPE:
                ,   SMS_MSG = :SMS_MSG:
                ,   NOW_DATE = DATE_FORMAT(NOW(),'%Y%m%d%H%i%s')
                ,   SEND_DATE = :SEND_DATE:
                ,   CALLBACK = '1588-1978'
                ,   DEST_COUNT = 1
                ,   DEST_INFO = :DEST_INFO:
                ,   RESERVED1 = :RESERVED1:
        ";

        return $sms_db->query($sql, $aBindParams);

    }

    /**
     * @var string $send_data['send_date'] '발송일'
     * @var string $send_data['DEST_INFO'] '수신자이름&연락처' //연락처는 숫자만
     * @var string $send_data['msg'] '메시지'
     * @var string $send_data['SUBJECT'] '제목'
     */
    public function sendMMS(array $arrayParams) : bool
    {

        $sms_db = db_connect('sms');

        $aBindParams = [
                "USER_ID"		=> "edupre3497"
            ,   "SCHEDULE_TYPE"	=> ($arrayParams['send_date'] > date('YmdHis')) ? "1":"0"
            ,   "SUBJECT"       => $arrayParams['SUBJECT']
            ,   "SEND_DATE"		=> $arrayParams['send_date']
            ,   "DEST_INFO"		=> $arrayParams['DEST_INFO']
            ,   "MMS_MSG"		=> $arrayParams['msg']
            ,   "RESERVED1"		=> "KINDER_CANVAS"
        ];

        $sql = "INSERT INTO `SDK_MMS_SEND`
                SET
                    USER_ID = :USER_ID:
                ,   SCHEDULE_TYPE = :SCHEDULE_TYPE:
                ,   SUBJECT = :SUBJECT:
                ,   MMS_MSG = :MMS_MSG:
                ,   NOW_DATE = DATE_FORMAT(NOW(),'%Y%m%d%H%i%s')
                ,   SEND_DATE = :SEND_DATE:
                ,   CALLBACK = '1588-1978'
                ,   DEST_COUNT = 1
                ,   DEST_INFO = :DEST_INFO:
                ,   RESERVED1 = :RESERVED1:
        ";

        return $sms_db->query($sql, $aBindParams);

    }


}