<?php 
	require_once('libs.php');

	$voltas 	= LIBS\processa_arquivo($_FILES);

	$pilotos 	= LIBS\processar_voltas($voltas);

	$melhorvolta = $pilotos;

	usort($melhorvolta, function ($a, $b) { // ordena o array pelo tempo total gasto, considerando se ele terminou a corrida.
		return $a['recorde'] <=> $b['recorde'];
	});

	$melhorvolta = $melhorvolta[0];
?>

	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Processar arquivo</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

		<!-- Custom styles for this template -->
		<link href="custom.css" rel="stylesheet">
	</head>

	<body>
		<script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


		<table class="table">
			<thead>
				<tr>
					<th scope="col">Posição</th>
					<th scope="col">Id</th>
					<th scope="col">Nome</th>
					<th scope="col">Voltas</th>
					<th scope="col">Tempo Total </th>
					<th scope="col">Melhor Volta </th>
					<th scope="col">Velocidade Média</th>
					<th scope="col">Chegou após o vencedor</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($pilotos as $key=>$value): ?>
					<tr>
						<td><?= $key + 1; ?>º</td>
						<td><?= $value['id']; ?></td>
						<td><?= $value['nome']; ?></td>
						<td><?= $value['voltas']; ?></td>
						<td><?= LIBS\numero_pra_texto($value['tempo'])?> </td>
						<td><?= LIBS\numero_pra_texto($value['recorde']) ?></td>
						<td><?= round($value['soma_media'] / $value['voltas'],2) ?></td>
						<td><?= LIBS\numero_pra_texto($value['tempo'] - $pilotos[0]['tempo'])?> </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="alert alert-primary" role="alert">
			A melhor volta é do piloto <?= $melhorvolta['nome'] ?> com <?= LIBS\numero_pra_texto($melhorvolta['recorde'])?>
		</div>
		<a href="index.html" class="btn btn-primary btn-md active float-md-right" role="button" aria-pressed="true">Voltar</a>



		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="custom.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
