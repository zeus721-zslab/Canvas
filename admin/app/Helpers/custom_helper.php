<?php

use CodeIgniter\I18n\Time;

if (! function_exists('zsView'))
{
	/**
	 * 텍스트정리
     * @param mixed : 출력된 정보 (array , object , string , etc)
	 * @return void
	 */
	function zsView($s,$exit = false) : void
	{
		echo '<xmp>';
		print_r($s);
        echo '</xmp>';
	    if($exit == true) exit;
	}
}

if (! function_exists('array_key_sort'))
{
    /**
     * 연관배열 정렬
     * @param array $array : 배열
     * @param mixed $field : 정렬할 키
     * @param string $sort_type : asc=오른차순, desc=내림차순
     * @return array
     */
    function array_key_sort($array, $field, $sort_type="desc") : array
    {
        if( empty($array) ) {
            return array();
        }

        $temp_array = array();

        foreach ($array as $key => $item) {
            $temp_array[$key] = $item[$field];
        }

        if( $sort_type == "asc" ) {
            asort($temp_array);
        }
        else {
            arsort($temp_array);
        }

        $return_array = array();

        foreach ($temp_array as $key => $item) {
            $return_array[$key] = $array[$key];
        }

        return $return_array;
    }//end of array_key_sort()

}

if (! function_exists('link_src_html'))
{
    /**
     * CSS, JS 파일 링크 html
     * @param string $url
     * @param string $type : js|css|''
     */
    function link_src_html($url, $type="") : string
    {
        $filetime   = @filemtime(DOCROOT . $url);
        $s          = '';
        if( $type == "css" )  $s .= '<link href="' . $url . '?v=' . $filetime . '" rel="stylesheet" />';
        else if( $type == "js" ) $s .= '<script src="' . $url . '?v=' . $filetime . '" type="text/javascript"></script>';
        else $s .= $url . '?v=' . $filetime;

        return $s;
    }//end of link_src_html()
}


if (! function_exists('isAjaxCheck'))
{
    function isAjaxCheck() : void
    {
        $request = service('request');
        if ($request->isAJAX() == false) throw new \RuntimeException(lang('Security.disallowedAction'));
    }
}

if (! function_exists('view_date_format'))
{

    function view_date_format( $sourceString, $type = 2 ) : string
    {
        if(empty($sourceString) == true) return '';

        $sourceString = onlynumber($sourceString);

        switch ($type) {
            case 1: // YYYY년 MM월 DD일
                $str = mb_substr($sourceString, 0, 4) . "년 " . mb_substr($sourceString, 4, 2) . "월 " . mb_substr($sourceString, 6, 2) . "일";
                break;
            case 2: // YYYY.MM.DD HH:II
                $str = mb_substr($sourceString, 0, 4) . "." . mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2) . " " . mb_substr($sourceString, 8, 2) . ":" . mb_substr($sourceString, 10, 2);
                break;
            case 3: // YYYY.MM.DD HH:II:SS
                $str = mb_substr($sourceString, 0, 4) . "." . mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2) . " " . mb_substr($sourceString, 8, 2) . ":" . mb_substr($sourceString, 10, 2) . ":" . mb_substr($sourceString, 12, 2);
                break;
            case 4: // YYYY.MM.DD
                $str = mb_substr($sourceString, 0, 4) . "." . mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2);
                break;
            case 5: // YYYY-MM-DD
                $str = mb_substr($sourceString, 0, 4) . "-" . mb_substr($sourceString, 4, 2) . "-" . mb_substr($sourceString, 6, 2);
                break;
            case 6: // YYYY년 MM월 DD일 HH시 II분
                $str = mb_substr($sourceString, 0, 4) . "년 " . mb_substr($sourceString, 4, 2) . "월 " . mb_substr($sourceString, 6, 2) . "일" . " " . mb_substr($sourceString, 8, 2) . "시 " . mb_substr($sourceString, 10, 2). "분";
                break;
            case 7: // YYYY-MM-DD HH:II:SS
                $str = mb_substr($sourceString, 0, 4) . "-" . mb_substr($sourceString, 4, 2) . "-" . mb_substr($sourceString, 6, 2) . " " . mb_substr($sourceString, 8, 2) . ":" . mb_substr($sourceString, 10, 2) . ":" . mb_substr($sourceString, 12, 2);
                break;
            case 8: // MM.DD
                $str = mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2);
                break;

            case 9: // YYYY/MM/DD
                $str = mb_substr($sourceString, 0, 4) . "/" . mb_substr($sourceString, 4, 2) . "/" . mb_substr($sourceString, 6, 2);
                break;

            case 10: // YY.MM.DD
                $str = mb_substr($sourceString, 2, 2) . "." . mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2);
                break;
            case 11: // YYYY-MM
                $str = mb_substr($sourceString, 0, 4) . "-" . mb_substr($sourceString, 4, 2);
                break;

            case 50: // YYYY.MM.DD(요일) AM 00:00
                $sDate 		= strtotime($sourceString);
                $aWeekArray = array('일', '월', '화', '수', '목', '금', '토');

                $nWeekNo = date('w', $sDate );

                $sWeekName = $aWeekArray[$nWeekNo];

                $str = date('Y.m.d', $sDate);
                $str.= sprintf('(%s)', $sWeekName);
                $str.= date(' A H:i', $sDate);
                break;

            case 51	://YYYY.MM.DD ({요일 한글명})	/ 2010/12/24, 이강수 / 쪽지
                $aWeekArray = array('일', '월', '화', '수', '목', '금', '토');

                $nWeekNo = date('w', strtotime( view_date_format($sourceString, 5) ) );

                $sWeekName = $aWeekArray[$nWeekNo];

                $str = mb_substr($sourceString, 0, 4) . "." . mb_substr($sourceString, 4, 2) . "." . mb_substr($sourceString, 6, 2);
                $str.= sprintf(' (%s)', $sWeekName);
                break;

            case 52: // YYYY.MM.DD(요일) 밤 00:00

                $sDate 		= strtotime($sourceString);
                $aWeekArray = array('일', '월', '화', '수', '목', '금', '토');
                $nWeekNo = date('w', $sDate );

                if(date('A', $sDate ) == 'AM') {
                    $sAmPm = '낮';
                } else {
                    $sAmPm = '밤';
                }

            $sWeekName = $aWeekArray[$nWeekNo];

            $str = date('Y.m.d', $sDate);
            $str.= sprintf('(%s) ', $sWeekName);
            $str.= $sAmPm;

            $str.= date(' H:i', $sDate);

            break;

        }
        return $str;
    }

}

