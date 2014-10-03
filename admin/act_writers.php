<?
if (!defined('FROM_INDEX')) go_to_error404_page();


if ($_POST['delete-writer-button'])
{
	delete_writer($_POST['id']);
	unset($_POST);
}
else if ($_POST['writer-reg-button'])
{
	register_writer($_POST['name'], $_POST['link']);
}


$writers = get_writers_list();


if (count($writers) > 0)
	echo '<h3>Список писателей:</h3>';

for ($i = 0; $i < count($writers); $i++)
{
	$id = $writers[$i]['id'];
	$name = $writers[$i]['name'];
	$link = $writers[$i]['link'];

    $deleting_form = get_delete_smth_form($id, 'delete-writer-button');

    echo '
        <table width="90%">
        <tr>
            <td width="300">
                Имя: <b>'.$name.'</b><br>
                Ссылка: <b><a href="'.$link.'">'.$link.'</a></b><br>
            </td>
            <td width="*"></td>
            <td width="130">
                <b><a href="?act=articles&writer_id='.$id.'">Подробнее</a></b>
            </td>
            <td width="50"></td>
            <td width="130">
                '.$deleting_form['button'].'
            </td>
        </tr>
        </table>

        <br><br>
    ';

    echo $deleting_form['modal'];
}


if ($add_new_writer_message) 
	$add_new_writer_message = '<h4 style="color: red;">'.$add_new_writer_message.'</h4>';
else $add_new_writer_message = '<h3>Добавление нового писателя:</h3>';

?>
<br><br>

<form method="post" action="">
	<?=$add_new_writer_message?>
	Имя:<br>
	<input type="text" name="name" value="<?=$_POST['name']?>" maxlength="40" id="text_input"/><br><br>
	Ссылка:<br>
	<input type="text" name="link" value="<?=$_POST['link']?>" maxlength="200" id="text_input"/>
	<br><br><br>
	<input type="submit" value="Создать" name="writer-reg-button" id="button" class="normal_button">
</form>