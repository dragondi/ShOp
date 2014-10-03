<?
function add_new_fb_message($user_id, $topic, $text)
{// добавить отправку писем админам
	$now = date('Y.m.d');
	$query = "INSERT INTO feedback_messages SET user_id = '$user_id', topic = '$topic', text = '$text', date = '$now'";
	mysql_query($query);
}

/* возвращает массив следующих элементов:
	$data[]['id'] - id сообщения
	$data[]['topic'] - тема сообщения
	$data[]['date'] - дата отправления сообщения
	$data[]['user_id'] - id отправителя
	$data[]['author_email'] - почта отправителя
	$data[]['comment'] - комментарий к сообщению
*/
function get_all_fb_list()
{
	$query = "SELECT id, user_id, topic, date, comments FROM feedback_messages ORDER BY date";
	$data = get_norm_mysql_rows($query);
	
	if (!$data) return null;
	
	for ($i = 0; $i < count($data); $i++)
	{
		$user_data = get_user_data($data[$i]['user_id']);
		$data[$i]['author_email'] = $user_data['email'];
		
		if ($data[$i]['comments'] == '') $data[$i]['comments'] = 'Нет комментариев';
	}
	
	return $data;
}

/* возвращает следующий элемент:
	$data['message'] - данные feedback message
	$data['author'] - данные отправителя
*/
function get_full_fb_message_data($id)
{
	$query = "SELECT * FROM feedback_messages WHERE id = '$id'";
	$query = mysql_query($query);
	$data['message'] = mysql_fetch_assoc($query);
	
	$query = "SELECT * FROM users WHERE id = '".$data['message']['user_id']."'";
	$query = mysql_query($query);
	$data['author'] = mysql_fetch_assoc($query);
	
	return $data;
}


function delete_fb_message($id)
{
	$query = "DELETE FROM feedback_messages WHERE id = '$id'";
	mysql_query($query);
}



function update_fb_message($id, $comments)
{
	$query = "UPDATE feedback_messages SET comments = '$comments' WHERE id = '$id'";
	mysql_query($query);
}
?>