<?php

	namespace modelos;

	require_once('./modelos/piloto.class.php');

	/**
	 * Modelo de uma volta
	 */
	class Volta
	{
		
		function __construct($volta)
		{
			$aux = array_map('trim', explode('–', $volta[1]));
			$this->hora					= $volta[0];
			$this->nome_piloto			= $aux[1];
			$this->id_piloto			= $aux[0];
			$this->n_volta				= $volta[2];
			$this->tempo_volta			= $this->texto_para_segundos($volta[3]);
			$this->vel_media			= floatval($volta[4]);
			$this->recorde				= PHP_INT_MAX;
		}

		function texto_para_segundos($texto)
		{
			$tempo = explode(':', $texto);
			if(sizeof($tempo) == 1) # caso o cara tenha dado a volta em menos de um minuto, então o tempo dele é do padrao 00.000
				return floatval($texto);
			else {
				return floatval($tempo[0]) * 60 + floatval($tempo[1]);
			}
		}

		function numero_pra_texto($numero)
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