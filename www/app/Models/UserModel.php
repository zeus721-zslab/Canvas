<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $table = 'tb_user';
    protected $primaryKey = 'id';

    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,

            // Added
            's_use_date',
            'e_use_date',
            'sns_site',
            'login_id',
            'cell_tel',
            'user_email',
            'zipcode',
            'address',
            'address_detail',
            'cmc_vcID',
//            'email_yn',
//            'sms_yn',
            'advert_yn',
            'advert_date',
            'memo',
            'updated_ip',
            'updated_id'

        ];
    }

    public function checkSnsAcc($arrayParams)
    {

        if(empty($arrayParams['login_id'])){
            return [];
        }

        $whereQueryString = " AND login_id = :login_id: ";
        $aBindParams = $arrayParams;

        $sql = "SELECT 
                *
                FROM {$this->table}
                WHERE 1
                {$whereQueryString}
                LIMIT 1;
        ";
        $oReult = $this->db->query($sql , $aBindParams);
        return $oReult->getRowArray();

    }

}