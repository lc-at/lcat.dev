<h1><?= $title; ?></h1>

<?php if (isset($post)) : ?>
    <p>
        [<a href="<?= getPostViewURL($post->id, $post->isHidden()) ?>">View post</a>]
    </p>
<?php endif; ?>

<form method="post">
    <p>
        <label>Title:</label><br />
        <input type="text" size="50" name="title" value="<?= htmlspecialchars($post->title ?? '') ?>" required autofocus>
    </p>

    <p>
        <label>Content:</label><br />
        <textarea name="content" cols="49" rows="4" required><?= htmlspecialchars($post->content ?? '') ?></textarea>
    </p>

    <p>
        <input type="checkbox" name="isPinned" value="1" id="isPinnedCheck" <?= ($post->isPinned ?? false) ? 'checked' : '' ?>>
        <label for="isPinnedCheck">Pin this post</label>
    </p>

    <input type="submit" value="Submit">
</form>
