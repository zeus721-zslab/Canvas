<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class MyCanvas extends Entity
{

    //tb_cvs_mycvs 속성
    protected $attributes = [
          'user_id'     => null
        , 'title'       => null
        , 'thumb_file'  => null
        , 'blob_data'   => null
        , 'page'        => null
        , 'share_flag'  => 'N'
        , 'rotate'      => null
        , 'reg_date'    => null
        , 'reg_ip'      => null
        , 'reg_id'      => null
        , 'mod_date'    => null
        , 'mod_ip'      => null
        , 'mod_id'      => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
