<?php
namespace App\Services\Api\FileUploader;

use Illuminate\Support\Facades\Storage;

class FileUploader
{
    protected $uploadDisk;
    protected $uploadPath;
    protected $autoRenameStatus=false;
    protected $file;
    protected $fileName;

    public function __construct()
    {
    }
    public function setUploadDisk(string $uploadDisk)
    {
        $this->uploadDisk = $uploadDisk;
    }
    public function setUploadPath(string $uploadPath)
    {
        $this->uploadPath=$uploadPath;
    }
    public function setAutoRename(bool $status)
    {
        $this->autoRenameStatus=$status;
    }
    public function setFileName($fileName)
    {
        $this->fileName=$fileName;
    }

    public function upload($file)
    {
        if(!$this->uploadDisk)
            throw(new \Exception(__("message.upload_disk_not_set")));
        if(!$this->uploadPath)
            throw(new \Exception(__("message.upload_path_not_set")));

        if(!is_dir($this->uploadPath))
            mkdir($this->uploadPath, 0777, true);
        Storage::disk($this->uploadDisk)->put($this->uploadPath."/".$this->nameGenerator($file), fopen($file, 'r+'));

    }
    public function nameGenerator($file){

        if($this->autoRenameStatus)
            return $this->fileName=now()->timestamp.rand(111111,999999).".".$file->getClientOriginalExtension();
        else
            return $this->fileName=$file->getClientOriginalName();

    }


    public function remove()
    {
        if(!$this->uploadDisk)
            throw(new \Exception("Upload disk not set"));
        if(!$this->uploadPath)
            throw(new \Exception(__("message.upload_path_not_set")));
        if(!$this->fileName)
            throw(new \Exception(__("message.file-name_not_set")));


        $filePath = $this->uploadPath."/".$this->fileName;
        Storage::disk($this->uploadDisk)->delete($filePath);
        return true;
    }


    public function getFile()
    {
        return $this->file;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
