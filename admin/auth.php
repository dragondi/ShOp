<?
if (!defined('FROM_INDEX')) go_to_error404_page();


if ($_POST['admin-login-button'])
{
	$auth_message = log_in_admin($_POST['email'], $_POST['password']);
}
else if ($_POST['admin-restore-button'])
{
	$restore_message = log_in_admin($_POST['email'], $_POST['password']);
}


if (!is_admin_logged_in())
{
	if ($auth_message)
		$auth_message = '<h4 style="color: red;">'.$auth_message.'</h4>';
	else $auth_message = '<h3>Вход в администрационную панель</h3>';

	if ($restore_message)
		$restore_message = '<h4 style="color: red;">'.$restore_message.'</h4>';
	else $restore_message = '<h3>Забыли пароль?</h3>';
	
	
	?>
	<table width="100%" height="100%">
	<tr align="center"><td>
		
		<?=$auth_message?>
		<form method="post" action="">
			E-mail: <br>
			<input type="text" name="email" value="<?=$_POST['email']?>" maxlength="25" style="position:relative; top: 6px; width: 175px;"/>
			<br><br>
			Пароль: <br>
			<input type="password" name="password" maxlength="25" style="position:relative; top: 6px; width: 175px;"/>
			<br><br>
			<input type="submit" value="Войти" name="admin-login-button" style=" width: 175px;">
		</form>
		
		<br><br><br>
		
		<?=$restore_message?>
		<form method="post" action="">
			E-mail: <br>
			<input type="text" name="login" maxlength="25" style="position:relative; top: 6px; width: 175px;"/></p>
			<input type="submit" value="Восстановить" name="admin-restore-button" style=" width: 175px;">
		</form>
	</td></tr>
	</table>
	
	<br><br><br><br>
	<?
}
else unset($_POST);
?>