<html>
<head>
<title>Test</title>
</head>
<body>
	<div id="shower" align="center" style="font-size: 120pt;font-weight: bold;color:red;">0</div>
</body>
<script>
var count = 0;
var t = null;
inc_count();

function inc_count()
{
	if(count < 5){
		count++;
		var dv = document.getElementById('shower');
		var tx = document.getElementById('txshower');

		if(dv != null) dv.innerText = count;
		else tx.value = count;

		t = setTimeout(inc_count, 1000);
	}
	else{
		clearTimeout(t);
		location.href = "https://online.kisvn.vn";
	}
}
</script>
</html>
<?php
	// header("Location: https://online.kisvn.vn");
	// exit;
?>