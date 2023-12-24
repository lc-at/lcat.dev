<h1><?= htmlspecialchars($title); ?></h1>

<?php if (isLoggedIn()) : ?>
    <p>
        [<a href="<?= getPostEditURL($post->id) ?>">Edit</a>]
        [<a href="<?= getPostDeleteURL($post->id) ?>" onclick="return confirm('Are you sure?')">Delete</a>]
    </p>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        const content = <?= json_encode($post->content) ?>;
        const contentPre = document.getElementById("content");
        const renderedContentDiv = document.getElementById("renderedContent");
        renderedContentDiv.innerHTML = marked.parse(content);
        contentPre.style.display = "none";
    });
</script>

<pre id="content"><?= htmlspecialchars($post->content) ?></pre>
<div class="post-content" id="renderedContent"></div>

<small class="post-metadata">
    Created: <?= $post->createdAt ?>, Updated: <?= $post->updatedAt ?>, ID: <?= $post->id ?>
</small>

<?php if (isset($config['giscus_repo'])): ?>
<script src="https://giscus.app/client.js"
        data-repo="<?= $config['giscus_repo'] ?>"
        data-repo-id="<?= $config['giscus_repo_id'] ?>"
        data-category="<?= $config['giscus_category'] ?>"
        data-category-id="<?= $config['giscus_category_id'] ?>"
        data-mapping="pathname"
        data-strict="0"
        data-reactions-enabled="0"
        data-emit-metadata="0"
        data-input-position="bottom"
        data-theme="light"
        data-lang="en"
        crossorigin="anonymous"
        async>
</script>
<?php endif; ?>
