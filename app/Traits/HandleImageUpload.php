<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandleImageUpload
{
    /**
     * Upload gambar baru.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  string  $path
     * @return string|null
     */
    public function uploadImage($image, $path)
    {
        $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
        $filePath = Storage::disk('public')->putFileAs($path, $image, $filename); // Simpan file dan dapatkan path

        // Kembalikan path relatif terhadap 'public' disk
        return str_replace('public/', '', $filePath);
    }

    /**
     * Update gambar yang sudah ada.
     *
     * @param  \Illuminate\Http\UploadedFile  $newImage
     * @param  string  $oldImage
     * @param  string  $path
     * @return string|null
     */
    public function updateImage($newImage, $oldImage, $path)
    {
        // Hapus gambar lama jika ada
        $this->deleteImage($oldImage);

        // Upload gambar baru
        return $this->uploadImage($newImage, $path);
    }

    /**
     * Hapus gambar dari storage.
     *
     * @param  string  $imagePath
     * @return void
     */
    public function deleteImage($imagePath)
    {
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        return true;
    }
}