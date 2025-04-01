<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{

    //tb_group 속성
    protected $attributes = [
            'view_type' => null
        ,   'menu_type' => null
        ,   'category'  => null
        ,   'show_YM'   => null
        ,   'title'     => null
        ,   'use_flag'  => null
        ,   'seq'       => null
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
