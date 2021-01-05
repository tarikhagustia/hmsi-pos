<?php

return [
    [
        'header' => 'Beranda',
        'permission' => ['Admin', 'Super Admin'],
    ],
    [
        'label' => 'Beranda Utama',
        'link' => '/',
        'icon' => 'fas fa-fire',
        'permission' => ['Admin', 'Super Admin'],
    ],

    [
        'header' => 'Master Data',
        'permission' => ['Admin', 'Super Admin'],
    ],
    [
        'label' => 'Produk',
        'link' => '#',
        'icon' => 'fas fa-boxes',
        'permission' => ['Admin'],
        'children' => [
            [
                'label' => 'Produk',
                'link' => 'admin/products',
                'permission' => null,
            ],
            [
                'label' => 'Kategori',
                'link' => 'admin/product-categories',
                'permission' => null,
            ]
        ]
    ],

    [
        'label' => 'Cabang',
        'link' => 'admin/branches',
        'icon' => 'fas fa-school',
        'permission' => ['Super Admin'],
    ],

    [
        'label' => 'Pengguna',
        'link' => 'admin/users',
        'icon' => 'fas fa-users',
        'permission' => ['Admin', 'Super Admin'],
    ],

    [
        'header' => 'Inventori',
        'permission' => ['Admin', 'Super Admin'],
    ],
    [
        'label' => 'POS',
        'link' => 'admin/pos',
        'icon' => 'fas fa-shopping-cart',
        'permission' => ['Admin'],
    ],

    [
        'header' => 'Laporan',
        'permission' => ['Admin', 'Super Admin'],
    ],
    [
        'label' => 'Laporan Penjualan POS',
        'link' => 'admin/reports/sales',
        'icon' => 'fas fa-file-invoice-dollar',
        'permission' => ['Admin'],
    ],
    [
        'label' => 'Laporan Inventory',
        'link' => 'admin/reports/inventories',
        'icon' => 'fas fa-file-alt',
        'permission' => ['Admin'],
    ],
];
