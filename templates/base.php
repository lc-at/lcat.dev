<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>lcat &mdash; <?= $title ?></title>

    <link href="https://fonts.cdnfonts.com/css/fantasque-sans-mono" rel="stylesheet" />
    <style>
        html {
            background-color: #fbf1c7;
        }

        body {
            font-family: "Fantasque Sans Mono", monospace;
            color: #3c3836;
            margin: 1em;
            margin-top: 2em;
            font-size: 1rem;
        }

        pre,
        code {
            font-family: "Fantasque Sans Mono", monospace;
            color: #af3a03;
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
                padding: 0rem 10%;
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

        header>h1 {
            margin-bottom: 0.05rem;
        }

        nav {
            padding: 1.5rem 0rem;
            display: flex;
        }

        nav>a {
            margin-right: 1.2rem;
            font-size: 1.1em;
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

        .post-content {
            border: 1px solid #282828;
            padding: 0.5rem;
            word-wrap: break-word;
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
    </style>
</head>

<body>
    <header>
        <div>
            <marquee style="width: 0.1ch">
                ggO^[&lt;80&gt;&lt;fd&gt;a:!&lt;80&gt;kbr!figlet -f small
                &lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kb&lt;80&gt;kbmini
                no_34st3r_399_h3r3_get_your_w&lt;80&gt;kbew&lt;80&gt;kb&lt;80&gt;kbreward_email_me^Mggd8j</marquee><strong><span style="background-color: #282828; color: #fbf1c7">l</span>cat</strong>
        </div>
        <small>My personal <code>/var/log</code></small>
    </header>

    <nav>
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Search</a></li>
        </ul>
    </nav>

    <main>
        <?php require_once $templatePath; ?>
    </main>
</body>

</html>
