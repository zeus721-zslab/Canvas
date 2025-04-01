<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Board extends Entity
{

    //tb_board 속성
    protected $attributes = [
          'type' => null
        , 'title' => null
        , 'content' => null
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
