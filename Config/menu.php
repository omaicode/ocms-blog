<?php

return [
    [
        'id' => 'ocms-menu-blog',
        'priority' => 1,
        'parent_id' => null,
        'name' => 'blog::messages.blog',
        'icon' => 'fas fa-newspaper',
        'url' => '#',
        'permissions' => ['blog.view'],
    ],
    [
        'id' => 'ocms-menu-blog-post',
        'priority' => 0,
        'parent_id' => 'ocms-menu-blog',
        'name' => 'blog::messages.posts',
        'url' => route('admin.blog.posts.index'),
        'permissions' => ['blog.categories.view'],
    ],
    [
        'id' => 'ocms-menu-blog-categories',
        'priority' => 1,
        'parent_id' => 'ocms-menu-blog',
        'name' => 'blog::messages.categories',
        'url' => route('admin.blog.categories.index'),
        'permissions' => ['blog.posts.view'],
    ],
];
