<?php

namespace App\FileUploader;

use Illuminate\Support\Facades\Facade;

class FileUploaderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-file-uploader';
    }
}
