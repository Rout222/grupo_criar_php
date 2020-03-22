<?php

	namespace controladores;
	USE modelos\MODELOS;
	use repositorios\VoltasRepository;
	require_once('./controladores/VoltasController.php');
	require_once('./repositorios/VoltasRepository.php');

	/**
	 * Repositorio do objeto voltas
	 */
	class VoltasController
	{

		public function __construct($arquivo)
		{

			$voltasRepository 	= new VoltasRepository($arquivo);
			$this->pilotos  	= $voltasRepository->pilotosRepository->getPilotosPorPosicao();
			$this->melhor_volta = $voltasRepository->get_melhor_volta();
		}

		public function processa_arquivo(){
			return [$this->pilotos, $this->melhor_volta];
		}

	}

?>