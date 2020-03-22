<?php

	namespace LIBS;

	function processa_arquivo($arquivo)
	{

		$tipo = $arquivo['file']['type']; # tipo do arquivo, se for .csv o delimitador deve ser um ';' , caso contrario deve ser uma tabulação.

		// abre o arquivo de logs
		$arquivo = fopen($arquivo['file']['tmp_name'], 'r');

		$linha = 0;

		$delimitador = ($tipo = 'text/csv') ? ';' : '\t' ;


		while ($linha = fgetcsv($arquivo, 0, $delimitador)) {
			if ($row++ == 0) { # se a linha for a 0, monta o cabeçalho
				$cabecalho = array_map('trim', $linha); # tira todos os espaços desnecessários
				continue;
			} 
						
			$volta = [];
			// if(sizeof($line) == sizeof($cabecalho)){ # caso a linha tenha o mesmo tamanho que o cabecalho processa a linha
				foreach ($cabecalho as $chave => $coluna) {
					$volta[$coluna] = $linha[$chave];
				}

				$voltas[] = $volta;
			// }

		}
		fclose($arquivo);

		return $voltas;
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


	function processar_voltas($voltas)
	{
		$piloto_modelo = [];

		$pilotos = [];

		foreach ($voltas as $volta) { // processa cada volta
			$id = array_map('trim', explode('–', $volta['Piloto']));

			if(!isset($pilotos[$id[0]])){ // caso não tenha inserido nenhuma vez o piloto, insere ele com valores zerados
				$piloto_modelo['nome'] 			= $id[1];
				$piloto_modelo['id'] 			= $id[0];
				$piloto_modelo['voltas'] 		= 0;
				$piloto_modelo['tempo']			= 0;
				$piloto_modelo['soma_media']	= 0;
				$piloto_modelo['recorde']		= texto_para_segundos($volta['Tempo Volta']);

				$pilotos[$id[0]] = $piloto_modelo;
			}
			// e depois processa os valores da volta
			$pilotos[$id[0]]['voltas']++; 
			$pilotos[$id[0]]['recorde'] 			= ($pilotos[$id[0]]['recorde'] > texto_para_segundos($volta['Tempo Volta'])) ? texto_para_segundos($volta['Tempo Volta']) : $pilotos[$id[0]]['recorde'] ;
			$pilotos[$id[0]]['tempo']				+= texto_para_segundos($volta['Tempo Volta']);
			$pilotos[$id[0]]['soma_media']			+= floatval($volta['Velocidade média da volta']);

		}

		usort($pilotos, function ($a, $b) { // ordena o array pelo tempo total gasto, considerando se ele terminou a corrida.
			if (($a['voltas'] == 4 && $b['voltas'] == 4) ||  ($b['voltas'] == $a['voltas'])) // caso os dois tenham terminado a corrida no mesmo round, compara o tempo gasto pelos 2
		    	return $a['tempo'] <=> $b['tempo'];
		    else{ // caso os dois tenham terminados em voltas diferentes quem andou mais voltas é melhor do que quem andou menos volta.
		    	return $b['voltas'] <=> $a['voltas'];
		    }
		});

		return $pilotos;
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

?>