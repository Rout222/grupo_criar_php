<?php 

	namespace services;

	use modelos\modelos;
	
	use repositorios\VoltasRepository;
	use services\PilotosServices;
	use interfaces\services\VoltaServiceInterface;

	require_once('repositorios/VoltasRepository.php');
	require_once('repositorios/PilotosRepository.php');
	require_once('modelos/Volta.class.php');
	require_once('./interfaces/services/VoltaServiceInterface.php');
	


	class VoltasServices implements VoltaServiceInterface
	{
	
        public $pilotosService;    

		function __construct($arquivo)
		{
			$this->pilotosService = new PilotosServices();
			$this->repository = new VoltasRepository();
			$this->erro = false;
			$this->voltas = [];

			$tipo = $arquivo['file']['type']; # tipo do arquivo, se for .csv o delimitador deve ser um ';' , caso contrario deve ser uma tabulação.
			$delimitador = ($tipo = 'text/csv') ? ';' : '\t' ;

			// abre o arquivo de logs
			$arquivo = fopen($arquivo['file']['tmp_name'], 'r');

			$linha = 0;
			$i = 0;
			$validos = 0;

			try {
				 while ($linha = fgetcsv($arquivo, 0, $delimitador)) {
					 if ($i++ == 0) { # se a linha for a 0, monta o cabeçalho
						 $cabecalho = array_map('trim', $linha); # tira todos os espaços desnecessários
						 if(sizeof($cabecalho) != 5)
							 return false;
						 continue;
					 } 
					 if(sizeof($linha) == sizeof($cabecalho)){ # caso a linha tenha o mesmo tamanho que o cabecalho processa a linha
						$validos++;
						$this->voltas[] = $this->repository->addVolta($linha);
					 }

				 }
			} catch (Exception $e) {
				$this->erro = true;
			} 
			fclose($arquivo);
			if($validos == 0)
				$this->erro = true;
			$this->pilotosService->retornaPilotos($this->voltas);
		}

		public function getMelhorVolta()
		{
			return $this->repository->getMelhorVolta($this->pilotosService->getPilotosPorPosicao());
		}
	}






