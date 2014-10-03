<?
function update_text($id, $title, $text, $description, $keywords)
{
	$query = "UPDATE texts SET 
		title = '$title', 
		text = '$text',
		description = '$description', 
		keywords = '$keywords'
		WHERE id = '$id'
	";		
	mysql_query($query);
}

function get_text_data($id)
{
	$query = "SELECT * FROM texts WHERE id = '$id'";
	$query = mysql_query($query);
	return mysql_fetch_assoc($query);
}
?>