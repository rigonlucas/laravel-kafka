# Documentação

# Criar um tópico no kafka usando o Kafka CLI

Para criar um tópico no Apache Kafka usando o Kafka CLI, siga os passos abaixo:
1. Abra o terminal. 
```bash
docker exec -it broker bash
```

2. Crie o tópico usando o comando abaixo
```bash
kafka-topics --create --topic audit-v1 --bootstrap-server broker:29092 --partitions 3 --replication-factor 1
   ```
3. Liste os tópicos para verificar se o tópico foi criado com sucesso
```bash
kafka-topics --list --bootstrap-server broker:29092
```

4. Detalhes do tópico
```bash
kafka-topics --describe --topic audit-v1 --bootstrap-server broker:29092
```

5. Offset do consumidor
```bash
kafka-run-class kafka.tools.GetOffsetShell --broker-list broker:29092 --topic audit-v1
```

6. Configuração do zookeeper e broker
```bash
sudo rm -rf ./data/kafka ./data/zookeeper
sudo mkdir -p ./data/kafka ./data/zookeeper
sudo chmod -R 777 ./data
```
7. Validar se o host do broker está acessível via nc
```bash
nc -zv broker 9092
```
