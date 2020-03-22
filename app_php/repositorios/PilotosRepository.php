<?php

	namespace REPOSITORIOS;
	USE MODELOS;
	require_once('./modelos/piloto.class.php');
	
	/**
	 * Repositorio do objeto voltas
	 */
	class PilotosRepository
	{
		public function __construct()
		{
			$this->pilotos = [];
		}

		public function addToList($piloto)
		{
			if(!isset($this->pilotos[$piloto->id]))
				$this->pilotos[$piloto->id] = $piloto;
			else
				throw new Exception("Piloto já existe na lista");
				
		}
		
		public function getList()
		{
			return $this->pilotos;
		}

		public function processaVolta($id_piloto, $volta)
		{
			$piloto = $this->getPiloto($id_piloto);
			$piloto->addVolta();
			$this->pilotos[$id_piloto]->recorde = ($this->pilotos[$id_piloto]->recorde > $volta->tempo_volta) ? $volta->tempo_volta : $this->pilotos[$id_piloto]->recorde;
			$this->pilotos[$id_piloto]->tempo				+= $volta->tempo_volta;
			$this->pilotos[$id_piloto]->soma_media			+= $volta->vel_media;
		}

		public function getPiloto($id_piloto){ # função pra simular get
			return $this->pilotos[$id_piloto];
		}

		public function savePiloto($piloto){ # função para fingir que é salvo.
			$this->pilotos[$piloto->id] = $piloto;
		}

		public function getPilotos(){
			return $this->pilotos;
		}

		public function getPilotosPorPosicao(){
			$aux = $this->pilotos;
			usort($aux, function ($a, $b) { // ordena o array pelo tempo total gasto, considerando se ele terminou a corrida.
				if (($a->voltas == 4 && $b->voltas == 4) ||  ($b->voltas == $a->voltas)) // caso os dois tenham terminado a corrida no mesmo round, compara o tempo gasto pelos 2
			    	return $a->tempo <=> $b->tempo;
			    else{ // caso os dois tenham terminados em voltas diferentes quem andou mais voltas é melhor do que quem andou menos volta.
			    	return $b->voltas <=> $a->voltas;
			    }
			});
			return $aux;
		}
	}

?>