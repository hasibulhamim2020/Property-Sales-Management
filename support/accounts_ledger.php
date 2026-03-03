<?php 
	$led=mysql_query("SELECT group_id ,group_name FROM ledger_group");
	if(mysql_num_rows($led) > 0)
	{
		$ledger = '[';
		while($ledg = mysql_fetch_row($led)){
		  $ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
		}
		$ledger = substr($ledger, 0, -1);
		$ledger .= ']';
	}
	else
	{
		$ledger = '[{ name: "empty", id: "" }]';
	}
//echo $data;

?>
<script type="text/javascript">

function checkUserName()
{	
	var e = document.getElementById('ledger_name');
	if(e.value=='')
	{
		alert("Invalid Ledger Name!!!");
		e.focus();
		return false;
	}
	else
	{
		$.ajax({
		  url: '../common/check_entry.php',
		  data: "query_item="+$('#ledger_name').val()+"&pageid=account_ledger",
		  success: function(data) 
		  	{			
			  if(data=='')
			  	return true;
			  else	
			  	{
				alert(data);
				e.value='';
				e.focus();
				return false;
				}
			}
		});
	}
}

$(document).ready(function(){
	
	$(function() {
		$("#open_date").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-y'
		});
	});

});
function DoNav(theUrl)
{
	document.location.href = 'account_ledger.php?ledger_id='+theUrl;
}
$(document).ready(function(){
	
	
    function formatItem(row) {
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data = <?php echo $ledger; ?>;
    $("#ledger_group_id").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });


</script>