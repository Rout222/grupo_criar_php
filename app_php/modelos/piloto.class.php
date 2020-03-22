<?php

	namespace MODELOS;

	/**
	 * Criação da classe piloto
	 */

	class Piloto
	{

		function __construct($id, $nome, $recorde)
		{
			$this->nome		 			= $nome;
			$this->id		 			= $id;
			$this->voltas		 		= 0;
			$this->tempo				= 0;
			$this->soma_media			= 0;
			$this->recorde				= $recorde;
		}

		public function addVolta()
		{
			$this->voltas++;
		}

		public function tempo_total_em_string($numero) # poderia criar uma extension method pra tempo, mas acho que seria overengineering
		{
			$minutos  = floor($numero / 60);
			$minutos = ($minutos < 10) ? "0" . $minutos : $minutos ;
			$segundos = floor($numero % 60);
			$segundos = ($segundos < 10) ? "0" . $segundos : $segundos ;
			$mili	  = floor(($numero - ($minutos * 60 + $segundos)) * 1000);
			$mili = ($mili < 10) ? "0" . $mili : $mili ;
			return $minutos . ":" . $segundos . "," . $mili;
		}
	}