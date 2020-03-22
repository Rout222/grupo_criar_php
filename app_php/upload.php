<?php
	$arquivo = $_FILES;
	// var_dump($_FILES);

	echo $arquivo['file']['tmp_name'];
	$arquivo = fopen($arquivo['file']['tmp_name'], 'r');

	$linha = 0;

	while 


?>