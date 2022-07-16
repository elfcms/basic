<?php

namespace Elfcms\Basic\Elf;

class Helpers {

    public static function hashTag(string $string, $hash=true)
    {
        $result = strtolower(preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '',$string));

        if ($hash) {
            $result = '#' . $result;
        }

        return $result;
    }

    public static function test()
    {
        $debug = debug_backtrace();
            dd($debug);
    }

}
