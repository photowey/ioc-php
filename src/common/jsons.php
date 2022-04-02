<?php

if (!function_exists('toJSONObject')) {
    function toJSONObject($value, int $flags = 0, int $depth = 512)
    {
        return json_encode($value, $flags = 0 == $flags ? JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES : $flags, $depth);
    }
}

if (!function_exists('toJSONPretty')) {
    function toJSONPretty($value, int $flags = 0, int $depth = 512)
    {
        return json_encode($value, $flags + ($flags === JSON_PRETTY_PRINT ? 0 : JSON_PRETTY_PRINT), $depth);
    }
}

if (!function_exists('toArray')) {
    function toArray(string $json_body, ?bool $associative = false, int $depth = 512, int $flags = 0)
    {
        return json_decode($json_body, $associative, $depth, $flags);
    }
}


