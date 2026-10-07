<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';
require dirname(__DIR__) . '/src/blog.php';

$postId = filter_input(
	INPUT_GET,
	'id',
	FILTER_VALIDATE_INT,
	['options' => ['min_range' => 1]]
);

$post = $postId
	? getPostById($pdo, $postId)
	: null;

if ($post === null) {
	http_response_code(404);

	$smarty->assign('title', 'Статья не найдена');
	$smarty->assign('message', 'Такой статьи нет.');
	$smarty->display('error.tpl');

	exit;
}

// Каждое открытие страницы считаем отдельным просмотром.
incrementPostViews($pdo, $postId);

$post = getPostById($pdo, $postId);

$categories = getPostCategories($pdo, $postId);
$relatedPosts = getRelatedPosts($pdo, $postId);

$smarty->assign('title', $post['title']);
$smarty->assign('post', $post);
$smarty->assign('categories', $categories);
$smarty->assign('relatedPosts', $relatedPosts);

$smarty->display('post.tpl');