if (! function_exists('del_file'))
{
    function del_file($path) : bool
    {
        if(empty($path) == true) return false;

        $ret = false;

        $path = realpath($path) ?: $path;
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $path = rtrim($path, '\\');

        if(@unlink($path)) $ret = true;

        return $ret;

    }
}

/*
 * @desc A,B,C,D,E 코드별 보더컬러 지정
 **/
if (! function_exists('getBorderColor'))
{
    function getBorderColor(string $v) : string
    {

        $border_class = '';
        if( $v == 'A' ) $border_class .= 'border-danger';
        else if( $v == 'B' ) $border_class .= 'border-primary';
        else if( $v == 'C' ) $border_class .= 'border-success';
        else if( $v == 'D' ) $border_class .= 'border-info';
        else if( $v == 'E' ) $border_class .= 'border-warning';

        else if( $v == 'F' ) $border_class .= 'border-secondary';
        else if( $v == 'G' ) $border_class .= 'border-light';
        else if( $v == 'H' ) $border_class .= 'border-dark';
        else if( $v == 'I' ) $border_class .= 'border-danger';
        else if( $v == 'J' ) $border_class .= 'border-primary';

        return $border_class;

    }
}

/*
 * @desc A,B,C,D,E 코드별 텍스트컬러 지정
 **/
if (! function_exists('getTextColor'))
{
    function getTextColor(string $v) : string
    {

        $class_nm = '';
        if($v == 'A') $class_nm = 'text-cyan';
        else if($v == 'B') $class_nm = 'text-success';
        else if($v == 'C') $class_nm = 'text-primary';
        else if($v == 'D') $class_nm = 'text-danger';

        return $class_nm;

    }
}

/**
 * @desc symbolic으로 생성된 path
 * @example
 *  1. upload1 => symbolic link => {ROOT_PATH}\app_admin\writable\uploads
 *  2. upload2 => symbolic link => {ROOT_PATH}\app_www\writable\uploads
 *
 **/
if (! function_exists('getPreUploadPath'))
{
    function getPreUploadPath(string $v): string
    {
        $ret = '';
        if($v == 'a') $ret = '/uploads1/'; // admin upload file
        else if($v == 'w') $ret = '/uploads2/'; // www upload file
        return $ret;

    }
}

###  숫자만 반환
if (! function_exists('onlynumber'))
{
    function onlynumber(string $str) : int
    {
        //$str = ereg_replace("[^0-9]", "",$str);
        $str = preg_replace("/[^0-9]*/s","",$str);
        return (int)$str;
    }
}

###  테스트 여부 확인
if (! function_exists('isTest'))
{
    function isTest() : bool
    {
        $r = false;
        if(in_array($_SERVER['REMOTE_ADDR'],TEST_IP) == true) $r = true;
        return $r;
    }
}

###  alert_script();
if (! function_exists('alert_script'))
{
    function alert_script(string $str) : void
    {
        $script = "<script>";
        $script .= "alert('{$str}');";
        $script .= "</script>";

        echo $script;
    }
}

###  top_alert_script();
if (! function_exists('top_alert_script'))
{
    function top_alert_script(string $str) : void
    {
        $script = "<script>";
        $script .= "top.alert('{$str}');";
        $script .= "</script>";

        echo $script;
    }
}


###  alert_back_script();
if (! function_exists('alert_back_script'))
{
    function alert_back_script(string $str) : void
    {
        $script = "<script>";
        $script .= "alert('{$str}');";
        $script .= "history.back();";
        $script .= "</script>";

        echo $script;
    }
}


###  alert_back_script();
if (! function_exists('alert_reload_script'))
{
    function alert_reload_script(string $str) : void
    {
        $script = "<script>";
        $script .= "alert('{$str}');";
        $script .= "location.reload();";
        $script .= "</script>";

        echo $script;
    }
}

if (! function_exists('getRandomFileName'))
{
    function getRandomFileName($ext)
    {
        return Time::now()->getTimestamp() . '_' . bin2hex(random_bytes(10)).$ext;
    }
}

if (! function_exists('getImgfileToData'))
{
    function getImgfileToData($filrpath) : string
    {
        $type = pathinfo($filrpath, PATHINFO_EXTENSION);
        $data = file_get_contents($filrpath);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}

if (! function_exists('getSupplyAmount'))
{
    function getSupplyAmount(int $number) : int
    {
        return ceil($number / 1.1); //공급가액;
    }
}
if (! function_exists('getVatAmount'))
{
    function getVatAmount(int $number) : int
    {
        return floor($number * 0.1); //부가세액;
    }
}



