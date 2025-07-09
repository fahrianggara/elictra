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
