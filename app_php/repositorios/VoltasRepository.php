<?php

	namespace repositorios;
	use modelos;
	require_once('./modelos/Volta.class.php');
	require_once('./repositorios/PilotosRepository.php');
	
	/**
	 * Repositorio do objeto voltas
	 */
	class VoltasRepository
	{

		public function addVolta($linha){
			
			return  new modelos\Volta($linha);
		}


		public function get_melhor_volta($aux)
		{
			// consulta
			usort($aux, function ($a, $b) { // ordena o array pelo tempo total gasto, considerando se ele terminou a corrida.
			    return $a->recorde <=> $b->recorde;
			});

			return $aux[0];

		}
	}

?>