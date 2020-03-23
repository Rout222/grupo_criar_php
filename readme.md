# Pré-requisitos

* Necessário ter instalado o Docker e o Docker-compose.
* Preferencia em uma máquina Linux.

# Começando

Com o projeto clonado, vá até a pasta do projeto e rode:
```
docker-compose up
```

Caso o docker-compose não esteja instalado como sudo para todos usuários, talvez seja necessário usar
```
sudo docker-compose up
```

Com isso, a imagem do docker será baixada, e será possível acessar o projeto via http://localhost


## Observações

Se existir algum outro processo utilizando a porta 80, é necessário alterar no docker-compose.yml a porta que o nginx está utilizando


## Arquivo de input

Como exemplo de input, dentro do projeto, já existe uma pasta chamada inputs, que existe o arquivo distribuido como .csv ou .log (separado por ; ou separado por tabulação)