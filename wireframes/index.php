<?php $body_class = 'login'; ?>
<?php include_once '_header.php'; ?>
<form action="list.php">
	<input type="text" placeholder="email address" />
	<input type="password" placeholder="password" />
	<input type="submit" value="Login" />
	<br />
	<a href="forgot.php">Forgot your password?</a> | <a href="register.php">Register</a>
</form>
<?php include_once '_footer.php'; ?>