<?php

namespace App\Services\Api\MediaLibrary;

use App\Models\Admin\ServiceCategory;
use App\Models\Good;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 * @package App\MediaLibrary
 */
class CustomPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        switch ($media->model_type) {
            case Good::class:
                return "goods/".$media->model_id."/";
                break;

            default:
                return $media->id."/";
                break;
        }

    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    /**
     * @param Media $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}
