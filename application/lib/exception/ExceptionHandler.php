<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 10:18
 */

namespace app\lib\exception;

use Exception;
use think\exception\Handle;
use think\Log;

class ExceptionHandler extends Handle {
    private $code;
    private $msg;
    private $errcode;
    public function render(Exception $e) {
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errcode = $e->errcode;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg ='服务器内部异常，不想告诉你';
                $this->errcode = 999;
                $this->recordErrorLog($e);
            }

        }
        $result =array(
            'msg'=>$this->msg,
            'error_code'=>$this->errcode,
            'url'=>request()->url()

        );
        return json($result);
    }
    private function recordErrorLog(Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');

    }
}