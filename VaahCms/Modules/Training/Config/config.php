<?php

return [
    "name"=> "Training",
    "title"=> "Trainging Of Crud",
    "slug"=> "training",
    "thumbnail"=> "https://img.site/p/300/160",
    "is_dev" => env('MODULE_TRAINING_ENV')?true:false,
    "excerpt"=> "Making Crud For Use Various Feature ",
    "description"=> "Making Crud For Use Various Feature ",
    "download_link"=> "",
    "author_name"=> "vaah",
    "author_website"=> "https://vaah.dev",
    "version"=> "0.0.1",
    "is_migratable"=> true,
    "is_sample_data_available"=> false,
    "db_table_prefix"=> "vh_training_",
    "providers"=> [
        "\\VaahCms\\Modules\\Training\\Providers\\TrainingServiceProvider"
    ],
    "aside-menu-order"=> null
];
