<?php
namespace App\Libraries;

class CustomImageLib
{

    public $image_lib;
    public $folder = 'file/design_canvas';

    public function __construct()
    {
        $this->image_lib = \Config\Services::image('imagick');
    }

    /**
     * @date 230329
     * @modify 황기석
     * @desc 가로 기준 리사이즈
     * @params
     * @var $arrayParams['path'] : 변경하려는 원본 파일
     * @var $arrayParams['type'] : category(폴더)
     * @var $arrayParams['file_name'] : 파일 명
     * @var $arrayParams['w'] : 원하는 가로사이즈
     */
    public function resize_w(array $arrayParams) : array
    {

        if(empty($arrayParams['path']) || empty($arrayParams['w']) || empty($arrayParams['type']) || empty($arrayParams['file_name']) ) return ['success' => false , 'msg' => '필드입력값 누락' , 'data' => []];

        //파일 전체경로
        $image_full_path = DOCROOT.$arrayParams['path'];

        //이미지 정보
        $img_info   = getimagesize($image_full_path);
        $ratio      = $arrayParams['w'] / $img_info[0];
        $resize_w   = round($img_info[0] * $ratio);
        $resize_h   = round($img_info[1] * $ratio);

        //파일
        $temp_file = explode('.',$arrayParams['file_name']);
        $file_name = $temp_file[0].'.w'.$arrayParams['w'].'.'.$temp_file[1];
        //기본경로
        $path_surfix = '/'. $this->folder . '/' . $arrayParams['type'] . '/' . date('Y') . '/' . date('m') . '/' . date('d');

        $this->image_lib
            ->withFile($image_full_path)
            ->resize($resize_w,$resize_h,true,'width')
            ->save(DOCROOT.$path_surfix.'/'.$file_name,100);

        return ['success' => true , 'msg' => '' , 'data' => $path_surfix.'/'.$file_name ];

    }

    /**
     * @date 230329
     * @modify 황기석
     * @desc 세로 기준 리사이즈
     * @params
     * @var $arrayParams ['path'] : 변경하려는 원본 파일
     * @var $arrayParams ['type'] : category(폴더)
     * @var $arrayParams ['file_name'] : 파일 명
     * @var $arrayParams ['h'] : 원하는 가로사이즈
     * @var $arrayParams ['act'] : change(사이즈변경) | create(사본 복사 후 사이즈 변경)
     */
    public function resize_h(array $arrayParams) : array
    {

        if(    empty($arrayParams['path'])
            || empty($arrayParams['h'])
            || empty($arrayParams['type'])
            || empty($arrayParams['file_name'])
            || empty($arrayParams['act'])
        ) return ['success' => false , 'msg' => '필드입력값 누락' , 'data' => []];

        //파일 전체경로
        if( $arrayParams['act'] == 'change' ) $image_full_path = $arrayParams['path']; //이미지 변경의 경우 /tmp 에 파일을 생성하기떄문에 분리
        else $image_full_path = DOCROOT.$arrayParams['path'];

        if(is_file($image_full_path) == false) return ['success' => false , 'msg' => '파일이 없습니다.file_path : '.$image_full_path , 'data' => []];

        //이미지 정보
        $img_info   = getimagesize($image_full_path);
        $ratio      = $arrayParams['h'] / $img_info[1];
        $resize_w   = round($img_info[0] * $ratio);
        $resize_h   = round($img_info[1] * $ratio);

        //파일
        $temp_file = explode('.',$arrayParams['file_name']);
        $file_name = $temp_file[0].'.h'.$arrayParams['h'].'.'.$temp_file[1];
        //기본경로
        $path_surfix = '/'. $this->folder . '/' . $arrayParams['type'] . '/' . date('Y') . '/' . date('m') . '/' . date('d');

        if(!is_dir(DOCROOT.$path_surfix)){
            $old_umask = umask(0);
            mkdir(DOCROOT.$path_surfix,0777,true);
            umask($old_umask);
        }

        $this->image_lib
            ->withFile($image_full_path)
            ->resize($resize_w,$resize_h,true,'height')
            ->save(DOCROOT.$path_surfix.'/'.$file_name,100);

        return ['success' => true , 'msg' => '' , 'data' => $path_surfix.'/'.$file_name ];

    }

}