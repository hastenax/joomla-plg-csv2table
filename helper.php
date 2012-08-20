<?php

require_once('parsecsv.lib.php');

abstract class CSV2TableHelper 
{
    public static function getTableFromCSV($text, $delimiter = ';')
    {
	$csv = new parseCSV();
	
	$csv->delimiter = $delimiter;
	ob_start();
	$csv->parse($text."\n");

	echo '<tr>';
	foreach ($csv->titles as $value)
	{
	    echo '<th>'.$value.'</th>';
	}
	echo '</tr>';
	foreach ($csv->data as $key => $row)
	{
	    echo '<tr>';
		foreach ($row as $value)
		{
			echo '<td>'.$value.'</td>';
		}
	    echo '</tr>';
	}
	return ob_get_clean();
    }
}
?>
