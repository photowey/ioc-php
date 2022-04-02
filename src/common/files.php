<?php

if (!function_exists('do_mkdir')) {
    function do_mkdir($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

}

