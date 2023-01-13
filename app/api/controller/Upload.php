<?php
namespace app\api\controller;

use app\common\lib\UploadFile;
use app\Request;

class Upload
{
    public function file(Request $request)
    {
        $path = (new UploadFile)->file($request);
        return success(['path' => $path]);
    }
}
