<?php

return [
    "name"=> "Testing",
    "title"=> "Testing of Crud",
    "slug"=> "testing",
    "thumbnail"=> "https://img.site/p/300/160",
    "is_dev" => env('MODULE_TESTING_ENV')?true:false,
    "excerpt"=> "Testing New Crud ",
    "description"=> "Testing New Crud ",
    "download_link"=> "",
    "author_name"=> "vaah",
    "author_website"=> "https://vaah.dev",
    "version"=> "0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> true,
    "db_table_prefix"=> "vh_testing_",
    "providers"=> [
        "\\VaahCms\\Modules\\Testing\\Providers\\TestingServiceProvider"
    ],
    "aside-menu-order"=> null
];
