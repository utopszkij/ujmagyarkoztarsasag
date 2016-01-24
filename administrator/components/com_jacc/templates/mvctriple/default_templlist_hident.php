        <td>
##ifdefFieldchecked_out_timeStart##
##ifdefFieldchecked_outStart## 	        
        		##codestart##
				if ( JTable::isCheckedOut($this->user->get ('id'), $row->checked_out ) ):
							echo $row-><?php echo $this->hident ?>;
						else:
							##codeend##
##ifdefFieldchecked_out_timeEnd##
##ifdefFieldchecked_outEnd##							
							<a ##codestart## echo $onclick; ##codeend##href="##codestart## echo $link; ##codeend##">##codestart## echo $row-><?php echo $this->hident ?>; ##codeend##</a>
##ifdefFieldchecked_out_timeStart##
##ifdefFieldchecked_outStart##							
							##codestart##	
				endif;			
				##codeend##
##ifdefFieldchecked_out_timeEnd##
##ifdefFieldchecked_outEnd## 									
		</td>