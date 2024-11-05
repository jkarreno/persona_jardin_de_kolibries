<html>
	<head>
		<title>Jardín de kolibries</title>
		
		<link rel="stylesheet" href="font_awesome/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="estilos/estilos.css">
		
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maxmum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	</head>
	<body>

<?php
if($_POST["pass"] != '123456')
{
    ?>
    <div class="centrado_logo">
			<img src="https://jardindekolibries.com/wp-content/uploads/2021/08/logo-jardinkolibries-02.jpg" border="0">
	</div>
	<div class="centrado_index">
        <div class="user_pass" style="border:0;">
            <p style="display: block; text-align: center; color: #e4007d"> Lo sentimos, no tienes acceso a esta sección</p>
        </div>
	</div>
<?php
}
else{
    echo '<video width="100%" controls>
        <source src="https://jardindekolibries.com/videos/alberto_gayosso.mp4" type="video/mp4">
        </video>';
}
?>
	</body>
</html>

<?php
//Created with human intelligence by @jkarreno 2024
//May the force be with you
//move your stars
//always ready
?>