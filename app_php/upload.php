<?php 
  require_once('./controladores/VoltasController.php');
  use \controladores\VoltasController;
  $erro = false;

try {
  $voltasController = new VoltasController($_FILES); #instanciação dos arquivos ( como se fosse acesso ao banco )
  $retorno = $voltasController->processaArquivo(); # endpoint chamado para retornar os dados
  $pilotos = $retorno['pilotos'];
  $melhorvolta = $retorno['melhorVolta'];
} catch (Exception $e) {
  $erro = true;
}

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
		<script class="jsbin" src="https://ajax.googleapis.com/ajax/repositorios\voltasRepository/jquery/1/jquery.min.js"></script>
    <div class="card">
      <div class="card-header">
        <a href="index.html" class="btn btn-primary btn-md active" role="button" aria-pressed="true">Voltar</a>
      </div>
      <div class="card-body">
        
      <?php if ($erro): ?>
        <div class="alert alert-danger" role="alert">
          O arquivo é inválido
        </div>
      <?php else: ?>
    		<div class="table-responsive">
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
              <tr <?= ($key == 0) ? 'class="table-success"' : '' ; ?>>
                <td><?= $key + 1; ?>º</td>
                <td><?= $value->id; ?></td>
                <td><?= $value->nome; ?></td>
                <td><?= $value->voltas; ?></td>
                <td><?= $value->tempo_total_em_string($value->tempo)?> </td>
                <td><?= $value->tempo_total_em_string($value->recorde) ?></td>
                <td><?= round($value->somaMedia / $value->voltas,2) ?></td>
                <td><?= $value->tempo_total_em_string($value->tempo - $pilotos[0]->tempo)?> </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>  
        </div>

    		<div class="alert alert-primary" role="alert">
    			A melhor volta é do piloto <?= $melhorvolta->nome ?> com <?= $melhorvolta->tempo_total_em_string($melhorvolta->recorde)?>
    		</div>
    <?php endif; ?>

      </div>

    </div>



		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/repositorios\voltasRepository/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="custom.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>