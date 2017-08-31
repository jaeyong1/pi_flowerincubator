<?php 
//Display Latest commands
include 'get_remote.php';
?>
<html>
	
<script language="javascript">
	function newCommand(strcommand) {
		console.log ("func start");	
		var response = confirm("¸í·É:" + strcommand );
		if (response) {
			//do yes task			
			document.forms["form1"].elements["strcmd"].value = strcommand;			
		  console.log('Command : ' + document.forms["form1"].elements["strcmd"].value);
			document.forms["form1"].method = "post";
			document.forms["form1"].action = "set_remote_cmd.php"
			document.forms["form1"].submit();
		}
	}
</script>
	
<body>
	<form name="form1">
	<input type="button" value="Lamp On" name="submitbtn1" OnClick="javascript:newCommand('Lamp On');">
	<br>
	<input type="button" value="Lamp Off" name="submitbtn1" OnClick="javascript:newCommand('Lamp Off');">
	<br>
	<input type="button" value="Fan On 10Min" name="submitbtn1" OnClick="javascript:newCommand('Fan On 10Min');">
	<br>
	<input type="button" value="Fan On" name="submitbtn1" OnClick="javascript:newCommand('Fan On');">
	<br>
	<input type="button" value="Fan OFF" name="submitbtn1" OnClick="javascript:newCommand('Fan OFF');">
	<br>
	<input type="hidden" name="strcmd">
  </form>
</body>


</html>