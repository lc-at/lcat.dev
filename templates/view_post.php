<h1><?= htmlspecialchars($post['title']); ?></h1>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        document.getElementById("content").innerHTML = marked.parse(
            document.getElementById("content").innerHTML,
        );
    });
</script>
<div class="post-content" id="content"><?= $post['content']; ?></div>
<small class="post-metadata">
    Created: <?= $post['created_at']; ?>, Updated: <?= $post['updated_at']; ?>, ID:
    <?= $post['id']; ?>
</small>
</small>
</small> </small>
