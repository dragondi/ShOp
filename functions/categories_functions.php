<?
function add_new_category($title, $parent_id, $rank)
{
	$query = "INSERT INTO categories SET title = '$title', rank = '$rank', parent_id = '$parent_id'";
	mysql_query($query);
	
	return mysql_insert_id();
}

function delete_category($id)
{
	$query = "DELETE FROM categories WHERE id = $id";
	mysql_query($query);
}

function update_category($id, $title, $description, $keywords)
{
	$query = "UPDATE categories SET 
		title = '$title', 
		description = '$description', 
		keywords = '$keywords'
		WHERE id = '$id'
	";		
	mysql_query($query);
}


function get_main_categories_list()
{
	$query = "SELECT * FROM categories WHERE rank = '1'";
	return get_norm_mysql_rows($query);
}

function get_categories_list_by_parent_id($parent_id)
{
	$query = "SELECT * FROM categories WHERE rank = '2' AND parent_id = '$parent_id'";
	return get_norm_mysql_rows($query);
}

function get_category_data($id)
{
	$query = "SELECT * FROM categories WHERE id = '$id'";
	$query = mysql_query($query);
	return mysql_fetch_assoc($query);
}
?>