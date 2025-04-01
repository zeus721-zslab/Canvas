<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Paylog extends Entity
{

    //tb_kcp_log 속성
    protected $attributes = [
          'order_id'   => null
        , 'data' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
