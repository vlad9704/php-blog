<?php

declare(strict_types=1);

$host = getenv('DB_HOST') ?: 'db';
$name = getenv('DB_NAME') ?: 'blog';
$user = getenv('DB_USER') ?: 'blog';
$password = getenv('DB_PASSWORD') ?: 'blog';

return new PDO(
	"mysql:host={$host};dbname={$name};charset=utf8mb4",
	$user,
	$password,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]
);