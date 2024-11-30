<h1><?= $title ?></h1>

<p>
    This area is protected.
    A valid OTP code is required to access this page.
</p>

<form method="post">
    <p>
        <label for="code">OTP Code:</label><br />
        <input type="number" id="code" size="10" name="code" required autofocus>
    </p>

    <input type="submit" name="login" value="Login">
</form>
