<?php namespace App\Models;

use CodeIgniter\Model;

class CliModel extends Model
{

    /**
     * @desc 꼬망세 5분 이내 결제 대상
     * 
     */
    public function getTargetList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50) : array
    {

        $DB = db_connect('cmc');

        $sql = "SELECT vcID, vcSDate , vcEDate , dtComDate
                FROM `TblOrder`
                WHERE eGoodsType IN('M','MA','S','SA','ST','SN')
                AND ( dtComDate IS NOT NULL AND dtComDate >= DATE_ADD(NOW(), INTERVAL - 5 MINUTE)  ) ;
        ";

//        $sql = "SELECT vcID, vcSDate , vcEDate , dtComDate
//                FROM `TblOrder`
//                WHERE 1
//                AND eGoodsType IN('M','MA','S','SA','ST','SN')
//                AND vcID = 'paryh02'
//                ORDER BY dtRegDate DESC
//                LIMIT 1;
//        ";

        return $DB->query($sql)->getResultArray();

    }


}

