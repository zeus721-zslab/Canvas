<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MyImg extends Entity
{

    //tb_cvs_myimg 속성
    protected $attributes = [
          'user_id'     => null
        , 'image_file'  => null
        , 'w'           => null
        , 'h'           => null
        , 'reg_date'    => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
