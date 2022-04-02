<?php

if (!function_exists('printsln')) {
    /**
     * 打印字符串对象, 并换行
     * @param string $content
     * @return void
     */
    function printsln(string $content = '')
    {
        if (empty($content)) {
            return;
        }
        printf("%s\n", $content);
    }
}

if (!function_exists('printsfln')) {
    /**
     * 打印字符串对象, 并前后换行隔离
     * @param string $content
     * @return void
     */
    function printsfln(string $content = '')
    {
        if (empty($content)) {
            return;
        }
        printf("%s\n", str_repeat('-', 64));
        printf($content);
        printf("%s\n", str_repeat('-', 64));
    }
}

if (!function_exists('printafln')) {
    /**
     * 打印数组对象, 并前后换行隔离
     * @param array $array
     * @return void
     */
    function printafln(array $array = array())
    {
        if (count($array) == 0) {
            return;
        }
        printf("%s\n", str_repeat('-', 64));
        print_r($array);
        printf("%s\n", str_repeat('-', 64));
    }
}


