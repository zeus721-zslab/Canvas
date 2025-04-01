<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Payment extends Entity
{

    //tb_order 속성
    protected $attributes = [
         'order_id' => null
        ,'good_id' => null
        ,'user_id' => null
        ,'s_use_date' => null
        ,'e_use_date' => null
        ,'o_name' => null
        ,'o_email' => null
        ,'o_celltel' => null
        ,'pay_flag' => null
        ,'o_paymethod' => null
        ,'good_name' => null
        ,'amount' => null
        ,'bank' => null
        ,'bankcode' => null
        ,'bankacct' => null
        ,'deposit' => null
        ,'vacc_limit' => null
        ,'pay_date' => null
        ,'cash_receipt' => null
        ,'cash_type' => null
        ,'cash_no' => null
        ,'tno' => null
        ,'mobile' => null
        ,'memo' => null
        ,'reg_date' => null
        ,'reg_id' => null
        ,'reg_ip' => null
        ,'mod_date' => null
        ,'mod_id' => null
        ,'mod_ip' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
