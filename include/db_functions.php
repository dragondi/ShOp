<?
function db_connect()
{
    $host = 'localhost';
    $db_name = 'shop';
    $username = 'shop';
    $password = '123';

    $db = mysql_connect($host, $username, $password);

    if (!$db) exit('Ошибка подключения к базе данных!');
    else
	{
        mysql_query("SET NAMES 'utf-8'");
        mysql_query("SET CHARACTER SET 'utf8';");
        mysql_query("SET SESSION collation_connection = 'utf8_general_ci';");
		
        if (!mysql_select_db($db_name, $db))
			exit('База данных <b>"'.$db_name.'"</b> недоступна!');
    }

    unset($db_host, $db_name, $db_user, $db_password);
	
	return $db;
}

function db_disconnect($db)
{
	mysql_close($db);
}


// ======================================================================================
function get_mysql_row($query)
{
	if($result = mysql_query($query))
		if (mysql_num_rows($result) <= 1 && mysql_num_rows($result) > 0)
		{
			return mysql_fetch_array($result);	
		}
		else
		{
			return 0;		
		}
	return 0;
}

function get_mysql_rows($query)
{
	$current_row = 0;
	if($result = mysql_query($query))
		if (mysql_num_rows($result) > 0)
		{
			while ($row = mysql_fetch_array($result))
			{
				$nb_cols = mysql_num_fields($result);
				for($i=0;$i<$nb_cols;$i++)
					$mysql_array[$current_row][$i] = $row[$i];
				$current_row++;
			}	
			return $mysql_array;
		}
		else
		{
			return 0;
		}
	return 0;
}

function get_norm_mysql_rows($query)
{
	$current_row=0;
	if($result=mysql_query($query))
		if(mysql_num_rows($result)>0)
		{
			while($row=mysql_fetch_assoc($result))
			{
				$mysql_array[$current_row]=$row;
				$current_row++;
			}	
			return $mysql_array;
		}
		else
		{
			return 0;
		}
	return 0;
}

function execute_queries($query,$type_error="none")
{
	global $msg_error_sql_db;
	$flag = 1;
	while ($each_query = each($query))
		if (!(mysql_query($each_query[1])))
		{
			if(strtoupper($type_error) == "DEBUG")
			{
				echo($msg_error_sql_db); 
				echo("<br>Mysql Query : " . $each_query[1]);
				echo("<br>Mysql Error : " . mysql_error());
			}
			else
			{ 
				if (strtoupper($type_error) == "SMOOTH")
					echo("<br>" . $each_query[1] . " <font color=\"#ff0000\">[ERROR]</font>");
			}
			
			$flag = 0;
		}
		else
		{
			if($type_error=="smooth")
				echo("<br>" . $each_query[1] . " <font color=\"#006600\">[OK]</font>");
		}
	return $flag;
}

function get_mysql_value($query,$display = "yes")
{
	if($result = mysql_query($query))
		if (mysql_num_rows($result) <= 1 && mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
			return $row[0];
		}
		else return 0;
		
	if ($display == "yes") print_mysql_error($query);
	
	return 0;
}
?>