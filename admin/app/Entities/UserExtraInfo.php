<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserExtraInfo extends Entity
{

    //tb_user_extra 속성
    protected $attributes = [
            'user_id'   => 0
        ,   'cs_memo'   => null
        ,   'reg_date'  => null
        ,   'reg_id'    => null
        ,   'mod_date'  => null
        ,   'mod_id'    => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
