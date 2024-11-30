<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lcat &mdash; <?= $title ?></title>

    <link href="style.css" rel="stylesheet">
</head>

<body>

    <nav>
        <header>
            <div class="header-title">
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

    <script>
				 document
			.addEventListener
		  ("keydown",(function(
		e){const n="lcat";if("h"
	   ===e.key||"l"===e.key){const
	  t=document.querySelector(/*egg*/
	 ".lcat-l-letter"),l=t.parentElement
	 ,c=(n.indexOf(t.innerText)+("h"===
    e.key?-1:1)+4)%4;l.innerHTML="";for(
     let e=0;e<4;e++)if(e===c){const t
      =document.createElement("span");
       t.innerText=n[e],t.classList.
        add("lcat-l-letter"),l./**/
         appendChild(t)} else l.
           innerHTML+=n[e]}}));
               /* hehe */
    </script>
</body>

</html>
