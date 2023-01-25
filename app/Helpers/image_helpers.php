<?php

use Intervention\Image\Facades\Image;

/**
 * Upload Image And Resize
 * $inputName = input file name
 * $uploadToPath = Path To Upload
 * $width = image resize width
 * $height = image resize height
 */

function image($inputFile, $uploadToPath, $newFileName, $width, $height)
{
    
    $img = $inputFile; // Input File
    $imgRealPath = $img->getRealPath(); // Get Image Real Path
    $image_resize = Image::make($imgRealPath);
    $image_resize->resize($width, $height);
    $image_resize->save(public_path($uploadToPath . $newFileName));

    return $newFileName;
}


function re_image($inputFile, $uploadToPath, $width, $height)
{

    $filename = $inputFile->getClientOriginalName(); // Get File Choose Name

    $image_resize = Image::make($inputFile->getRealPath());

    $image_resize->resize($width, $height);

    $image_resize->save(public_path($uploadToPath . $filename));

    return $filename;
}





function upload($file,$upload_to_path,$file_name)
{
    move_uploaded_file($file->getRealPath(), public_path($upload_to_path . $file_name));
}