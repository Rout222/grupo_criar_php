<?php

	namespace REPOSITORIOS;
	USE MODELOS;
	require_once('./modelos/volta.class.php');
	require_once('./repositorios/PilotosRepository.php');
	
	/**
	 * Repositorio do objeto voltas
	 */
	class VoltasRepository
	{
		
		function __construct($arquivo)
			{
				$this->erro = false;
				$this->voltas = [];
				$this->instancia_do_piltosrepository = new PilotosRepository(); # apenas para não perder os dados, já que não estou usando banco de dados;

				$tipo = $arquivo['file']['type']; # tipo do arquivo, se for .csv o delimitador deve ser um ';' , caso contrario deve ser uma tabulação.
				$delimitador = ($tipo = 'text/csv') ? ';' : '\t' ;

				// abre o arquivo de logs
				$arquivo = fopen($arquivo['file']['tmp_name'], 'r');

				$linha = 0;
				$validos = 0;

				try {
				 	while ($linha = fgetcsv($arquivo, 0, $delimitador)) {
				 		if ($row++ == 0) { # se a linha for a 0, monta o cabeçalho
				 			$cabecalho = array_map('trim', $linha); # tira todos os espaços desnecessários
				 			if(sizeof($cabecalho) != 5)
				 				return false;
				 			continue;
				 		} 
				 		$volta = [];
				 		if(sizeof($linha) == sizeof($cabecalho)){ # caso a linha tenha o mesmo tamanho que o cabecalho processa a linha
				 			$validos++;
				 			$this->voltas[] = new MODELOS\Volta($linha);
				 		}

				 	}
				} catch (Exception $e) {
					$this->erro = true;
				} 
				fclose($arquivo);
				if($validos == 0)
					$this->erro = true;
				$this->processar_voltas();
			}

		private function processar_voltas()
		{

			$pilotosRepository = $this->instancia_do_piltosrepository;

			foreach ($this->voltas as $volta) { // processa cada volta
				if (is_null($pilotosRepository->getPiloto($volta->id_piloto))){ // caso não tenha inserido nenhuma vez o piloto, insere ele com valores zerados
					$piloto = new MODELOS\Piloto($volta->id_piloto, $volta->nome_piloto, $volta->tempo_volta);
					$pilotosRepository->addToList($piloto);	
					
				}

				// e depois processa os valores da volta
				$pilotosRepository->processaVolta($volta->id_piloto, $volta);

			}
		}

		public function get_melhor_volta()
		{
			$aux = $pilotosRepository->getPilotosPorPosicao();

			usort($aux, function ($a, $b) { // ordena o array pelo tempo total gasto, considerando se ele terminou a corrida.
			    return $a->recorde <=> $b->recorde;
			});

			return $aux[0];

		}
	}

?>