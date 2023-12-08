<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once('config.php');

$handle = new SQLite3($config->database_path);

function getAllPostsPinnedFirst()
{
    global $handle;

    $stmt = $handle->prepare("SELECT id, title, content,
                                COALESCE(is_pinned, FALSE) as is_pinned,
                                is_markdown, created as created_at,
                                last_updated as updated_at
                            FROM log_post
                            ORDER BY is_pinned DESC, created DESC
                            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', 20, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', 0, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $posts = array();
    while ($row = $result->fetchArray()) {
        $posts[] = $row;
    }
    return $posts;
}

function getPostById($id)
{
    global $handle;

    $stmt = $handle->prepare("SELECT id, title, content,
                                COALESCE(is_pinned, FALSE) as is_pinned,
                                is_markdown, created as created_at,
                                last_updated as updated_at
                            FROM log_post
                            WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $post = $result->fetchArray();
    return $post;
}
