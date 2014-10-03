<?
// все данные берутся из $_SESSION
function add_new_order()
{// добавить отправку писем админам
	$user_id = $_SESSION['user']['id'];
	$data = cart_data_to_text();
	$now = date('Y.m.d');
	
	$query = "INSERT INTO orders SET user_id = '$user_id', data = '$data', date = '$now'";
	mysql_query($query);
	
	clear_cart();
}

/* возвращает массив следующих элементов:
	$data[]['id'] - id заказа
	$data[]['date'] - дата составления заказа
	$data[]['full_cost'] - полная стоимость заказа
	$data[]['user_id'] - id заказчика
	$data[]['user_email'] - почта заказчика
	$data[]['comment'] - комментарий к заказу
*/
function get_all_orders_list()
{
	$query = "SELECT id, user_id, data, date, comments FROM orders ORDER BY date";
	$data = get_norm_mysql_rows($query);
	
	if (!$data) return null;
	
	for ($i = 0; $i < count($data); $i++)
	{
		$user_data = get_user_data($data[$i]['user_id']);
		$data[$i]['user_email'] = $user_data['email'];
		
		$data[$i]['full_cost'] = calculate_full_cost(text_to_cart_data($data[$i]['data']));
		unset($data[$i]['data']);
		
		if ($data[$i]['comments'] == '') $data[$i]['comments'] = 'Нет комментариев';
	}
	
	return $data;
}

/* возвращает следующий элемент:
	$data['order'] - данные заказа
	$data['consumer'] - данные заказчика
*/
function get_full_order_data($id)
{
	$query = "SELECT * FROM orders WHERE id = '$id'";
	$query = mysql_query($query);
	$data['order'] = mysql_fetch_assoc($query);
	
	$data_array = text_to_cart_data($data['order']['data']);
	unset($data['order']['data']);
	$data['order']['data'] = $data_array;
	$data['order']['full_cost'] = calculate_full_cost($data['order']['data']);
	
	$query = "SELECT * FROM users WHERE id = '".$data['order']['user_id']."'";
	$query = mysql_query($query);
	$data['consumer'] = mysql_fetch_assoc($query);
	
	return $data;
}


function delete_order($id)
{
	$query = "DELETE FROM orders WHERE id = '$id'";
	mysql_query($query);
}



function update_order($id, $comments)
{
	$query = "UPDATE orders SET comments = '$comments' WHERE id = '$id'";
	mysql_query($query);
}
?>