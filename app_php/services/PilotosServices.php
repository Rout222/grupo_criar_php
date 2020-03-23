<?php

    namespace services;

    use repositorios\PilotosRepository;
    use interfaces\services\PilotoServiceInterface;

    require_once('./repositorios/PilotosRepository.php');
    require_once('./interfaces/services/PilotoServiceInterface.php');

    class PilotosServices implements PilotoServiceInterface
    {
        private $repository;

        public function __construct(){
            $this->repository = new PilotosRepository();
        }

        public function retornaPilotosPorPosicao()
        {
            return $this->getPilotosPorPosicao();    
        }

        public function retornaPilotos($voltas)
        {
            
            foreach ($voltas as $volta) { // processa cada volta
                
				if (is_null($this->repository->findPiloto($volta->idPiloto))){ // caso não tenha inserido nenhuma vez o piloto, insere ele com valores zerados
					$this->repository->addToList($volta->idPiloto, $volta->nomePiloto, $volta->tempoVolta);	
					
				}

				// e depois processa os valores da volta
				$this->repository->processaVolta($volta->idPiloto, $volta);

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
    