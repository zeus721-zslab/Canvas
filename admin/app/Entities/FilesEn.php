<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class FilesEn extends Entity
{

    //파일 속성
    protected $attributes = [
            'file_id'       => null
        ,   'parent_id'     => null
        ,   'loc'           => null
        ,   'f_name'        => null
        ,   'f_path'        => null
        ,   'o_f_name'      => null
        ,   'f_mime'        => null
        ,   'download_counter'  => null
        ,   'del_yn'        => null
        ,   'del_date'      => null
        ,   'del_id'        => null
        ,   'reg_date'      => null
        ,   'reg_id'        => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
