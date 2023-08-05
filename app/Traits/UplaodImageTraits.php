<?php

namespace App\Traits;

trait UplaodImageTraits
{
    
function UploadImage($folder,$image){//Upload Photo To DataBase
    $image->store('/',$folder);
    $filename=$image->hashName();
    return $filename;
}
}
