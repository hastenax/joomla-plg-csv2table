<?php
/*
 * CSV 2 Table Plugin
 *
 * @version 1.2
 * @author Vladislav Galyanin (v.galyanin@gmail.com)
 * @copyright (C) 2012 by Union D
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

require_once 'helper.php';

class plgContentCsv2table extends JPlugin
{
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$app = JFactory::getApplication();
		
		$oldtext = $article->text;
		
		$dcsv['sortable'] = $this->params->get( 'sortable' );
		$dcsv['delimiter'] = $this->params->get( 'delimiter', ';');
		
		$matches = array();
		
		$n = preg_match_all('/{csv}(.*?){\/csv}/s', $article->text, $matches);
		
		if ($dcsv['sortable'] && $n > 0)
		{
			$article->text = '<script type="text/javascript" src="plugins/content/csv2table/sorttable.js"></script>'.$article->text;
		}
		
		if (isset($matches[1]))
		{
		    $i =0;
		    $id = substr(md5($_SERVER['REQEST_URI'].$i), 0, 7);
		    foreach($matches[1] as $mkey => $mvalue)
		    {		
			    $content = '<table id="'.$id.'" class="displaycsv_sortable'.(($dcsv['sortable'] == false) ? '_not' : '').'">';
			    $content .= CSV2TableHelper::getTableFromCSV($mvalue, $dcsv['delimiter']);
			    $content .= '</table>';
			    $article->text = str_replace($matches[0][$i], $content, $article->text);
			    $i++;
		    }
		}
		
		if ($n > 0 && $this->params->get('copyrights') != 'no') 
		{
			$article->text .= '<div style="color:gray;font-size:small;margin-top:1em;">csv 2 table powered by <a href="http://union-d.ru">Union Development</a></div>';
		}
		
		unset($dcsv);
	}
}
?>