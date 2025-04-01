<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Wehago extends Entity
{

    //tb_wehago_tax 속성
    protected $attributes = [
          'nIdx' => null
        , 'nOrdIdx' => null
        , 'eState' => 'Y'
        , 'eTaxType' => 'N'
        , 'vcResCode' => null
        , 'vcResMsg' => null
        , 'dtRegDate' => null
        , 'dtCanDate' => null
        , 'dtUpDate' => null
        , 'vcAdminID' => null
        , 'eFgBill' => 2
        , 'vcMmWrite' => null
        , 'vcDdWrite' => null
        , 'wTaxCompany' => null
        , 'wTaxCompNo' => null
        , 'wTaxCEO' => null
        , 'wTaxEmail' => null
        , 'wTaxAddr' => null
        , 'wTaxMobile' => null
        , 'wAdminMemo' => null
        , 'wAm' => null
        , 'wAmVat' => null
        , 'wAmt' => null
        , 'wNmItem' => null
        , 'wNoTAX' => null
        , 'wResults' => null
        , 'wcNo' => null
    ];

    public function getAttributes() : array
    {
        return $this->attributes;
    }


}
