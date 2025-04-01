<?php namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'tb_order';
    protected $primaryKey = 'idx';
    protected $returnType = User::class;
    protected $allowedFields = [ 'pay_flag','pay_date','s_use_date','e_use_date','mod_date','mod_ip','mod_id',
        'memo', 'req_cancel','req_cancel_date','req_cancel_complete','req_cancel_complete_date'
    ];
    protected $validationRules = [
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];
    protected $useTimestamps = false;


    public function getPaymentList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $aBindParams        = [];
        $whereQueryString   = "";
        $limitQueryString   = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if($arrayParams['search_text']){

            if($arrayParams['search_type']){ //선택검색
                $whereQueryString .= " AND {$arrayParams['search_type']} LIKE :search_text_like: ";
//                $aBindParams['search_type'] = $arrayParams['search_type'];
                $aBindParams['search_text_like'] = "%{$arrayParams['search_text']}%";
            }else{ //전체검색
                $whereQueryString .= " AND ( 
                        A.o_name LIKE :search_text_like:
                    OR  A.o_celltel LIKE :search_text_like: 
                    OR  B.username LIKE :search_text_like: 
                    OR  B.cell_tel LIKE :search_text_like:
                    OR  B.user_email LIKE :search_text_like:
                    OR  B.login_id LIKE :search_text_like:  
                    OR  A.order_id LIKE :search_text_like:
                )";
                $aBindParams['search_text_like'] = "%{$arrayParams['search_text']}%";
            }

        }

        if(isset($arrayParams['pay_flag'])){
            $whereQueryString .= " AND A.pay_flag LIKE :pay_flag: ";
            $aBindParams['pay_flag'] = $arrayParams['pay_flag'];
        }else{
            $whereQueryString .= " AND A.pay_flag <> 'R' ";
        }

        if(isset($arrayParams['o_paymethod'])){
            $whereQueryString .= " AND A.o_paymethod LIKE :o_paymethod: ";
            $aBindParams['o_paymethod'] = $arrayParams['o_paymethod'];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT :s_limit: , :e_limit: ";
            $aBindParams['s_limit'] =  $s_limit;
            $aBindParams['e_limit'] =  $e_limit;
        }

        if(!empty($arrayParams['req_cancel'])){
            $whereQueryString .= " AND req_cancel = :req_cancel: ";
            $aBindParams['req_cancel'] = $arrayParams['req_cancel'];
        }

        if(isset($arrayParams['isReqCancel']) && $arrayParams['isReqCancel'] == 'Y') {
            $whereQueryString .= " AND pay_flag NOT IN ('R','C') ";
            $whereQueryString .= " AND req_cancel = 'Y' ";
            $orderbyQueryString = " ORDER BY req_cancel_date DESC ";
        }


        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table} A
                    LEFT JOIN tb_user B ON A.user_id = B.id
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql , $aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                        A.*
                    ,   (SELECT username FROM tb_user B WHERE B.id = A.user_id) AS username
                    ,   (SELECT login_id FROM tb_user B WHERE B.id = A.user_id) AS login_id
                    ,   (SELECT sns_site FROM tb_user B WHERE B.id = A.user_id) AS sns_site
                    ,   (SELECT s_use_date FROM tb_user B WHERE B.id = A.user_id) AS user_s_use_date
                    ,   (SELECT e_use_date FROM tb_user B WHERE B.id = A.user_id) AS user_e_use_date
                    FROM {$this->table} A
                    LEFT JOIN tb_user B ON A.user_id = B.id
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

    public function getPaymentInfo(array $arrayParams) : array
    {

        $whereQueryString  = "";
        $aBindParams = [];
        if(isset($arrayParams['id'])) {
            $whereQueryString .= " AND {$this->primaryKey} = :id: ";
            $aBindParams['id'] = $arrayParams['id'];
        }

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString};
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();

        return $aResult ?? [];

    }

}

