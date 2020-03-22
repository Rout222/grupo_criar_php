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

			$this->pilotoService = $this->service->pilotosService;
		}

		public function processaArquivo(){
			return ['melhorVolta' => $this->service->getMelhorVolta(), 'pilotos' => $this->pilotoService->retornaPilotosPorPosicao()];
		}

	}

?>