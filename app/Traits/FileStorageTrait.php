<?php


namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileStorageTrait
{

    public function deleteFile($nameOldFile = null, $path = null, $disk = null)
    {
        $pathDelete = "\\" . $path . "\\" . $nameOldFile;
        if (Storage::disk($disk)->exists($pathDelete)) {
            Storage::disk($disk)->delete($pathDelete);
        }
    }

    public function storeImage($file = null, $path = null, $disk = null)
    {
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        if (strlen($name) > 100) {
            $name = substr($name, 0, 90);
            $name = $name . $extension;
        }
        $milliseconds = round(microtime(true) * 1000);
        $name = $milliseconds . $name;
        $path = $file->storeAs($path, $name, $disk);
        return $name;
    }

    public function storeAndDeleteOldImage($file = null, $nameOldFile = null, $path = null, $disk = null)
    {
        $this->deleteFile($nameOldFile, $path, $disk);
        return $this->storeImage($file, $path, $disk);
    }

}
