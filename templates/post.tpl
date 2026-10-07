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
	<article class="post-detail">
		<h1>{$post.title}</h1>

		<p>Опубликовано: {$post.published_at}</p>
		<p>Просмотры: {$post.views}</p>

		<div>
			Категории:
            {foreach $categories as $category}
				<a href="/category.php?id={$category.id}">
                    {$category.name}
				</a>
            {/foreach}
		</div>

		<img
				src="{$post.image}"
				alt="{$post.title}"
				width="640"
				height="360"
		>

		<p>{$post.description}</p>

		<div class="post-content">{$post.content}</div>
	</article>

    {if $relatedPosts}
	    <section>
		    <h2>Похожие статьи</h2>

		    <div class="posts-grid">
                {foreach $relatedPosts as $relatedPost}
				    <article class="post-card">
					    <a href="/post.php?id={$relatedPost.id}">
						    <img
								    src="{$relatedPost.image}"
								    alt="{$relatedPost.title}"
								    width="320"
								    height="180"
						    >
					    </a>

					    <h3>
						    <a href="/post.php?id={$relatedPost.id}">
                                {$relatedPost.title}
						    </a>
					    </h3>

					    <p>{$relatedPost.description}</p>
				    </article>
                {/foreach}
		    </div>
	    </section>
    {/if}
</main>
</body>
</html>