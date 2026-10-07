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
	<a href="/">На главную</a>
</header>

<main>
	<h1>{$category.name}</h1>
	<p>{$category.description}</p>

	<form action="/category.php" method="get">
		<input type="hidden" name="id" value="{$category.id}">

		<label for="sort">Сортировка:</label>

		<select name="sort" id="sort">
			<option value="date" {if $sort == 'date'}selected{/if}>
				Сначала новые
			</option>
			<option value="views" {if $sort == 'views'}selected{/if}>
				Сначала популярные
			</option>
		</select>

		<button type="submit">Применить</button>
	</form>

	<div class="posts-grid">
        {foreach $posts as $post}
	        <article class="post-card">
				<a href="/post.php?id={$post.id}">
					<img
							src="{$post.image}"
							alt="{$post.title}"
							width="320"
							height="180"
					>
				</a>

				<h2>
					<a href="/post.php?id={$post.id}">
                        {$post.title}
					</a>
				</h2>

				<p>{$post.description}</p>
				<p>Опубликовано: {$post.published_at}</p>
				<p>Просмотры: {$post.views}</p>
			</article>
            {foreachelse}
			<p>В этой категории пока нет статей.</p>
        {/foreach}
	</div>

    {if $totalPages > 1}
	    <nav class="pagination" aria-label="Страницы статей">
            {for $pageNumber = 1 to $totalPages}
                {if $pageNumber == $page}
					<span aria-current="page">{$pageNumber}</span>
                {else}
					<a href="/category.php?id={$category.id}&amp;sort={$sort}&amp;page={$pageNumber}">
                        {$pageNumber}
					</a>
                {/if}
            {/for}
		</nav>
    {/if}
</main>
</body>
</html>