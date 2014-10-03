<?
if (!defined('FROM_INDEX')) go_to_error404_page();


if (isset($_GET['id']) and true /*это число*/)
{
	$mode = 'by_id'; 
	$id = $_GET['id'];  // article id
}
else if (isset($_GET['writer_id']) and true /*это число*/)
{
	$mode = 'by_writer_id';
	$writer_id = $_GET['writer_id'];
}
else $mode = 'none';


if ($_POST['article-reg-button'])
{
	if ($_POST['title'])
	{
		$id = add_new_article($_POST['title'], $_POST['writer_id']);	
		$mode = 'by_id';
	}
}
else if ($_POST['delete-article-button'])
{
	delete_article($_POST['id']);
}
else if ($_POST['update-article-button'])
{//доделать
	update_article($_POST['id'], $_POST['title'], $_POST['text'], date_to_int($_POST['date']),
        $_POST['popularity'], $_POST['views_count'], $_POST['description'], $_POST['keywords']);
}
else if ($_POST['comment-reg-button'])
{
	add_new_comment($_POST['author_info'], $_POST['article_id'], 0, $_POST['text'], date_to_int($_POST['date']));
}
else if ($_POST['delete-comment-button'])
{
	delete_comment($_POST['id']);
}
else if ($_POST['update-writer-button'])
{
    update_writer($_POST['id'], $_POST['name'], $_POST['link']);
    unset($_POST);
}


