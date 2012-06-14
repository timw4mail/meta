<h1>meta</h1>
<h3>Login</h3>

<form action="<?= miniMVC\site_url('welcome/login') ?>" method="post">
<dl>
	<dt><label for="user">Username:</label></dt>
	<dd><input type="text" id="user" name="user" /></dd>

	<dt><label for="pass">Password:</label></dt>
	<dd><input type="password" id="pass" name="pass" /></dd>

	<dt>&nbsp;</dt>
	<dd><button type="submit">Login</button></dd>
</dl>
</form>