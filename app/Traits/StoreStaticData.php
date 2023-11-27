<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait StoreStaticData
{

    function reduceImageSize($folder, $filename, $filePath, $disk, $width = 500, $height = 500, $quality = 80)
    {// Read the original image file from the local filesystem
        $imageContent = file_get_contents($filePath);

        // Open an image from the content
        $img = Image::make($imageContent);

        // Resize the image to the specified width and height
        $img->resize($width, $height);

        // Specify the public path where you want to store the resized image
        $publicPath = public_path($folder);

        // If the specified folder doesn't exist, create it
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        // Build the path for the resized image within the specified folder
        $resizedImagePath = $folder . '/' . $filename;
        $resizedImagePath = str_replace(' ', '_', $resizedImagePath);

        // Save the resized image back to the local filesystem with reduced quality
        file_put_contents(public_path($resizedImagePath), $img->encode('jpg', $quality)->__toString());

        // Return the path to the resized image
        return $resizedImagePath;

    }

    function deleteDirectory($folder)
    {
        $folder = public_path($folder);
        if (is_dir($folder)) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                unlink($file);
            }
//            rmdir($folder);
        }
    }

    function storeImage($name, $disk, $folder)
    {
        $name = $name . ".jpg";
        $imagePath = "C:\\flutter_project\\tarwika_backend\\app\\static_data\\images\\" . $name;
        if (!file_exists($imagePath)) {
            return '0';
        }
//        $name = rand(10000, 99999) . $name . ".jpg";
        $name = str_replace(' ', '_', $name);
        $imageData = file_get_contents($imagePath);
        Storage::disk($disk)->put($folder . '/' . $name, $imageData);
//        $this->reduceImageSize($folder, $name, $imagePath, $disk);
        return $name;

    }

}
