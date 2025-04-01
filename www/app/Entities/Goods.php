<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Goods extends Entity
{

    //tb_cvs_myimg 속성
    protected $attributes = [
          'good_name'   => null
        , 'good_amount' => null
        , 'use_flag'    => null
        , 'reg_date'    => null
        , 'reg_id'      => null
        , 'reg_ip'      => null
        , 'mod_date'    => null
        , 'mod_id'      => null
        , 'mod_ip'      => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
