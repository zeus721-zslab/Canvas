<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{

    //tb_user 속성
    protected $attributes = [
          'login_id' => null
        , 'username' => null
        , 'status' => null
        , 'status_message' => null
        , 'active' => null , 
        
        
        // Added
        's_use_date' => null ,
        'e_use_date' => null ,
        'sns_site' => null ,
        'cell_tel' => null ,
        'user_email' => null ,
        'zipcode' => null ,
        'address' => null ,
        'address_detail' => null ,
        'cmc_vcID' => null ,
//        'email_yn' => null ,
//        'sms_yn' => null ,
        'advert_yn' => null ,
        'memo' => null ,
        'updated_ip' => null ,
        'updated_id' => null ,
        'deleted_at' => null
        
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
