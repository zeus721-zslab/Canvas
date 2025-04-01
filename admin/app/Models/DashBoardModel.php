<?php namespace App\Models;

use CodeIgniter\Model;

class DashBoardModel extends Model
{

    /**
     * @var string $type 'day | week | month | year '
     *
     **/
    public function getPaymentStatic($type = 'day')
    {

        if($type == 'day'){
            $sql = "SELECT 
                        SUM(TB.amount) AS tot_amount
                    ,	TB.pay_date_str
                    ,   LEFT(TB.pay_date,8) pay_date
                    FROM (
                        SELECT 
                            *
                        ,	DATE_FORMAT(A.pay_date , '%Y-%m-%d') AS pay_date_str
                        FROM `tb_order` A
                        WHERE A.pay_date >= DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -12 DAY) , '%Y%m%d000000')
                        AND A.pay_flag = 'Y'
                    ) TB
                    GROUP BY TB.pay_date_str
            ";
        }

        return $this->db->query($sql)->getResultArray();

    }


}