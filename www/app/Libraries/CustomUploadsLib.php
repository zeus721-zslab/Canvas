<?php
namespace App\Libraries;

class CustomUploadsLib
{

    public $request;
    public $folder = 'file/design_canvas';
    public $limit_filesize = 1 * 1024 * 1024;

    public function __construct()
    {
        $this->request  = \Config\Services::request();
    }

    /**
     * @date 230329
     * @modify 황기석
     * @desc 다중 파일 업로드
     * @params
     *  $arrayParams['type'] : 파일 타입 ( 제휴병원이미지:hospital / 에디터 : editor / 각종이미지 데이터들:미정 )
     *  $arrayParams['file_field'] : $_FILES 필드명
     */
    public function run_multi(array $arrayParams) : array
    {

        if(empty($arrayParams['type']) || empty($arrayParams['file_field'])) return ['success' => false , 'msg' => '필드입력값 누락' , 'data' => []];

        $path_surfix = '/'. $this->folder . '/' . $arrayParams['type'] . '/' . date('Y') . '/' . date('m') . '/' . date('d');
        $save_path = DOCROOT . $path_surfix ;

        if(!is_dir($save_path)){
            $old_umask = umask(0);
            mkdir($save_path,0777,true);
            umask($old_umask);
        }

        if ($imagefile = $this->request->getFiles()) {
            foreach ($imagefile[$arrayParams['file_field']] as $k => $img) {
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move($save_path , $newName);

                    $img_info[$k] = [
                            'path'          => $path_surfix.'/'.$newName
                        ,   'fieldname'     => $arrayParams['file_field']
                        ,   'originalname'  => $img->getClientName()
                        ,   'encoding'      => ''
                        ,   'mimetype'      => $img->getClientMimeType()
                        ,   'destination'   => $path_surfix
                        ,   'filename'      => $newName
                        ,   'size'          => $img->getSizeByUnit()
                    ];
                }
            }
        }else{
            return ['success' => false , 'msg' => '업로드 파일 정보 누락' , 'data' => []];
        }

        return ['success' => true , 'msg' => '' , 'data' => $img_info ];

    }

    /**
     * @date 230330
     * @modify 황기석
     * @desc 단일 파일 업로드
     * @params
     *  $arrayParams['type'] : 파일 타입 ( 제휴병원이미지:hospital / 에디터 : editor / 각종이미지 데이터들:미정 )
     *  $arrayParams['file_field'] : $_FILES 필드명
     */
    public function run(array $arrayParams) : array
    {

        if(empty($arrayParams['type']) || empty($arrayParams['file_field'])) return ['success' => false , 'msg' => '필드입력값 누락' , 'data' => []];

        if($arrayParams['file_field'] == 'thumb_file'){ //사용후 폐기 파일
            $path_surfix = '/tmp';
            $save_path = $path_surfix ;
        }else{
            $path_surfix = '/'. $this->folder . '/' . $arrayParams['type'] . '/' . date('Y') . '/' . date('m') . '/' . date('d');
            $save_path = DOCROOT . $path_surfix ;
        }

        if(!is_dir($save_path)){
            $old_umask = umask(0);
            mkdir($save_path,0777,true);
            umask($old_umask);
        }

        if ($imagefile = $this->request->getFiles()) {


            if(isTest()){
                if( $imagefile[$arrayParams['file_field']]->getSizeByUnit() > $this->limit_filesize){
                    return ['success' => false , 'msg' => '업로드할 파일은 10메가바이트를 넘을 수 없습니다.' , 'data' => []];
                }
            }

            if ($imagefile[$arrayParams['file_field']]->isValid() && ! $imagefile[$arrayParams['file_field']]->hasMoved()) {

                $newName = $imagefile[$arrayParams['file_field']]->getRandomName();
                $imagefile[$arrayParams['file_field']]->move($save_path , $newName);

                $img_info = [
                        'path'          => $path_surfix.'/'.$newName
                    ,   'fieldname'     => $arrayParams['file_field']
                    ,   'originalname'  => $imagefile[$arrayParams['file_field']]->getClientName()
                    ,   'encoding'      => ''
                    ,   'mimetype'      => $imagefile[$arrayParams['file_field']]->getClientMimeType()
                    ,   'destination'   => $path_surfix
                    ,   'filename'      => $newName
                    ,   'size'          => $imagefile[$arrayParams['file_field']]->getSizeByUnit()
                ];

                //이미지 사이즈
//                $path = DOCROOT.$aImg['data']['path'];
//                $img_info = getimagesize($path);
//                $aInput['img_w'] = $img_info[0];
//                $aInput['img_h'] = $img_info[1];


            }
        }else{
            return ['success' => false , 'msg' => '업로드 파일 정보 누락' , 'data' => []];
        }

        return ['success' => true , 'msg' => '' , 'data' => $img_info];

    }

}
