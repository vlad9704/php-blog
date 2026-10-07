<?php

declare(strict_types=1);

$pdo = require dirname(__DIR__) . '/src/db.php';

$schema = file_get_contents(__DIR__ . '/schema.sql');

if ($schema === false) {
	throw new RuntimeException('Не удалось прочитать schema.sql');
}

$pdo->exec($schema);

$categoryCount = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
$postCount = (int) $pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();

if ($categoryCount > 0 || $postCount > 0) {
	echo "База уже содержит данные. Сидинг пропущен.\n";
	exit(0);
}

$categories = [
	[
		'name' => 'Технологии',
		'description' => 'Программирование и полезные инструменты.',
		'titles' => [
			'С чего начать изучение PHP',
			'Зачем нужен Docker',
			'Как работает MySQL',
			'Что такое шаблонизатор',
			'Основы работы с Git',
			'Как устроен веб-сайт',
		],
	],
	[
		'name' => 'Дизайн',
		'description' => 'Оформление сайтов и работа с интерфейсами.',
		'titles' => [
			'Как выбрать цвета для сайта',
			'Почему важны отступы',
			'Выбор шрифта для блога',
			'Как оформить карточку статьи',
			'Основы адаптивного дизайна',
			'Простой интерфейс: с чего начать',
		],
	],
	[
		'name' => 'Путешествия',
		'description' => 'Поездки, маршруты и впечатления.',
		'titles' => [
			'Как подготовиться к поездке',
			'Что взять в короткое путешествие',
			'Как составить маршрут',
			'Путешествие на выходные',
			'Как сохранить фотографии из поездки',
			'Что посмотреть в новом городе',
		],
	],
	[
		'name' => 'Новости',
		'description' => 'Новости проекта. Статьи появятся позже.',
		'titles' => [],
	],
];

$insertCategory = $pdo->prepare(
	'INSERT INTO categories (name, description) VALUES (?, ?)'
);

$insertPost = $pdo->prepare(
	'INSERT INTO posts (image, title, description, content, views, published_at)
     VALUES (?, ?, ?, ?, ?, ?)'
);

$insertLink = $pdo->prepare(
	'INSERT INTO post_category (post_id, category_id) VALUES (?, ?)'
);

$categoryIds = [];
$firstPostId = null;
$number = 0;
$startDate = new DateTimeImmutable('-30 days');

$pdo->beginTransaction();

try {
	foreach ($categories as $category) {
		$insertCategory->execute([
			$category['name'],
			$category['description'],
		]);

		$categoryId = (int) $pdo->lastInsertId();
		$categoryIds[] = $categoryId;

		foreach ($category['titles'] as $title) {
			$number++;

			$insertPost->execute([
				'/images/post.svg',
				$title,
				'Краткий обзор темы: ' . $title . '.',
				"Это тестовая статья на тему «{$title}».\n\n"
				. "Здесь будет основной текст статьи. Эти данные нужны "
				. "для проверки страниц блога, сортировки и пагинации.",
				($number * 37) % 250,
				$startDate->modify("+{$number} days")->format('Y-m-d H:i:s'),
			]);

			$postId = (int) $pdo->lastInsertId();

			if ($firstPostId === null) {
				$firstPostId = $postId;
			}

			$insertLink->execute([$postId, $categoryId]);
		}
	}

	$insertLink->execute([$firstPostId, $categoryIds[1]]);

	$pdo->commit();

	echo "Создано 4 категории, 18 статей и 19 связей.\n";
} catch (Throwable $exception) {
	$pdo->rollBack();
	throw $exception;
}