<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';
require dirname(__DIR__) . '/src/blog.php';

$categoryId = filter_input(
	INPUT_GET,
	'id',
	FILTER_VALIDATE_INT,
	['options' => ['min_range' => 1]]
);

$category = $categoryId
	? getCategoryById($pdo, $categoryId)
	: null;

if ($category === null) {
	http_response_code(404);

	$smarty->assign('title', 'Категория не найдена');
	$smarty->assign('message', 'Такой категории нет.');
	$smarty->display('error.tpl');

	exit;
}

$sort = $_GET['sort'] ?? 'date';

if (!is_string($sort) || !in_array($sort, ['date', 'views'], true)) {
	$sort = 'date';
}

$page = filter_input(
	INPUT_GET,
	'page',
	FILTER_VALIDATE_INT,
	['options' => ['min_range' => 1]]
) ?: 1;

$perPage = 5;
$totalPosts = countPostsByCategory($pdo, $categoryId);
$totalPages = max(1, (int) ceil($totalPosts / $perPage));

$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$posts = getCategoryPosts(
	$pdo,
	$categoryId,
	$sort,
	$perPage,
	$offset
);

$smarty->assign('title', $category['name']);
$smarty->assign('category', $category);
$smarty->assign('posts', $posts);
$smarty->assign('sort', $sort);
$smarty->assign('page', $page);
$smarty->assign('totalPages', $totalPages);

$smarty->display('category.tpl');