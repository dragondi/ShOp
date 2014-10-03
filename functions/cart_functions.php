<?
/*  структура корзины:
	сам массив с данным находится в $_SESSION['cart']
	вид полей:
		$_SESSION['cart'][индекс]['id'] - id товара
		$_SESSION['cart'][индекс]['title'] - название товара
		$_SESSION['cart'][индекс]['cost'] - цена товара
		$_SESSION['cart'][индекс]['count'] - количество товара
		...
		$_SESSION['cart']['id_' + id товара] - индекс - для того чтобы было удобно пользоваться 
		и чтобы инфа была грамотно расположена
*/

function add_to_cart($id, $count)
{
	if (isset($_SESSION['cart']['id_'.$id])) // если такой товар уже есть в корзине
	{
		$index = $_SESSION['cart']['id_'.$id];
		$_SESSION['cart'][$index]['count'] += $count;
	}
	else
	{
		$query = "SELECT title, cost FROM goods WHERE id = '$id'";
		$query = mysql_query($query);
		$r = mysql_fetch_assoc($query);
		
		// находим свободный индекс
		for ($i = 0; ; $i++)
			if (!isset($_SESSION['cart'][$i]))
			{
				$index = $i;
				break;
			}
		
		$_SESSION['cart'][$index]['id'] = $id;
		$_SESSION['cart'][$index]['title'] = $r['title'];
		$_SESSION['cart'][$index]['cost'] = $r['cost'];
		$_SESSION['cart'][$index]['count'] = $count;
		$_SESSION['cart']['id_'.$id] = $index;
	}
}

function remove_from_cart($id, $count)
{
	if (isset($_SESSION['cart']['id_'.$id])) // если такой товар уже есть в корзине
	{
		$index = $_SESSION['cart']['id_'.$id];
		$_SESSION['cart'][$index]['count'] -= $count;
		
		if ($_SESSION['cart'][$index]['count'] <= 0)
		{
			unset($_SESSION['cart']['id_'.$id]);
			
			// удаляем элемент с индексом $index и сдвигаем остальные 
			// части массива так чтобы не было пробелов
			$i = $index;
			while (isset($_SESSION['cart'][$i]))
			{
				$_SESSION['cart'][$i] = $_SESSION['cart'][$i + 1];
				$i++;
			}
		}
	}
}

function clear_cart()
{
	unset($_SESSION['cart']);
}


/* 	переводит данные о корзине из $_SESSION в строку
	sep1 - внешний разделитель
	sep2 - внутренний разделитель
*/
function cart_data_to_text()
{
	$sep1 = '<$###$>';
	$sep2 = '<$#$>';
	
	for ($i = 0; ; $i++)
	{
		if (!isset($_SESSION['cart'][$i])) break;
		
		$data[$i] = implode($sep2, $_SESSION['cart'][$i]);
	}

	return implode($sep1, $data);
}

/* 	переводит данные о корзине из строки в ассоциативный массив. 
	Cтруктура:
		$data[индекс]['id'] - id товара
		$data[индекс]['title'] - название товара
		$data[индекс]['cost'] - цена товара
		$data[индекс]['count'] - количество товара
		
	sep1 - внешний разделитель
	sep2 - внутренний разделитель
*/
function text_to_cart_data($text)
{
	$sep1 = '<$###$>';
	$sep2 = '<$#$>';
	
	$data = explode($sep1, $text);
	
	for ($i = 0; $i < count($data); $i++)
	{
		$array = explode($sep2, $data[$i]);
		
		unset($data[$i]);
		
		$data[$i]['id'] = $array[0];
		$data[$i]['title'] = $array[1];
		$data[$i]['cost'] = $array[2];
		$data[$i]['count'] = $array[3];
	}

	return $data;
}

function calculate_full_cost($cart_data_array)
{
	$full_cost = 0;
	
	for ($i = 0; ; $i++)
	{
		if (!isset($cart_data_array[$i])) break;
		
		$full_cost += $cart_data_array[$i]['count'] * $cart_data_array[$i]['cost'];
	}
	
	return $full_cost;
}
?>