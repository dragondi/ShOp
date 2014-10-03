<?
if (!defined('FROM_INDEX')) go_to_error404_page();

if ($_POST['update-text-button'])
{
	update_text($_POST['id'], $_POST['title'], $_POST['text'], $_POST['description'], $_POST['keywords']);
	show_success_message();
}


$data = get_text_data($text_id);

?>
	<h3>Редакирование текста:</h3>
	<form method="post" action="">
		<input type="hidden" name="id" value="<?=$text_id?>">

		Титул:<br>
		<input type="text" name="title" value="<?=$data['title']?>" maxlength="200" id="text_input"/><br>
		<br>
		Текст:<br>
        <script type="text/javascript"> $(document).ready(function(){ $('#textarea_input').editor({ focus: true, toolbar: 'classic' }); }); </script>
		<textarea name="text" id="textarea_input" class="normal_textarea"><?=$data['text']?></textarea>
		<br><br>
		Тег "description":<br>
		<textarea name="description" id="textarea_input" class="mini_textarea"><?=$data['description']?></textarea>
		<br><br>
		Тег "keywords":<br>
		<textarea name="keywords" id="textarea_input" class="mini_textarea"><?=$data['keywords']?></textarea>
		<br><br>
		<input type="submit" value="Сохранить" name="update-text-button" id="button" class="normal_button">
	</form>