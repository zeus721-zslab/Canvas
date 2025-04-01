<?php namespace App\Models;

use App\Entities\FilesEn;
use CodeIgniter\Model;

class FileModel extends Model
{
    protected $table = 'tb_files';
    protected $primaryKey = 'file_id';
    protected $returnType = FilesEn::class;
    protected $allowedFields = [ 'parent_id' , 'loc' , 'f_name' , 'f_path' , 'o_f_name' , 'f_mime_type', 'del_yn' , 'del_date' , 'del_id' , 'download_counter' , 'reg_date', 'reg_id' , 'mod_date', 'mod_id' ];
    protected $validationRules = [
        'f_name'      => 'required',
        'f_path'      => 'required',
        'o_f_name'    => 'required',
        'f_mime_type' => 'required',
        'f_size'      => 'required',
        'reg_date'    => 'required',
        'reg_id'      => 'required'
    ];
    protected $skipValidation = false;
    protected $validationMessages = [];

    public function getFileList(array $arrayParams = [], bool $total_cnt = false , int $s_limit = 0 , int $e_limit = 50)
    {

        $whereQueryString = " AND del_yn = 'N' ";
        $limitQueryString = "";
        $orderbyQueryString = " ORDER BY {$this->primaryKey} DESC ";

        if(isset($arrayParams['loc'])) {
            $whereQueryString .= " AND loc = :loc: ";
            $aBindParams['loc'] = $arrayParams['loc'];
        }
        if(isset($arrayParams['parent_id'])) {
            $whereQueryString .= " AND parent_id = :parent_id: ";
            $aBindParams['parent_id'] = $arrayParams['parent_id'];
        }
        if(isset($arrayParams['board_id_arr'])) {
            $whereQueryString .= "  AND parent_id IN :board_id_arr: ";
            $aBindParams['board_id_arr'] = $arrayParams['board_id_arr'];
        }

        if( empty($e_limit) == false ) $limitQueryString .= " LIMIT {$s_limit} , {$e_limit} ";

        if( $total_cnt == true ){
            $sql = "SELECT
                    count(*) AS cnt
                    FROM {$this->table}
                    WHERE 1 
                    {$whereQueryString}
            ";
            $oResult = $this->db->query($sql,$aBindParams);
            $aResult = $oResult->getRowArray();
        }else{
            $sql = "SELECT
                    *
                    FROM {$this->table}
                    WHERE 1 
                    {$whereQueryString}
                    {$orderbyQueryString}
                    {$limitQueryString}
            ";
            $oResult = $this->db->query($sql,$aBindParams);
            $aResult = $oResult->getResultArray();
        }

        return $aResult;

    }

    public function getFileInfo(array $arrayParams) : array
    {

        $whereQueryString  = " AND del_yn = 'N' ";

        if(isset($arrayParams[$this->primaryKey])) {
            $whereQueryString .= " AND {$this->primaryKey} = :{$this->primaryKey}: ";
            $aBindParams[$this->primaryKey] = $arrayParams[$this->primaryKey];
        }
        if(isset($arrayParams['parent_loc'])) {
            $whereQueryString .= " AND parent_loc = :parent_loc: ";
            $aBindParams['parent_loc'] = $arrayParams['parent_loc'];
        }
        if(isset($arrayParams['parent_id'])) {
            $whereQueryString .= " AND parent_id = :parent_id: ";
            $aBindParams['parent_id'] = $arrayParams['parent_id'];
        }

        $sql = "SELECT 
                * 
                FROM {$this->table} 
                WHERE 1 {$whereQueryString}
        ";
        $oResult = $this->db->query($sql , $aBindParams);
        $aResult = $oResult->getRowArray();


        return $aResult ?? [];

    }

    public function delFile(array $arrayParams) : bool
    {

        $sql = "UPDATE {$this->table}
                SET
                    del_yn  = 'Y'
                ,   del_id  = '{$arrayParams['del_id']}'
                ,   del_date = '{$arrayParams['del_date']}'
                WHERE {$this->primaryKey} IN ({$arrayParams['id_str']});
        ";

        $bRet = $this->query($sql);

        //TODO :: 파일삭제 기능 unlink

        return $bRet;

    }

}

