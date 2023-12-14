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
