<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Order extends Entity
{

    //tb_order 속성
    protected $attributes = [
          'order_id' => null
        , 'good_id' => null
        , 'user_id' => null
        , 'o_name' => null
        , 'o_email' => null
        , 'o_celltel' => null
        , 'pay_flag' => null
        , 'o_paymethod' => null
        , 'bank' => null
        , 'bankcode' => null
        , 'bankacct' => null
        , 'deposit' => null
        , 'vacc_limit' => null
        , 'pay_date' => null
        , 'cash_receipt' => null
        , 'cash_type' => 2
        , 'cash_no' => null
        , 'cash_name' => null
        , 'cash_ceo' => null
        , 'cash_email' => null
        , 'cash_address' => null
        , 'tno' => null
        , 'reg_date' => null
        , 'reg_id' => null
        , 'reg_ip' => null
        , 'mod_date' => null
        , 'mod_id' => null
        , 'mod_ip' => null

    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
