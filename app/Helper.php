<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('setActive')) {
    /**
     * fungsi untuk menentukan menu aktif
     *
     * @param string ...$uris
     * @return void
     */
    function setActive(...$uris)
    {
        $output = 'active';

        if (count($uris) > 1 && is_string(end($uris))) {
            $output = array_pop($uris);
        }

        foreach ($uris as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
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
