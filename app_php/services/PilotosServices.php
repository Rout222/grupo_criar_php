<?php

    namespace services;

    use repositorios\PilotosRepository;

    require_once('./repositorios/PilotosRepository.php');


    class PilotosServices
    {
        private $repository;

        public function __construct(){
            $this->repository = new PilotosRepository();
        }

        public function retornaPilotosPorPosicao()
        {
            return $this->repository->getPilotosPorPosicao();    
        }

        public function retornaPilotos($voltas)
        {
            
            foreach ($voltas as $volta) { // processa cada volta
                
				if (is_null($this->repository->getPiloto($volta->id_piloto))){ // caso não tenha inserido nenhuma vez o piloto, insere ele com valores zerados
					$this->repository->addToList($volta->id_piloto, $volta->nome_piloto, $volta->tempo_volta);	
					
				}

				// e depois processa os valores da volta
				$this->repository->processaVolta($volta->id_piloto, $volta);

            }
            
            return $this->getPilotosPorPosicao();
        }

        public function getPilotosPorPosicao(){
			$aux = $this->repository->getPilotos();
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
    