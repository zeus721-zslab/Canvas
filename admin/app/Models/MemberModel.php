<?php namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'tb_member';
    protected $primaryKey = 'member_id';
    protected $returnType = User::class;
    protected $allowedFields = [ 'name' , 'reg_date', 'mod_date'];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];


}

