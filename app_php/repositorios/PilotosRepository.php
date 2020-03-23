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

		public function addToList($id, $nome, $recorde)
		{
			$piloto = new modelos\Piloto($id, $nome, $recorde);

			if(!isset($this->pilotos[$piloto->id]))
				$this->pilotos[$piloto->id] = $piloto;
			else
				throw new Exception("Piloto já existe na lista");
				
		}
		
		public function getList()
		{
			return $this->pilotos;
		}

		public function processaVolta($idPiloto, $volta)
		{
			$piloto = $this->findPiloto($idPiloto);
			$piloto->addVolta();
			$this->pilotos[$idPiloto]->recorde = ($this->pilotos[$idPiloto]->recorde > $volta->tempoVolta) ? $volta->tempoVolta : $this->pilotos[$idPiloto]->recorde;
			$this->pilotos[$idPiloto]->tempo				+= $volta->tempoVolta;
			$this->pilotos[$idPiloto]->somaMedia			+= $volta->velocidadeMedia;
		}

		public function findPiloto($idPiloto){ # função pra simular get
			return (isset($this->pilotos[$idPiloto])) ? $this->pilotos[$idPiloto] : null ;
		}

		public function savePiloto($piloto){ # função para fingir que é salvo.
			$this->pilotos[$piloto->id] = $piloto;
		}

		public function getPilotos(){
			return $this->pilotos;
		}

		
	}

?>