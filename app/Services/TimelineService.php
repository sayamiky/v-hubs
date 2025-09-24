<?php

namespace App\Services;

use App\Dtos\Timeline\CreateTimelineDTO;
use App\Models\Timeline;
use App\Traits\UploadFile;
use Illuminate\Support\Str;

class TimelineService
{
    use UploadFile;

    public function create(CreateTimelineDto $dto)
    {
        $timeline = Timeline::create([
            'user_id' => auth()->user()->id,
            'title' => $dto->title,
            'description' => $dto->description,
            'visibility' => $dto->visibility,
            'group_id' => $dto->group_id,
        ]);

        // create medias if exist
        if (!empty($dto->media)) {
            $timeline->media()->createMany(
                collect($dto->media)->map(function ($file) {
                    $mimeType = $file->getClientMimeType();
                    $mediaType = Str::startsWith($mimeType, 'image/') ? 'image' : (Str::startsWith($mimeType, 'video/') ? 'video' : 'other');

                    return [
                        'media_path' => $this->upload($file, 'timeline-post'),
                        'media_type' => $mediaType, // 'image', 'video', or 'other'
                    ];
                })->toArray()
            );
        }

        return $timeline;
    }

    public function getAll()
    {
        return Timeline::query();
    }

    public function getById(string $id)
    {
        $timeline = Timeline::with('media')->findOrFail($id);
        return $timeline;
    }

    public function delete(string $id)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->delete();
        return true;
    }

    function update(string $id, CreateTimelineDto $dto)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'visibility' => $dto->visibility,
        ]);

        // handle media update if needed
        if (!empty($dto->media)) {
            // For simplicity, we will delete existing media and add new ones.
            $timeline->media()->delete();
            $timeline->media()->createMany(
                collect($dto->media)->map(function ($file) {
                    $mimeType = $file->getClientMimeType();
                    $mediaType = Str::startsWith($mimeType, 'image/') ? 'image' : (Str::startsWith($mimeType, 'video/') ? 'video' : 'other');

                    return [
                        'media_path' => $this->upload($file, 'timeline-post'),
                        'media_type' => $mediaType,
                    ];
                })->toArray()
            );
        }

        return $timeline;
    }
}
