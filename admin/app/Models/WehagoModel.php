<?php namespace App\Models;

use App\Entities\User;
use App\Entities\Wehago;
use CodeIgniter\Model;

class WehagoModel extends Model
{
    protected $table = 'tb_wehago_tax';
    protected $primaryKey = 'nIdx';
    protected $returnType = Wehago::class;
    protected $allowedFields = ['nOrdIdx','eState','eTaxType','vcResCode','vcResMsg','dtRegDate','dtCanDate','dtUpDate','vcAdminID','eFgBill','vcMmWrite','vcDdWrite','wTaxCompany','wTaxCompNo','wTaxCEO','wTaxEmail','wTaxAddr','wTaxMobile','wAdminMemo','wAm','wAmVat','wAmt','wNmItem','wNoTAX','wResults','wcNo'];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;



}

