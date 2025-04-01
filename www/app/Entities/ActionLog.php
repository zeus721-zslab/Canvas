<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ActionLog extends Entity
{

    //tb_action_log 속성
    protected $attributes = [
          'alog_id' => null
        , 'type' => null
        , 'template_id' => 0
        , 'my_canvas_id' => 0
        , 'clip_id' => 0
        , 'reg_id' => null
        , 'reg_ip' => null
        , 'reg_date' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
