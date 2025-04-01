<?php namespace App\Models;

use CodeIgniter\Model;

class CmcSyncModel extends Model
{
    public function getCmcUserInfo(string $vcID)
    {

        if( $vcID == '' ){
            return false;
        }

        $whereQueryString  = " AND vcID = :vcID: ";
        $aBindParams = ['vcID' => $vcID];

        $sql = "SELECT 
                * 
                FROM TblMember 
                WHERE 1 {$whereQueryString}
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();


        return $aResult ?? [];

    }


}

