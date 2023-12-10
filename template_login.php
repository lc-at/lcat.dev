<h1><?= $title ?></h1>

<p>This area is protected. Please enter your OTP code to continue.</p>

<form method="post">
    <p>
        <label>OTP Code:</label><br />
        <input type="number" size="50" name="code" required autofocus>
    </p>

    <input type="submit" name="login" value="Login">
</form>
