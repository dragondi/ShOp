<?
include_once('include/config.php');

include_once('include/db_functions.php');

include_once('functions/work_functions.php');
include_once('functions/articles_functions.php');
include_once('functions/sliders_functions.php');
include_once('functions/user_functions.php');
include_once('functions/cart_functions.php');
include_once('functions/orders_functions.php');

define('FROM_INDEX', true);

$db = db_connect();

// ======================================================================================
// ======================================================================================
if (!is_user_logged_in()) echo 'оффлайн';
else echo 'онлайн';


if ($_POST['user-login-button'])
{
	log_in_user($_POST['email'], $_POST['password']);
}
?>
	<br><br>
	<form method="post" action="">
		E-mail: <input type="text" name="email" value="<?=$_POST['email']?>" maxlength="25" style="position:relative; top: 6px; width: 175px;"/>
		Пароль: <input type="password" name="password" maxlength="25" style="position:relative; top: 6px; width: 175px;"/>
		<input type="submit" value="Войти" name="user-login-button" style=" width: 175px;">
	</form>
	<br><br>
<?

clear_cart();
add_to_cart(6, 2);
add_to_cart(7, 8);
add_to_cart(8, 2);
//add_new_order();

add_to_cart(6, 1);
add_to_cart(7, 4);
add_to_cart(8, 1);
//add_new_order();

echo '<br><br>admin:<br>';
print_r($_SESSION['admin']);

echo '<br><br>user:<br>';
print_r($_SESSION['user']);

echo '<br><br>cart:<br>';
print_r($_SESSION['cart']);

echo '<br><br><br>';
echo htmlspecialchars(cart_data_to_text(), ENT_QUOTES);

echo '<br><br>';
echo calculate_full_cost($_SESSION['cart']);

echo '<br><br><br>';
print_r(text_to_cart_data(cart_data_to_text()));

echo '<br><br><br>';
echo calculate_full_cost(text_to_cart_data(cart_data_to_text()));


echo '<br><br><br>';
// ======================================================================================
// ======================================================================================

exit_index($db);


// ===
function exit_index($db)
{
	db_disconnect($db);
	exit();
}
?>