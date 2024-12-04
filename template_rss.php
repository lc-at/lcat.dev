<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>lcat.dev</title>
        <link>https://lcat.dev</link>
        <atom:link href="https://lcat.dev/?rss" rel="self" type="application/rss+xml" />
        <description>hello world</description>
        <?php foreach ($posts as $post) : ?>
            <item>
                <title><?= htmlspecialchars($post->title, ENT_XML1) ?></title>
                <link><?= 'https://lcat.dev/' . getPostViewURL($post->id, $post->isHidden()) ?></link>
                <description><?= htmlspecialchars(substr($post->content, 0, 100), ENT_XML1) ?></description>
                <guid isPermaLink="false"><?= $post->id ?></guid>
            </item>
        <?php endforeach; ?>
    </channel>
</rss>
