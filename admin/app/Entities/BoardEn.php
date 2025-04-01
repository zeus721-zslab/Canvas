<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BoardEn extends Entity
{

    //tb_board 속성
    protected $attributes = [
          'board_id' => null
        , 'type' => null
        , 'title' => null
        , 'content' => null
        , 'del_yn' => 'N'
        , 'del_date' => null 
        , 'del_id' => null
        , 'reg_ip' => null
        , 'reg_date' => null
        , 'mod_ip' => null
        , 'mod_date' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
