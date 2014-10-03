<?
if (!defined('FROM_INDEX')) go_to_error404_page();


if (isset($_GET['id']) and true /*это число*/)
{
	$mode = 'by_id'; 
	$id = $_GET['id'];  // article id
}
else $mode = 'none';


if ($_POST['delete-order-button'])
{
	delete_order($_POST['id']);
	
	$url = '?act='.$act_array[$act_index]['short'];
	?> <script>document.location.href="<?=$url?>";</script> <?
}
else if ($_POST['update-order-button'])
{
	update_order($_POST['id'], $_POST['comments']);
	show_success_message();
}


// -----
if ($mode == 'none')
{
	$orders = get_all_orders_list();

	if (!$orders)
		echo '<h3>Нет заказов!</h3>';
	else
	{
		echo '<h3>Список заказов:</h3><br>';

		for ($i = 0; $i < count($orders); $i++)
		{		
			$url = '?act='.$act_array[$act_index]['short'].'&id='.$orders[$i]['id'];
			
			?>
				<b>№<?=$orders[$i]['id']?></b>.
				Полная стоимость: <b><?=$orders[$i]['full_cost']?></b><br><br>
				Отправитель: <b><?=$orders[$i]['user_email']?></b><br>
				Дата: <b><?=$orders[$i]['date']?></b><br>
				Комментарий: <b><?=$orders[$i]['comments']?></b><br>
				<h3><a href="<?=$url?>">Подробнее</a></h3>
				<br><br><br>
			<?
		}
	}
}
else if ($mode == 'by_id')
{
	// добавить добавление картинок, установление даты, форматтер текста !!!
	$data = get_full_order_data($id);
	
	?>
	<h3>Подробная информация о заказе №<?=$data['order']['id']?>:</h3>
	<br>
	Дата составления заказа: <b><?=$data['order']['date']?></b><br>
	<br>
	<h4>Данные о заказчике:</h4>
	
	Имя: <b><?=$data['consumer']['name']?></b><br>
	E-mail: <b><?=$data['consumer']['email']?></b><br>
	Номер телефона: <b><?=$data['consumer']['phone']?></b><br>
	Адрес: <b><?=$data['consumer']['address']?></b><br>
	
	<br><br><br>
	
	<b>Заказ:</b><br>
	
	<? print_r($data['order']['data']); ?>
	
	<br><br><br>
	
	Полная стоимость: <b><?=$data['order']['full_cost']?></b> рублей
	
	<br><br><br><br><br><br>
	<form method="post" action="">
		<input type="hidden" name="id" value="<?=$data['order']['id']?>">

		Комментарии менеджера:<br>
		<textarea name="comments" id="textarea_input" class="mini_textarea"><?=$data['order']['comments']?></textarea>
		<br><br>
		<input type="submit" value="Сохранить" name="update-order-button" id="button" class="normal_button">
		<input type="submit" value="Удалить письмо" name="delete-order-button" id="button" class="normal_button">
	</form>
	<?
}
?>