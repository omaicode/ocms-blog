<?php

return [
    [
        'id' => 'ocms-menu-blog',
        'priority' => 1,
        'parent_id' => null,
        'name' => 'blog::messages.blog',
        'icon' => 'fas fa-newspaper',
        'url' => '#',
    ],
    [
        'id' => 'ocms-menu-blog-post',
        'priority' => 0,
        'parent_id' => 'ocms-menu-blog',
        'name' => 'blog::messages.posts',
        'url' => route('admin.blog.posts.index'),
    ],
    [
        'id' => 'ocms-menu-blog-categories',
        'priority' => 1,
        'parent_id' => 'ocms-menu-blog',
        'name' => 'blog::messages.categories',
        'url' => route('admin.blog.categories.index'),
    ],
];
