<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FileUploadService
{
    protected $disk = 'public';
    protected $watermarkPath = null;
    protected $watermarkPosition = 'center'; // موقعیت پیش‌فرض واترمارک
    protected $resizeWidth = null;
    protected $resizeHeight = null;
    protected $useOriginalName = false;
    protected $uploadedFileName = null;
    protected $uploadedFileExtension = null;
    protected $uploadedFilePath = null;
    protected $uploadedFileSize = null;
    protected $path = 'uploads';
    protected $existingFilePath = null; // مسیر فایل قبلی

    // تنظیم دیسک ذخیره‌سازی
    public function setDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    // تنظیم واترمارک
    public function setWatermarkPath($watermarkPath)
    {
        $this->watermarkPath = $watermarkPath;
        return $this;
    }

    // تنظیم موقعیت واترمارک
    public function setWatermarkPosition($position)
    {
        $validPositions = ['top-left', 'top-right', 'bottom-left', 'bottom-right', 'center'];
        if (in_array($position, $validPositions)) {
            $this->watermarkPosition = $position;
        } else {
            throw new \Exception('موقعیت واترمارک نامعتبر است.');
        }
        return $this;
    }

    // تنظیم اندازه برای ریسایز
    public function setResizeDimensions($width, $height)
    {
        $this->resizeWidth = $width;
        $this->resizeHeight = $height;
        return $this;
    }

    // تنظیم نام‌گذاری فایل
    public function useOriginalName($useOriginalName)
    {
        $this->useOriginalName = $useOriginalName;
        return $this;
    }

    // تنظیم مسیر ذخیره‌سازی
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    // تنظیم مسیر فایل قبلی
    public function setExistingFilePath($existingFilePath)
    {
        $this->existingFilePath = $existingFilePath;
        return $this;
    }

    // متد نهایی برای آپلود فایل
    public function upload($file)
    {
        $uploadedFileName = $this->useOriginalName
        ? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension()
        : uniqid() . '.' . $file->getClientOriginalExtension();



        // تعیین نام فایل
        $fileName = $uploadedFileName;
        // بررسی اینکه آیا فایل تصویر است
        if (substr($file->getMimeType(), 0, 5) == 'image') {
            $image = Image::read($file);

            // ریسایز کردن تصویر در صورت نیاز
            if ($this->resizeWidth && $this->resizeHeight) {
                $image->resize($this->resizeWidth, $this->resizeHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // اضافه کردن واترمارک در صورت نیاز
            if ($this->watermarkPath) {
                $watermark = Image::read($this->watermarkPath);
                $image->insert($watermark, $this->watermarkPosition);
            }

            $imagePath = $this->path . '/' . $fileName;

            // ذخیره‌سازی فایل
            Storage::disk($this->disk)->put($imagePath, (string) $image->encode());

            // حذف فایل قبلی در صورت وجود
            if ($this->existingFilePath) {
                Storage::disk($this->disk)->delete($this->existingFilePath);
            }
            $this->uploadedFileName = $uploadedFileName;

            $this->uploadedFileExtension = $file->getClientOriginalExtension();

            $this->uploadedFileSize = $file->getSize();

            $this->uploadedFilePath = $imagePath;

            return $imagePath;
        } else {
            // ذخیره‌سازی مستقیم فایل‌های غیر تصویری
            $filePath = $this->path . '/' . $fileName;

            Storage::disk($this->disk)->putFileAs($this->path, $file, $fileName);
            // حذف فایل قبلی در صورت وجود
            if ($this->existingFilePath) {
                Storage::disk($this->disk)->delete($this->existingFilePath);
            }
            $this->uploadedFileName = $uploadedFileName;

            $this->uploadedFileExtension = $file->getClientOriginalExtension();

            $this->uploadedFileSize = $file->getSize();

            $this->uploadedFilePath = $filePath;
            return $filePath;
        }
    }

    public function getUploadedFileName()
    {
        return $this->uploadedFileName;
    }
    public function getUploadedFileExtension()
    {
        return $this->uploadedFileExtension;
    }
    public function getUploadedFilePath()
    {
        return $this->uploadedFilePath;
    }
    public function getUploadedFileSize()
    {
        return $this->uploadedFileSize;
    }

    public function delete()
    {
        Storage::disk($this->disk)->delete($this->existingFilePath);
    }
}
