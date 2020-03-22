<?php

	namespace interfaces\services;

	interface PilotoServiceInterface
	{
			
		public function retornaPilotosPorPosicao();
		public function retornaPilotos($voltas);
		public function getPilotosPorPosicao();
	}