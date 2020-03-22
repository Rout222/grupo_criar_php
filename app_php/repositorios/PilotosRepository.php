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

		
	}

?>