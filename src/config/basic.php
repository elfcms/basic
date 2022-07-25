<?php

return [
    "menu" => [
        [
            "title" => "Users",
            "lang_title" => "basic::elf.users",
            "route" => "admin.users",
            "parent_route" => "admin.users",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/users.png",
            "submenu" => [
                [
                    "title" => "Users",
                    "lang_title" => "basic::elf.users",
                    "route" => "admin.users"
                ],
                [
                    "title" => "Roles",
                    "lang_title" => "basic::elf.roles",
                    "route" => "admin.users.roles"
                ],
            ]
        ],
        [
            "title" => "Settings",
            "lang_title" => "basic::elf.settings",
            "route" => "admin.settings.index",
            "parent_route" => "admin.settings.index",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/settings.png",
        ],
        [
            "title" => "Email",
            "lang_title" => "basic::elf.email",
            "route" => "admin.email",
            "parent_route" => "admin.email",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/email.png",
            "submenu" => [
                [
                    "title" => "Addresses",
                    "lang_title" => "basic::elf.addresses",
                    "route" => "admin.email.addresses"
                ],
                [
                    "title" => "Events",
                    "lang_title" => "basic::elf.events",
                    "route" => "admin.email.events"
                ],
            ]
        ],
        [
            "title" => "Form",
            "lang_title" => "basic::elf.form",
            "route" => "admin.form.forms",
            "parent_route" => "admin.form",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/forms.png",
            "submenu" => [
                [
                    "title" => "Forms",
                    "lang_title" => "basic::elf.forms",
                    "route" => "admin.form.forms"
                ],
                [
                    "title" => "Field groups",
                    "lang_title" => "basic::elf.form_field_groups",
                    "route" => "admin.form.groups"
                ],
                [
                    "title" => "Fields",
                    "lang_title" => "basic::elf.form_fields",
                    "route" => "admin.form.fields"
                ],
            ]
        ],
        [
            "title" => "Menu",
            "lang_title" => "basic::elf.menu",
            "route" => "admin.menu.menus",
            "parent_route" => "admin.menu",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/menu.png",
            "submenu" => [
                [
                    "title" => "Menu",
                    "lang_title" => "basic::elf.menu",
                    "route" => "admin.menu.menus"
                ],
                [
                    "title" => "Items",
                    "lang_title" => "basic::elf.menu_items",
                    "route" => "admin.menu.items"
                ],
            ]
        ],
        [
            "title" => "Pages",
            "lang_title" => "basic::elf.pages",
            "route" => "admin.page.pages",
            "parent_route" => "admin.page",
            "icon" => "/vendor/elfcms/basic/admin/images/icons/pages.png",
        ]
    ]
];
