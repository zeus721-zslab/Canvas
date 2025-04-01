<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Clip extends Entity
{

    //tb_clip 속성
    protected $attributes = [
          'title' => null
        , 'keyword' => null
        , 'category' => null
        , 'file_mime' => null
        , 'thumb_file' => null
        , 'save_file' => null
        , 'svg_file' => null
        , 'org_file' => null
        , 'file_size' => 0
        , 'hit' => 0
        , 'use_flag' => null
        , 'reg_date' => null
        , 'reg_ip' => null
        , 'reg_id' => null
        , 'mod_date' => null
        , 'mod_ip' => null
        , 'mod_id' => null
        //, 'old_pk' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
