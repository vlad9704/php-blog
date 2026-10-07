<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{$title}</title>
	<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
	<h1>{$title}</h1>
</header>

<main>
    {foreach $categories as $category}
		<section>
			<h2>{$category.name}</h2>
			<p>{$category.description}</p>

			<div class="posts-grid">
                {foreach $category.posts as $post}
	                <article class="post-card">
						<a href="/post.php?id={$post.id}">
							<img
									src="{$post.image}"
									alt="{$post.title}"
									width="320"
									height="180"
							>
						</a>

						<h3>
							<a href="/post.php?id={$post.id}">
                                {$post.title}
							</a>
						</h3>

						<p>{$post.description}</p>
						<p>Опубликовано: {$post.published_at}</p>
					</article>
                {/foreach}
			</div>

			<a class="button" href="/category.php?id={$category.id}">
				Все статьи
			</a>
		</section>
        {foreachelse}
		<p>Статей пока нет.</p>
    {/foreach}
</main>
</body>
</html>