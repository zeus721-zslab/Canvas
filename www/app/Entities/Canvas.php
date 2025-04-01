<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Canvas extends Entity
{

    //tb_cvs_template 속성
    protected $attributes = [
            'title'     => null
        ,   'keyword'   => null
        ,   'thumb_file'=> null
        ,   'blob_data' => null
        ,   'use_flag'  => null
        ,   'hit'       => 0
        ,   'page'      => 0
        ,   'rotate'    => 'L'
        ,   'reg_date'  => null
        ,   'reg_ip'    => null
        ,   'reg_id'    => null
        ,   'mod_date'  => null
        ,   'mod_ip'    => null
        ,   'mod_id'    => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
