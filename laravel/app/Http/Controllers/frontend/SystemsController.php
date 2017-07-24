<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller;
use File, Image;
use App\External\Upload;

class SystemsController extends Controller {

    public static function uploadPaymentImage($file,$part)
    {
        $handle = new Upload($file);
        if ($handle->uploaded) {
            $handle->file_new_name_body = date('Y-m-d-His');
            //$handle->image_resize = true;
            //$handle->image_ratio_y         = true;
            //$handle->image_x               = 894;
            $handle->Process($part);
            $nameFile = $handle->file_dst_name;
            $handle->Clean();
            return $nameFile;
        } else {
            return 'errors';
        }
    }

    public static function uploadFile($file)
    {

    }
}
