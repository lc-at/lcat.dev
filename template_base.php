<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lcat &mdash; <?= $title ?></title>

    <link href="https://fonts.cdnfonts.com/css/fantasque-sans-mono" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>

    <nav>
        <header>
            <div>
                <marquee style="width: 0.1ch">
                    ggO^[&lt;80&gt;&lt;fd&gt;a:!&lt;80&gt;kbr!figlet -f small
                    &lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kbmini
                    no_34st3r_399_h3r3_get_your_w&lt;80&gt;kbew&lt;80&gt;kb&lt;80&gt;kbreward_email_me^Mggd8j</marquee><strong><span class="lcat-l-letter">l</span>cat</strong>
            </div>
            <small>My personal <code>/var/log</code></small>
        </header>

        <?php
        function activeIfEqual($a, $b)
        {
            return $a == $b ? 'active' : '';
        }
        ?>

        <ul>
            <li><a href="<?= getHomeURL() ?>" class="<?= activeIfEqual($title, 'Home') ?>">Home</a></li>
            <li><a href="<?= getContactURL() ?>" class="<?= activeIfEqual($title, 'Contact') ?>">Contact</a></li>
            <?php if (isLoggedIn()) : ?>
                <li><a href="<?= getPostCreateURL() ?>" class="<?= activeIfEqual($title, 'Write') ?>">Write</a></li>
                <li><a href="<?= getLogoutURL() ?>">Logout</a></li>
            <?php else : ?>
                <li><a href="<?= getLoginURL() ?>" class="<?= activeIfEqual($title, 'Login') ?>">HackMe!</a></li>
            <?php endif; ?>
        </ul>

        <form action="<?= getHomeURL(); ?>">
            <input type="text" name="q" placeholder="Search" />
        </form>
    </nav>

    <main>
        <?php if ($messages = getFlashedMessages()) : ?>
            <div class="messages">
                <b>Messages from server:</b>
                <ol>
                    <?php foreach ($messages as $message) : ?>
                        <li><?= $message ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>
        <?php require_once $templatePath; ?>
    </main>
</body>

</html>
