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
                <strong><span class="lcat-l-letter">l</span>cat</strong>
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
