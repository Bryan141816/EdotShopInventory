<?php

return [
    [
        'label' => 'Home',
        'route' => 'home',
        'icon' => 'home'
    ],
    [
        'label' => 'Inventory',
        'icon'  => 'package',
        'children' => [
            [
                'label' => 'Products',
                'icon'  => 'package',
                'route' => 'inventory',
            ],
            [
                'label' => 'Brands',
                'icon'  => 'tags',
                'route' => 'brands',
            ],
            [
                'label' => 'Categories',
                'icon'  => 'shapes',
                'route' => 'category',
            ],
        ]
    ],
];
