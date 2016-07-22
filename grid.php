<?php
class JMyGrid extends JHtmlGrid
{
    public static function sort($title, $order, $direction = 'asc', $selected = '', $task = null, $new_direction = 'asc', $tip = '')
    {
        $direction = strtolower($direction);
        $icon = array('fa-sort-alpha-asc', 'fa-sort-alpha-desc');
        $index = (int) ($direction == 'desc');

        if ($order != $selected)
        {
            $direction = $new_direction;
        }
        else
        {
            $direction = ($direction == 'desc') ? 'asc' : 'desc';
        }

		$html = '<a href="#" onclick="Joomla.tableOrdering(\'' . $order . '\',\'' . $direction . '\',\'' . $task . '\');return false;"'
			. ' data-toggle="tooltip" title="' . JHtml::tooltipText(($tip ? $tip : $title), 'JGLOBAL_CLICK_TO_SORT_THIS_COLUMN') . '">';

        if (isset($title['0']) && $title['0'] == '<')
        {
            $html .= $title;
        }
        else
        {
            $html .= JText::_($title);
        }

        if ($order == $selected)
        {
            $html .= ' <i class="fa ' . $icon[$index] . '"></i>';
        }

        $html .= '</a>';

        return $html;
    }
}
?>