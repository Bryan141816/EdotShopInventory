<?php

return [
    [
        'label' => 'Home',
        'route' => 'home',
        'icon' => 'home',
    ],
    [
        'label' => 'Inventory',
        'icon' => 'package',
        'route' => 'inventory',
        'children' => [
            [
                'label' => 'Products',
                'icon' => 'package',
                'route' => 'products',
            ],
            [
                'label' => 'Brands',
                'icon' => 'tags',
                'route' => 'brands',
            ],
            [
                'label' => 'Categories',
                'icon' => 'shapes',
                'route' => 'category',
            ],
        ],
    ],
];
