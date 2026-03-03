<?php 
$data = array();

	$data['a'] = $_REQUEST['a'];
	$data['b'] = $_REQUEST['b'];
	$data['c'] = $_REQUEST['c'];
	$data['d'] = $_REQUEST['d'];
	$data['e'] = $_REQUEST['e'];
	$data['f'] = $_REQUEST['f'];
	$count 	   = $_REQUEST['count']+1;

?>
<style>.deleted{
display:none;
}</style>
<table id="rowid<?=$count;?>" class="table_normal1" width="97%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #C1DAD7;" cellpadding="2" cellspacing="2">
	<tr align="left" id="rowid<?=$count;?>" height="30">
<td>
<input name="a<?=$count;?>" id="a<?=$count;?>" type="text" readonly="true" class="input3" value="<?=$data['a'] ?>"/>
</td>
<td>
<input name="c<?=$count;?>" id="c<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['c'] ?>" size="10"/>
</td>
<td>
<input name="b<?=$count;?>" id="b<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['b'] ?>" size="10"/>
</td>
<td>
<input name="d<?=$count;?>" id="d<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['d'] ?>"/>
</td>
<td>
<input name="e<?=$count;?>" id="e<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['e'] ?>" size="10"/>
</td>
<td width="100"><a href="#" onclick="deletethis<?=$count;?>();"><img src="../../images/delete.png" width="16" height="16" /></a></td>
	</tr>		
</table>
<input name="deleted<?=$count;?>" id="deleted<?=$count;?>" type="hidden" value="no" />
<script type="text/javascript">
function deletethis<?=$count;?>()
{
	document.getElementById('rowid<?=$count;?>').className='deleted';
document.getElementById("total_amount").value = ((document.getElementById("total_amount").value)*1)-((document.getElementById("e<?=$count;?>").value)*1);
	document.getElementById('deleted<?=$count;?>').value='yes';
	document.getElementById('rowid<?=$count;?>').style.display='none';
}
</script>