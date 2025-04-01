<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Qna extends Entity
{

    //tb_qna 속성
    protected $attributes = [
          'qna_id' => null
        , 'user_id' => null
        , 'title' => null
        , 'content' => null
        , 'del_yn' => 'N'
        , 'del_date' => null
        , 'reg_id' => null
        , 'reg_ip' => null
        , 'reg_date' => null
        , 'mod_id' => null
        , 'mod_ip' => null
        , 'mod_date' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
