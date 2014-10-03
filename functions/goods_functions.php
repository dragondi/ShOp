<?
function add_new_good($title, $category_id)
{
	$query = "INSERT INTO goods SET title = '$title', category_id = '$category_id'";
	mysql_query($query);
	
	return mysql_insert_id();
}


function update_good($id, $title, $info, $cost, $popularity, $description, $keywords)
{//доделать
	$query = "UPDATE goods SET 
		title = '$title', 
		info = '$info',
		cost = '$cost',
		popularity = '$popularity',
		description = '$description', 
		keywords = '$keywords'
		WHERE id = '$id'
	";		
	mysql_query($query);
}

function delete_good($id)
{
	$query = "DELETE FROM goods WHERE id = $id";
	mysql_query($query);

    $query = "DELETE FROM comments WHERE good_id = $id";
    mysql_query($query);
}


function get_goods_list_by_category_id($id)
{
    return get_goods_by_query("SELECT * FROM goods WHERE category_id = '$id'", 1);
}

function get_good_data($id)
{
    return get_goods_by_query("SELECT * FROM goods WHERE id = '$id'", 0);
}

function get_popular_goods()
{
    return get_goods_by_query("SELECT * FROM goods WHERE popularity = '1'", 1);
}


function get_goods_by_query($query, $is_result_array)
{
    $data = get_norm_mysql_rows($query);

    if ($data)
    {
        for ($i = 0; $i < count($data); $i++)
            $data[$i]['img'] = GOODS_GALLERY_PATH . $data[$i]['img'];

        if (count($data) == 1 and !$is_result_array) $goods = $data[0];
        else $goods = $data;
    }

    return $goods;
}
?>