<?php

namespace Elfcms\Basic\Elf\Admin;

class Menu {

    public static function get()
    {
        $menu = [];
        $configs = config('elfcms');
        if (!empty($configs)) {
            foreach ($configs as $package => $config) {
                if (!empty($config['menu'])) {
                    foreach ($config['menu'] as $item) {
                        if (empty($item['parent_route'])) {
                            $item['parent_route'] = $item['route'];
                        }
                        $menu[] = $item;
                    }
                }
            }
        }

        return $menu;
    }

}
