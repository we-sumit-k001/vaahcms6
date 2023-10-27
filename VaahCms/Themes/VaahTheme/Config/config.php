<?php

return [
    "name"=> "VaahTheme",
    "title"=> "Theme for VaahCMS",
    "slug"=> "vaahtheme",
    "thumbnail"=> "https://img.site/p/300/160",
    "excerpt"=> "Just For Testing This Theme",
    "description"=> "Just For Testing This Theme",
    "download_link"=> "",
    "author_name"=> "vaahtheme",
    "author_website"=> "https://vaah.dev",
    "version"=> "v0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> false,
    "db_table_prefix"=> "vh_vaahtheme_",
    "providers"=> [
        "\\VaahCms\\Themes\\VaahTheme\\Providers\\VaahThemeServiceProvider"
    ],
    "aside-menu-order"=> null
];
