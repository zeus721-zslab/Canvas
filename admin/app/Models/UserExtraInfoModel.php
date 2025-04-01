<?php namespace App\Models;

use App\Entities\UserExtraInfo;
use CodeIgniter\Model;

class UserExtraInfoModel extends Model
{
    protected $table = 'tb_user_extra';
    protected $primaryKey = 'extra_id';
    protected $returnType = UserExtraInfo::class;
    protected $allowedFields = [
        'user_id',
        'cs_memo',
        'reg_date',
        'reg_id',
        'mod_date',
        'mod_id'
    ];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;

}

