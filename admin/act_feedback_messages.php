<?
if (!defined('FROM_INDEX')) go_to_error404_page();


if (isset($_GET['id']) and true /*это число*/)
{
	$mode = 'by_id'; 
	$id = $_GET['id'];  // article id
}
else $mode = 'none';


if ($_POST['delete-fb_message-button'])
{
	delete_fb_message($_POST['id']);
	
	$url = '?act='.$act_array[$act_index]['short'];
	?> <script>document.location.href="<?=$url?>";</script> <?
}
else if ($_POST['update-fb_message-button'])
{
	update_fb_message($_POST['id'], $_POST['comments']);
	show_success_message();
}


// -----
if ($mode == 'none')
{
	$messages = get_all_fb_list();

	if (!$messages)
		echo '<h3>Нет писем!</h3>';
	else
	{
		echo '<h3>Список писем:</h3><br>';

		for ($i = 0; $i < count($messages); $i++)
		{		
			$url = '?act='.$act_array[$act_index]['short'].'&id='.$messages[$i]['id'];
			
			?>
				<b>№<?=$messages[$i]['id']?></b>.
				Тема сообщения: <b><?=$messages[$i]['topic']?></b><br><br>
				Отправитель: <b><?=$messages[$i]['author_email']?></b><br>
				Дата: <b><?=$messages[$i]['date']?></b><br>
				Комментарий: <b><?=$messages[$i]['comments']?></b><br>
				<h3><a href="<?=$url?>">Подробнее</a></h3>
				<br><br><br>
			<?
		}
	}
}
else if ($mode == 'by_id')
{
	$data = get_full_fb_message_data($id);
	
	?>
	<h3>Подробная информация о письме №<?=$data['message']['id']?>:</h3>
	<br>
	Дата отправки: <b><?=$data['message']['date']?></b><br>
	<br>
	<h4>Данные об отправителе:</h4>
	
	Имя: <b><?=$data['author']['name']?></b><br>
	E-mail: <b><?=$data['author']['email']?></b><br>
	Номер телефона: <b><?=$data['author']['phone']?></b><br>
	
	<br><br><br><br>
	<b>Текст:</b><br>
	<?=$data['message']['text']?>
	
	<br><br><br><br><br><br>
	<form method="post" action="">
		<input type="hidden" name="id" value="<?=$data['message']['id']?>">

		Комментарии менеджера:<br>
		<textarea name="comments" id="textarea_input" class="mini_textarea"><?=$data['message']['comments']?></textarea>
		<br><br>
		<input type="submit" value="Сохранить" name="update-fb_message-button" id="button" class="normal_button">
		<input type="submit" value="Удалить письмо" name="delete-fb_message-button" id="button" class="normal_button">
	</form>
	<?
}
?>