<?php namespace App\Models;

use CodeIgniter\Model;

class CanvasModel extends Model
{

    public function getCanvasTemplateList(array $arrayParams = [], bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array|int
    {

        $DB = db_connect('cmc');

        $addWhereQueryString = '';
        $aBind = [];
        $limitQueryString = '';

        if($arrayParams["emHot"] == 'Y') {
            $addWhereQueryString .= " AND emHot = ? ";
            $aBind[] = $arrayParams["emHot"];
        }

        $arrayParams["strKeyword"] = trim($arrayParams["strKeyword"]);
        if($arrayParams["strKeyword"] != ''){
            $addWhereQueryString .= " AND ( vcTitle LIKE ? ESCAPE '!' OR txKeyword LIKE ? ESCAPE '!' ) ";
            $aBind[] = '%'.$DB->escapeLikeString($arrayParams["strKeyword"])."%" ;
            $aBind[] = '%'.$DB->escapeLikeString($arrayParams["strKeyword"]).'%';
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT ?,? ";
            $aBind[] = $s_limit;
            $aBind[] = $e_limit;
        }

        if($total_cnt){ //count
            $sql = "SELECT 
                        COUNT(*) AS cnt  
                    FROM TblEzCvsTemplate 
                    WHERE 1
                    {$addWhereQueryString}
            ";

            $oResult = $DB->query($sql , $aBind);
            $aResult = $oResult->getRowArray();
            $aResult = $aResult['cnt'];

        }else{ //list

            $sql = "SELECT * FROM TblEzCvsTemplate WHERE 1=1 {$addWhereQueryString} {$limitQueryString}; ";


            $oResult = $DB->query($sql , $aBind);
            $aResult = $oResult->getResultArray();
        }

        return $aResult;

    }
    public function getCanvasData(array $arrayParams) : array
    {

//        $sql = "    SELECT
//                    * FROM TblEzCvsList WHERE 1";
//        $sql .= sprintf(" AND nIdx='%s'",$nIdx);
//        if($aSess["eGrade"] != 'A'){
//            $sql .= sprintf(" AND vcID='%s'",$aSess["vcID"]);
//        }
//        $DB = db_connect('cmc');
        return [];


    }

    public function getCanvasMyImgList(array $arrayParams) : array
    {

        $addWhereQueryString = '';
        $aBind = [];

        if($arrayParams["vcID"] != ''){
            $addWhereQueryString .= " AND vcID = ? ";
            $aBind[] = $arrayParams["vcID"];
        }

        $DB = db_connect('cmc');
        $sql = "SELECT * 
                FROM TblEzCvsMy 
                WHERE 1
                {$addWhereQueryString} 
                ORDER BY nIdx DESC";

        $oResult = $DB->query($sql , $aBind);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getGroupList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {
        $addWhereQueryString = '';
        $aBind = [];
        $limitQueryString = '';

        if($arrayParams["vcType"] != ''){
            $addWhereQueryString .= " AND vcType= ? ";
            $aBind[] = $arrayParams["vcType"];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT ? , ? ";
            $aBind[] = $s_limit;
            $aBind[] = $e_limit;
        }

        $DB = db_connect('cmc');
        $sql    = " SELECT 
                    * 
                    FROM TblClipsGroup 
                    WHERE emUse='Y'
                    {$addWhereQueryString}
                    ORDER BY nSeq ASC,dtDate DESC
                    {$limitQueryString}
        ";
        $oResult = $DB->query($sql, $aBind);
        $aResult = $oResult->getResultArray();

        return $aResult;

    }

    public function getClipsDataIds($strIdxs) : array
    {

        $addWhereQueryString = $addFindInSet = '';
        $aBind = [];

        $addFindInSet .= ' , FIND_IN_SET(nIdx,?) as ody ';
        $aBind[] = $strIdxs;

        $addWhereQueryString .= ' AND nIdx IN ? ';
        $aBind[] = explode(',', $strIdxs);

        $DB = db_connect('cmc');
        $sql = "SELECT      
                    *
                {$addFindInSet}
                ,   (SELECT `vcCateName` FROM `TblClipsCate1` WHERE `nIdx` = A.`nCate1`) as vcCate1
				,   (SELECT `vcCateName` FROM `TblClipsCate2` WHERE `nIdx` = A.`nCate2`) as vcCate2
				,   (SELECT `vcTitle` FROM `TblThemeMst` WHERE `nIdx` = A.`nTheme1`) as vcTheme1
				,   (SELECT `vcTitle` FROM `TblThemeMst` WHERE `nIdx` = A.`nTheme2`) as vcTheme2
                FROM `TblClipsMst` A 
                WHERE  1   
                {$addWhereQueryString}
                ORDER BY ody ASC
        ";
        $oResult = $DB->query($sql , $aBind);
        $aResult = $oResult->getResultArray();

        return $aResult;
    }

    public function getCanvasTemplateData(array $arrayParams) : array
    {

        $DB = db_connect('cmc');
        $addWhereQueryString = '';
        $aBind = [];

        if($arrayParams["nLoadIdx"] != ''){
            $addWhereQueryString .= " AND nIdx = ? ";
            $aBind[] = $arrayParams["nLoadIdx"];
        }

        $sql = "SELECT * FROM `TblEzCvsTemplate` WHERE 1 {$addWhereQueryString};";
        $oResult = $DB->query($sql , $aBind);
        $aResult = $oResult->getRowArray();

        return $aResult;

    }

    public function getCanvasObjectList(array $arrayParams, bool $total_cnt = false, int $s_limit = 0, int $e_limit = 50) : array
    {

        $DB                     = db_connect('cmc');
        $addWhereQueryString    = '';
        $limitQueryString       = '';
        $aBind                  = [];

        $arrayParams["sKeyword"] = trim($arrayParams["sKeyword"]);
        if(isset($arrayParams["sKeyword"])){
            $addWhereQueryString .= " AND ( vcClipName LIKE ? OR vcKeyword LIKE ? )";
            $aBind[] = '%'.$DB->escapeLikeString($arrayParams["sKeyword"])."%" ;
            $aBind[] = '%'.$DB->escapeLikeString($arrayParams["sKeyword"]).'%';
        }

        if(isset($arrayParams['nCate2'])){
            $addWhereQueryString .= " AND nCate2 = ? ";
            $aBind[] = $arrayParams['nCate2'];
        }

        if( empty($e_limit) == false ) {
            $limitQueryString .= " LIMIT ? , ? ";
            $aBind[] = $s_limit;
            $aBind[] = $e_limit;
        }

        $sql = "SELECT * 
                FROM TblClipsMst 
                WHERE nCate1='5'
                {$addWhereQueryString}
                {$limitQueryString}
        ";
        $oRet = $DB->query($sql , $aBind);
        $aRet = $oRet->getResultArray();

//        $sQuery = "SELECT * FROM TblClipsMst WHERE 1";
//        $sQuery .= " AND nCate1='5' AND nCate2='90'";		// 교수자료 > 그림 > 요소
//        if($arrayParams["sKeyword"] != ''){
//            $sQuery .= sprintf(" AND (vcClipName LIKE '%%%s%%' OR vcKeyword LIKE '%%%s%%')",$aSearch["sKeyword"],$aSearch["sKeyword"]);
//        }
//        $sQuery .= " ORDER BY dtUpDate DESC";
//        $sQuery .= sprintf(" LIMIT %s,%s",$nStart, $nLimit);
//        $oRet = $DB->query($sQuery);
//        $aRet = $oRet->getResultArray();

        return $aRet;

    }

}