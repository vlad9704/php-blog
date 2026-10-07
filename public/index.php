<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';
require dirname(__DIR__) . '/src/blog.php';

$categories = getCategoriesWithPosts($pdo);

foreach ($categories as $index => $category) {
	$categories[$index]['posts'] = getLatestPostsByCategory(
		$pdo,
		(int) $category['id']
	);
}

$smarty->assign('title', 'Мой блог');
$smarty->assign('categories', $categories);

$smarty->display('home.tpl');