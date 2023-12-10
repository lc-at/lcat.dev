<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once('config.php');

$dbHandle = new SQLite3($config['database_path']);

class PostModel
{
    public $id;
    public $title;
    public $content;
    public $isPinned;
    public $createdAt;
    public $updatedAt;

    public static function map($row)
    {
        $post = new PostModel();
        $post->id = $row['id'];
        $post->title = $row['title'];
        $post->content = $row['content'];
        $post->isPinned = $row['is_pinned'];
        $post->createdAt = $row['created_at'];
        $post->updatedAt = $row['updated_at'];
        return $post;
    }

    public function isHidden()
    {
        return strpos($this->title, '.') === 0;
    }
}

function getAllPostsPinnedFirst($limit, $offset)
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("SELECT id, title, content, is_pinned,
                                created_at, updated_at
                            FROM log_post
                            ORDER BY is_pinned DESC, created_at DESC
                            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $posts = array();
    while ($row = $result->fetchArray()) {
        $posts[] = PostModel::map($row);
    }
    return $posts;
}

function getPost($id)
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("SELECT
            id, title, content, is_pinned, created_at, updated_at
            FROM log_post
            WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $post = $result->fetchArray();
    if ($post) {
        $post = PostModel::map($post);
    }
    return $post;
}

function getContactPost()
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("SELECT
            id, title, content, is_pinned, created_at, updated_at
            FROM log_post
            WHERE LOWER(title) = '.contact'
            ORDER BY updated_at DESC
            LIMIT 1");
    $result = $stmt->execute();
    $post = $result->fetchArray();
    if ($post) {
        $post = PostModel::map($post);
    }
    return $post;
}

function createPost($title, $content, $isPinned)
{
    global $dbHandle;
    $id = generateUUID();
    $stmt = $dbHandle->prepare("INSERT INTO log_post
            (id, title, content, is_pinned, created_at, updated_at)
            VALUES (:id, :title, :content, :is_pinned, :created_at, :updated_at)");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':is_pinned', $isPinned, SQLITE3_INTEGER);
    $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->execute();

    return $id;
}

function updatePost($id, $title, $content, $isPinned)
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("UPDATE log_post
            SET title = :title, content = :content, is_pinned = :is_pinned,
            updated_at = :updated_at
            WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':is_pinned', $isPinned, SQLITE3_INTEGER);
    $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'), SQLITE3_TEXT);
    $stmt->execute();

    return $id;
}

function deletePost($id)
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("DELETE FROM log_post
            WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $stmt->execute();

    return $id;
}

function searchPosts($query, $limit, $offset)
{
    global $dbHandle;
    $stmt = $dbHandle->prepare("SELECT
            id, title, content, is_pinned, created_at, updated_at
            FROM log_post
            WHERE title LIKE :query OR content LIKE :query
            ORDER BY is_pinned DESC, created_at DESC
            LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':query', '%' . $query . '%', SQLITE3_TEXT);
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $posts = array();
    while ($row = $result->fetchArray()) {
        $posts[] = PostModel::map($row);
    }
    return $posts;
}

function generateUUID()
{
    // Get an RFC-4122 compliant globaly unique identifier
    // https://stackoverflow.com/a/55439684/8957465
    $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
