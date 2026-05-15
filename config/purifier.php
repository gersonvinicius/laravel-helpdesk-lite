<?php

return [
    'encoding'      => 'UTF-8',
    'finalize'      => true,
    'cachePath'     => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    'settings'      => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'div,p,br,h1,h2,h3,blockquote,pre,code,ul,ol,li,strong,em,del,a[href|title]',
            'CSS.AllowedProperties'    => '',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false,
            'URI.AllowedSchemes'       => ['http' => true, 'https' => true, 'mailto' => true],
        ],
    ],
];
