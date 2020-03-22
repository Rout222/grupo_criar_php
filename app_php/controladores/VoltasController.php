<?php

	namespace controladores;
	use services\VoltasServices;
	use services\PilotosServices;

	require_once('./services/VoltasServices.php');
	require_once('./services/PilotosServices.php');

	class VoltasController
	{
		private $service;
		
		public function __construct($arquivo)
		{
			$this->service = new VoltasServices($arquivo);
			$this->pilotoService = new PilotosServices();
		}

		public function processaArquivo(){
			var_dump($pilotoService->retornaPilotosPorPosicao());
			return ['melhorVolta' => $this->service->getMelhorVolta(), 'pilotos' => $pilotoService->retornaPilotosPorPosicao()];
		}

	}

?>