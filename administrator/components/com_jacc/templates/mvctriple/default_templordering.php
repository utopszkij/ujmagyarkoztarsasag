<?php defined('_JEXEC') or die('Restricted access'); ?>

        <td>
        	<span>##codestart## echo $this->pagination->orderUpIcon( $i, true, 'orderup', 'Move Up', ($this->lists['order'] == 'a.ordering' and $this->lists['order_Dir'] == 'asc'));##codeend##</span>
			<span>##codestart## echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', ($this->lists['order'] == 'a.ordering' and $this->lists['order_Dir'] == 'asc') );##codeend##</span>
        </td>
