  <table style="width: 100%">
      <tr>
          <th class="timestamp">Timestamp</th>
          <th>Title</th>
      </tr>
      <?php foreach ($posts as $post) : ?>
          <tr>
              <td><?= $post['created_at'] ?></td>
              <td>
                  <a href="post.php?id=<?= $post['id'] ?>">
                      <?php if ($post['is_pinned']) : ?>[📌]<?php endif; ?>
                      <?= $post['title'] ?>
                  </a>
              </td>
          </tr>
      <?php endforeach; ?>
  </table>

  <form>
      <label>limit: </label>
      <input type="number" name="limit" style="width: 4ch" />
      <label>offset: </label>
      <input type="number" name="offset" style="width: 4ch" />
      <input type="submit" value="go!" />
  </form>
