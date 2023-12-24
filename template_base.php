<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lcat &mdash; <?= $title ?></title>

    <link href="https://fonts.cdnfonts.com/css/fantasque-sans-mono" rel="stylesheet">
    <style>
        html {
            background-color: #fbf1c7;
        }

        body {
            color: #3c3836;
            margin: 1em;
            font-size: 1rem;
        }

        pre,
        code {
            color: #af3a03;
            overflow-x: auto;
        }

        body,
        pre,
        code {
            font-family: "Fantasque Sans Mono", monospace;
        }

        @media (max-width: 20rem) {
            body {
                font-size: calc(1rem + 0.00625 * (100vw - 20rem));
            }
        }

        th.timestamp {
            max-width: 10ch;
        }

        @media (min-width: 40rem) {
            body {
                padding: 1rem 10%;
            }

            th.timestamp {
                width: 22ch;
                max-width: 22ch;
            }
        }

        a {
            color: #076678;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline dotted;
        }

        a.active {
            text-decoration: underline;
        }

        header>h1 {
            margin-bottom: 0.05rem;
        }

        nav {
            padding-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        nav>ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            gap: 1.3rem;
        }

        table,
        th,
        td {
            border: 1px solid #282828;
        }

        th {
            background-color: #076678;
            color: #fbf1c7;
        }

        .post-content {
            border: 1px solid #282828;
            padding: 0.5rem;
            word-wrap: break-word;
            overflow-x: auto;
        }

        img {
            max-width: 100%;
        }

        p {
            margin: 0rem 0rem 0.5rem 0rem;
        }

        p:not(:first-child) {
            margin: 1rem 0rem 0.5rem 0rem;
        }

        .post-metadata {
            font-size: small;
            color: #928374;
        }

        .messages {
            border: 1px solid #282828;
            background-color: #ebdbb2;
            padding: 0.5rem;
            margin-bottom: 1rem;
        }

        .lcat-l-letter {
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0% {
                color: #fbf1c7;
                background-color: #282828;
            }

            50% {
                color: #282828;
                background-color: #fbf1c7;
            }

            100% {
                color: #fbf1c7;
                background-color: #282828;
            }
        }

        .giscus {
            padding: 1rem;
            background-color: #ebdbb2;
            margin-top: 1rem;
            width: inherit;
        }

        .giscus-frame {
            width: 100%;
        }
    </style>
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
