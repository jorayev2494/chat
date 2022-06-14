<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait FileTrait
 * @package App\Traits
 */
trait FileTrait
{
    private int $lengthRandomName = 32;

    /**
     * Upload File
     *
     * @param string $path
     * @param UploadedFile $uploadedFile
     * @param string $disk
     * @return array
     */
    protected function uploadFile(string $path, UploadedFile $uploadedFile, string $disk = 'public'): array
    {
        list($fileData['width'], $fileData['height']) = getimagesize($uploadedFile->getPathname());
        $fileData['path'] = $path;
        $fileData['mime_type'] = $uploadedFile->getClientMimeType();
        $fileData['type'] = $uploadedFile->getClientOriginalExtension();
        $fileData['extension'] = $uploadedFile->getClientOriginalExtension();
        $fileData['size'] = $uploadedFile->getSize();
        $fileData['user_file_name'] = $uploadedFile->getClientOriginalName();
        $fileData['name'] = Str::random($this->lengthRandomName) . '.' . $fileData['type'];
        $fileData['full_path'] = "/storage/{$uploadedFile->storeAs($path, $fileData['name'], ['disk' => $disk])}";
        $fileData['url'] = env('APP_URL') . $fileData['full_path'];

        return $fileData;
    }

    /**
     * @param string $path
     * @param string|null $deleteFileName
     * @param UploadedFile $uploadedFile
     * @param string $disk
     * @return array
     */
    protected function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile, string $disk = 'public'): array
    {
        $this->deleteFile($path, $deleteFileName, $disk);

        return $this->uploadFile($path, $uploadedFile, $disk);
    }

    /**
     * @param string $path
     * @param string|null $deleteFileName
     * @param string $disk
     * @return bool
     */
    protected function deleteFile(string $path, ?string $deleteFileName, string $disk = 'public'): bool
    {
        if (!empty($deleteFileName) && Storage::disk($disk)->exists($path)) {
            $deleteFileName = str_replace($path . "/", '', $deleteFileName);

            return Storage::disk($disk)->delete($path . '/' . $deleteFileName);
        }

        return true;
    }

    /**
     * @param string $path
     * @param string $disk
     * @return bool
     */
    protected function deleteDir(string $path, string $disk = 'public'): bool
    {
        $this->changeDisk($disk);

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->deleteDirectory($path);

            return true;
        }

        return false;
    }

    public function changeDisk(string &$disk): void
    {
        if (config('app.env') == 'local') {
            $disk = 'public';
        }
    }
}
