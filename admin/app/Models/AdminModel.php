<?php namespace App\Models;

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class AdminModel extends ShieldUserModel
{
    protected $table = 'tb_admin';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username','deleted_at'
    ];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;

    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,

        ];
    }

    public function getAdminList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = " AND B.type = 'email_password' ";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] =  $s_limit;
            $aBindParams['e_limit'] =  $e_limit;
        }

        $identities_table = setting('Auth.tables')['identities'];

        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table} A
                    INNER JOIN {$identities_table} B ON A.id = B.user_id
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                        A.*
                    ,   B.secret
                    ,   B.created_at
                    FROM {$this->table} A
                    INNER JOIN {$identities_table} B ON A.id = B.user_id
                    WHERE 1 
                    {$whereQueryString}
                    {$orderbyQueryString}
                    {$limitQueryString}
            ";

            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getResultArray();
        }

        return $aResult;

    }

    public function getAdminInfo(array $arrayParams) : array
    {

        $whereQueryString  = " AND B.type = 'email_password' ";
        $aBindParams = [];
        if(isset($arrayParams['id'])) {
            $whereQueryString .= " AND A.{$this->primaryKey} = :id: ";
            $aBindParams['id'] = $arrayParams['id'];
        }

        $identities_table = setting('Auth.tables')['identities'];

        $sql = "SELECT 
                        A.*
                    ,   B.secret
                    ,   B.created_at
                FROM {$this->table} A
                INNER JOIN {$identities_table} B ON A.id = B.user_id
                WHERE 1 {$whereQueryString};
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();

        return $aResult ?? [];

    }

}

