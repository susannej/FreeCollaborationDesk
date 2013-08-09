    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<?php
$confirm = " onclick=\"return confirm('Are you sure you want to delete?')\"";
$table_style_1 = "table table-striped table-bordered";
$table_style_2 = "table table-striped table-bordered table-nonfluid";
$table_style_3 = "table table-striped table-bordered table-nonfluid table-condensed";
?>
<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
});

$(function() {
$( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
</head>
<body>
<div id="wrap">
<!-- Begin page content -->
<div class="container">