// -----
if ($mode == 'none')
{
	$articles = get_articles_list();
	//print_r($article);

	if (!$articles)
		echo '<h3>Нет статей!</h3>';
	else
	{
		echo '<h3>Список статей:</h3>';

		for ($i = 0; $i < count($articles); $i++)
		{
			$id = $articles[$i]['id'];
			$title = $articles[$i]['title'];
			$url = '\?act='.$act_array[$act_index]['short'].'&id='.$id;

			$writer_data = get_writer_data($articles[$i]['writer_id']);
			
			$link = $writer_data ['link'];
			if ($link != '') $link = ' (<a href="'.$writer_data['link'].'">Ссылка</a>)';
			
			$writer = 'Автор: '.$writer_data['name'].$link;
			
			?>
				Название: <b><?=$title?></b>
				<br>
				<?=$writer?>
				<a href="?act=articles&writer_id=<?=$id?>">(К списку статей этого автора)</a>
				<br>
				<table style="border-spacing: 0px;"><tr><td>
					<button onclick="document.location.href='<?=$url?>'" id="button" class="mini_button">
						Редактировать
					</button>
				</td><td>
					<form method="post" action="">
						<input type="hidden" name="article_id" value="<?=$id?>">
						<input type="submit" value="Удалить" name="delete-article-button" id="button" class="mini_button">
					</form>
				</td></tr></table>
				<br>
			<?
		}
	}
}
else if ($mode == 'by_writer_id')
{
	$articles = get_articles_list_by_writer_id($writer_id);

	$writer_data = get_writer_data($writer_id);
	
	$link = $writer_data ['link'];
	if ($link != '') $link = ' (<a href="'.$writer_data['link'].'">Ссылка</a>)';
	
	echo '<h3>Список статей автора "'.$writer_data['name'].'"'.$link.':</h3>';
	
	if (!$articles)
		echo '<h4>У этого автора нет статей!</h4>';
	else 
		for ($i = 0; $i < count($articles); $i++)
		{
			$id = $articles[$i]['id'];
			$title = $articles[$i]['title'];
			$url = '\?act='.$act_array[$act_index]['short'].'&id='.$id;

            $deleting_form = get_delete_smth_form($id, 'delete-article-button');

			?>
				Название: <b><?=$title?></b>
				<br>
				<table style="border-spacing: 0px;"><tr><td>
					<button onclick="document.location.href='<?=$url?>'" id="button" class="mini_button">
						Редактировать
					</button>
				</td><td>
					<?=$deleting_form['button']?>
				</td></tr></table>
				<br>
			<?

            echo $deleting_form['modal'];
		}

	?>
	<br><br>
	
	<form method="post" action="">
		<h3>Добавление новой статьи:</h3>
		Название:<br><br>
		<input type="text" name="title" maxlength="100" id="text_input"/><br><br>
		
		<input type="hidden" name="writer_id" value="<?=$writer_id?>">
		
		<input type="submit" value="Создать" name="article-reg-button" id="button" class="normal_button">
	</form>

    <br><br><br><br><br><br>
	<?

    $id = $writer_id;
    $data = get_writer_data($id);
    $name = $data['name'];
    $link = $data['link'];

    ?>
    <form method="post" action="">
        <h3>Изменение информации о писателе:</h3>
        Имя:<br>
        <input type="text" name="name" value="<?=$name?>" maxlength="40" id="text_input"/><br>
        Ссылка:<br>
        <input type="text" name="link" value="<?=$link?>" maxlength="200" id="text_input"/><br><br>

        <input type="hidden" name="id" value="<?=$id?>">

        <input type="submit" value="Сохранить" name="update-writer-button" id="button" class="normal_button">
    </form>
    <?
}
else if ($mode == 'by_id')
{
	// добавить добавление картинок
	
	$data = get_article_data($id);
	
	?>
	
	<h3>Редакирование статьи:</h3>
	<form method="post" action="">
		<input type="hidden" name="id" value="<?=$data['id']?>">

		Название:<br>
		<input type="text" name="title" value="<?=$data['title']?>" maxlength="200" id="text_input"/><br>
		<br>
		Текст статьи:<br>
		
		<div style="width: 780px;">
			<script type="text/javascript"> $(document).ready(function(){ $('#textarea_input').editor({ focus: true, toolbar: 'classic' }); }); </script>
			<textarea name="text" id="textarea_input" class="normal_textarea"><?=$data['text']?></textarea>
		</div>
		
		<br><br>

        Дата <span>(формат: "дд.мм.гг". Неправильный формат даты может вызвать ошибку при выводе информации)</span>:<br>
		<input type="text" name="date" maxlength="100" value="<?=$data['date']?>" id="mini_text_input"/><br><br>

        Популярность <span>(если '1', то статья будет отображаться на главной странице)</span>:<br>
        <input type="text" name="popularity" value="<?=$data['popularity']?>" maxlength="200" id="mini_text_input"/><br><br>

        Количество просмотров <span>(цифра, неправильный формат может вызвать ошибку при выводе информации)</span>:<br>
        <input type="text" name="views_count" value="<?=$data['views_count']?>" maxlength="200" id="mini_text_input"/><br><br>

		Тег "description":<br>
		<textarea name="description" id="textarea_input" class="mini_textarea"><?=$data['description']?></textarea>
		<br><br>
		Тег "keywords":<br>
		<textarea name="keywords" id="textarea_input" class="mini_textarea"><?=$data['keywords']?></textarea>
		<br><br>
		<input type="submit" value="Сохранить" name="update-article-button" id="button" class="normal_button">
	</form>

	<br><br><br><br><br><br>
	
	<h3>Коментарии к этой статье:</h3>
	
	<?
	// получаем все комментарии и выводим на экран с кнопками для удаления !!!!
	$comments = get_comments_by_article_id($id);

	if (!$comments)
		echo '<h4>Нет комментариев!</h4>';
	else
	{
		echo '<table width="90%">';
		
		for ($i = 0; $i < count($comments); $i++)
		{
			$comment_id = $comments[$i]['id'];
			$author_info = $comments[$i]['author_info'];
			$text = $comments[$i]['text'];
			$date = $comments[$i]['date'];

			?>
			<tr>
				<td>
					<p>Автор: <b><?=$author_info?></b></p>
					<p>Дата: <b><?=$date?></b></p>
					<p>Комментарий: <b><?=$text?></b></p>
				</td>
				<td width="*"></td>
				<td align="right">
					<form method="post" action="">
						<input type="hidden" name="id" value="<?=$comment_id?>">
						<input type="submit" value="Удалить" name="delete-comment-button" id="button" class="mini_button">
					</form>
				<br>
				</td></tr>
			<?
		}
		
		echo '</table>';
	}

    echo '<br><br><br><br><br><br>';
    print_add_comment_form('article_id', $id);
}
?>