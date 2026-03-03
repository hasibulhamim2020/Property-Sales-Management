<?php $led=mysql_query("select a.ledger_id,a.ledger_name from accounts_ledger a, ledger_group b where b.group_class in ('Asset','Income','Expense') and a.ledger_group_id=b.group_id order by ledger_name");
      $under_ledger = '[';
	  while($ledg = mysql_fetch_row($led)){
          $under_ledger .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $under_ledger = substr($under_ledger, 0, -1);
      $under_ledger .= ']';
//echo $data;

?>
<script type="text/javascript">

$(document).ready(function(){
	
	$('#action').click(function() {
	  $.ajax({
		  url: 'common/check_entry.php',
		  data: "query_item="+$('#name').val()+"&pageid=account_sub_ledger",
		  success: function(data) {			
			alert(data);
		  }
		});
	});

    function formatItem(row) {
		//return row[0] + " " + row[1] + " ";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}

    var data = <?php echo $under_ledger; ?>;
    $("#under").autocomplete(data, {
		matchContains: true,
		minChars: 0,
		scroll: true,
		scrollHeight: 300,
        formatItem: function(row, i, max, term) {
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
            return row.name + " [" + row.id + "]";
		},
		formatResult: function(row) {
			return row.id;
		}
	});
  });
</script>
<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'account_sub_ledger.php?id='+theUrl;
}
</script>