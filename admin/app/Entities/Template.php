<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Template extends Entity
{

    //tb_cvs_template 속성
    protected $attributes = [
          'title' => null
        , 'keyword' => null
        , 'thumb_file' => null
        , 'blob_data' => null
        , 'use_flag' => 'N'
        , 'hit' => 0
        , 'page' => 0
        , 'rotate' => null
        , 'paid_yn' => null
        , 'reg_date' => null
        , 'reg_ip' => null
        , 'reg_id' => null
        , 'mod_date' => null
        , 'mod_ip' => null
        , 'mod_id' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
