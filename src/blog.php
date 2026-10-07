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

function getCategoryById(PDO $pdo, int $id): ?array
{
	$statement = $pdo->prepare(
		'SELECT id, name, description FROM categories WHERE id = ?'
	);

	$statement->execute([$id]);

	$category = $statement->fetch();

	return $category ?: null;
}

function countPostsByCategory(PDO $pdo, int $categoryId): int
{
	$statement = $pdo->prepare(
		'SELECT COUNT(*) FROM post_category WHERE category_id = ?'
	);

	$statement->execute([$categoryId]);

	return (int) $statement->fetchColumn();
}

function getCategoryPosts(
	PDO $pdo,
	int $categoryId,
	string $sort,
	int $limit,
	int $offset
): array {
	$sorting = [
		'date' => 'p.published_at DESC, p.id DESC',
		'views' => 'p.views DESC, p.published_at DESC, p.id DESC',
	];

	$orderBy = $sorting[$sort] ?? $sorting['date'];

	$statement = $pdo->prepare(
		"SELECT p.id, p.image, p.title, p.description,
                p.views, p.published_at
         FROM posts p
         INNER JOIN post_category pc ON pc.post_id = p.id
         WHERE pc.category_id = :category_id
         ORDER BY {$orderBy}
         LIMIT :limit OFFSET :offset"
	);

	$statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
	$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
	$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
	$statement->execute();

	return $statement->fetchAll();
}