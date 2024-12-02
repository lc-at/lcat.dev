<table style="width: 100%">
    <tr>
        <th class="timestamp">Timestamp</th>
        <th>Title</th>
    </tr>
    <?php foreach ($posts as $post) : ?>
        <tr>
            <td>
                <?= $post->createdAt ?><?= $post->isPinned ? 'P' : '' ?>
            </td>
            <td>
                <a class="marked-inline" href="<?= getPostViewURL($post->id, $post->isHidden()) ?>"><?= $post->title ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br />
<form>
    <label for="limit">limit: </label>
    <input type="number" name="limit" id="limit" style="width: 4ch" value="<?= $limit ?>">
    <label for="offset">offset: </label>
    <input type="number" id="offset" name="offset" style="width: 4ch" value="<?= $offset ?>">
    <input type="submit" value="go!" />
</form>
