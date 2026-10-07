<?php

declare(strict_types=1);

function getCategoriesWithPosts(PDO $pdo): array
{
	$statement = $pdo->query(
		'SELECT c.id, c.name, c.description
         FROM categories c
         WHERE EXISTS (
             SELECT 1
             FROM post_category pc
             WHERE pc.category_id = c.id
         )
         ORDER BY c.name ASC'
	);

	return $statement->fetchAll();
}

function getLatestPostsByCategory(PDO $pdo, int $categoryId): array
{
	$statement = $pdo->prepare(
		'SELECT p.id, p.image, p.title, p.description, p.published_at
         FROM posts p
         INNER JOIN post_category pc ON pc.post_id = p.id
         WHERE pc.category_id = ?
         ORDER BY p.published_at DESC, p.id DESC
         LIMIT 3'
	);

	$statement->execute([$categoryId]);

	return $statement->fetchAll();
}