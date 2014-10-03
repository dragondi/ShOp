<?
function register_writer($name, $link)
{
	if ($name == '') return 'Поле "Имя" должно быть заполнено!';
	
	if ($link != '' && !strstr($link, 'http://') && !strstr($link, 'https://'))
		$link = 'http://'.$link;
		
	$query = "INSERT INTO writers SET name = '$name', link = '$link'";
	mysql_query($query);
}

function delete_writer($id)
{
	$query = "DELETE FROM writers WHERE id = '$id'";
	mysql_query($query);

    $query = "UPDATE articles SET writer_id = '0' WHERE writer_id = '$id'";
    mysql_query($query);
}

function update_writer($id, $name, $link)
{
	if ($link != '' && !strstr($link, 'http://') && !strstr($link, 'https://'))
		$link = 'http://'.$link;
		
	$query = "UPDATE writers SET name = '$name', link = '$link' WHERE id = '$id'";		
	mysql_query($query);
}


function get_writers_list()
{
	$query = "SELECT * FROM writers";
	return get_norm_mysql_rows($query);
}

function get_writer_data($id)
{
	$query = "SELECT * FROM writers WHERE id = '$id'";
	$query = mysql_query($query);
	return mysql_fetch_assoc($query);
}
?>