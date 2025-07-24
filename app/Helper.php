<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

if (!function_exists('setActive')) {
    /**
     * fungsi untuk menentukan menu aktif
     *
     * @param string ...$uris
     * @return void
     */
    function setActive(...$routes): string
    {
        foreach ($routes as $route) {
            if (Str::is(trim($route), Route::currentRouteName())) {
                return 'active';
            }
        }
        return '';
    }
}

if (!function_exists('rupiah'))
{
    /**
     * fungsi untuk format angka ke format rupiah
     *
     * @param  mixed $number
     * @param  mixed $prefix
     * @return void
     */
    function rupiah($number, $prefix = 'Rp')
    {
        return $prefix . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('checkFile')) {
    /**
     * Check if file exists
     *
     * @param  string $file
     * @return bool
     */
    function checkFile($file)
    {
        return Storage::disk('public')->exists($file);
    }
}

if (!function_exists('deleteFile')) {
    /**
     * Check if file exists
     *
     * @param  string $file
     * @return bool
     */
    function deleteFile($file)
    {
        if (checkFile($file)) {
            return Storage::disk('public')->delete($file);
        }

        return false;
    }
}

if (!function_exists('getFile')) {
    /**
     * Get the file path for a given file.
     *
     * @param string $file
     * @return string
     */
    function getFile($file)
    {
        return checkFile($file)
            ? asset("storage/{$file}")
            : asset("storage/default.png");
    }
}

if (!function_exists('getFilename')) {
    /**
     * Get the filename from a given path.
     *
     * @param  mixed $path
     * @param  mixed $withExtension
     * @return string
     */
    function getFilename(string $path, bool $withExtension = true): string
    {
        return $withExtension
            ? basename($path)
            : pathinfo($path, PATHINFO_FILENAME);
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Upload a file and return its slug.
     *
     * @param  object $file
     * @param  string $path
     * @param  int $width
     * @param  int $height
     * @param  int $quality
     *
     * @return string
     */
    function uploadFile(
        object $image,
        string $path = 'uploads',
        int $width = 800,
        int $height = 600,
        int $quality = 75,
    ): string {
        $manager = new ImageManager(Driver::class);

        // Convert the image to a cover with specified dimensions
        // $imageRead = $manager->read($image)->cover($width, $height);
        $imageRead = $manager->read($image);
        $imageEncoded = $imageRead->encode(new AutoEncoder(quality: $quality));
        $imageName = "{$path}/{$image->hashName()}";

        // Ensure the directory exists
        Storage::disk('public')->put($imageName, $imageEncoded);

        return $imageName;
    }
}

if (!function_exists('formatPeriod')) {
    /**
     * formatPeriod
     *
     * @param  mixed $period
     * @return void
     */
    function formatPeriod($period)
    {
        try {
            return Carbon::createFromFormat('Y-m', $period)->translatedFormat('F Y');
        } catch (\Exception $e) {
            return $period; // fallback kalau format salah
        }
    }
}

if (!function_exists('formatDate')) {
    /**
     * formatDate
     *
     * @param  mixed $date
     * @return void
     */
    function formatDate($date, $format = 'd F Y')
    {
        try {
            return Carbon::parse($date)->translatedFormat($format);
        } catch (\Exception $e) {
            return $date; // fallback kalau format salah
        }
    }
}
