# Documentação

# Documentação de serviços Kafka organização do consumo dos serviços.
1. Serviço core do Kafka:
- [ConsumerMessageHandler.php](app/Services/Kafka/Core/Consumer/ConsumerMessageHandler.php) - Contrato para manipulação e processamento das mensagens consumidas do contexto Kafka.
- [ConsumerService.php](app/Services/Kafka/Core/Consumer/ConsumerService.php) - Serviço genérico para consumo de mensagens do Kafka.
- [ProducerService.php](app/Services/Kafka/Core/Producer/ProducerService.php) - Serviço genérico para produção de mensagens no Kafka.
- [Messageable.php](app/Services/Kafka/Core/Message/Messageable.php) - Contrato para definição de mensagens Kafka. Onde as mensagens devem implementar esse contrato para o retorno do objeto mensagem.
- [DeadLetterProducerService.php](app/Services/Kafka/Core/DefaultDeadLetter/DeadLetterProducerService.php) - Serviço para produção de mensagens na Dead Letter Queue (DLQ) do Kafka. A DLQ é usada para armazenar mensagens que não puderam ser processadas com sucesso.

2. Definição de tópicos e consumer groups:
- [TopicsEnum.php](app/Services/Kafka/Enums/TopicsEnum.php) - Enumeração que define os tópicos Kafka utilizados na aplicação.
- [ConsumerGroupEnum.php](app/Services/Kafka/Enums/ConsumerGroupEnum.php) - Enumeração que define os grupos de consumidores Kafka utilizados na aplicação.

3. Serviços específicos de consumo e produção:
- [V1](app/Services/Kafka/Topics/AuditAuth/V1) - Diretório que contém os serviços específicos para o tópico de auditoria de autenticação (audit-login-v1 e audit-recovery-v1).
- [Consumers](app/Services/Kafka/Topics/AuditAuth/V1/Consumers) - Diretório que contém os consumidores específicos para o tópico de auditoria de autenticação.
- [Messages](app/Services/Kafka/Topics/AuditAuth/V1/Messages) - Diretório que contém as definições de mensagens específicas para o tópico de auditoria de autenticação. (Cada mensagem deve implementar o contrato Messageable e Arrayable).
- [GenericAuthProducer.php](app/Services/Kafka/Topics/AuditAuth/V1/Producers/GenericAuthProducer.php) - Produtor específico para o tópico de auditoria de autenticação. (Podendo ser genérico ou ter N produtores específicos).

# Criar um tópico no kafka usando o Kafka CLI

Para criar um tópico no Apache Kafka usando o Kafka CLI, siga os passos abaixo:
1. Abra o terminal. 
```bash
docker exec -it broker bash
```

2. Crie o tópico usando o comando abaixo
```bash
kafka-topics --create --topic audit-login-v1 --bootstrap-server broker:29092 --partitions 2 --replication-factor 1
kafka-topics --create --topic audit-recovery-v1 --bootstrap-server broker:29092 --partitions 1 --replication-factor 1
kafka-topics --create --topic dead-letter-queue --bootstrap-server broker:29092 --partitions 1 --replication-factor 1
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
sudo chown -R 1000:1000 ./data/kafka
sudo chown -R 1000:1000 ./data/zookeeper
```
7. Validar se o host do broker está acessível via nc
```bash
nc -zv broker 9092
```

8. Delete a topic
```bash
kafka-topics --delete --topic audit-v1 --bootstrap-server broker:29092
```

9. Rebuild do ambiente
```bash
docker compose down -v
sudo rm -rf ./data/kafka ./data/zookeeper
sudo mkdir -p ./data/kafka ./data/zookeeper
sudo chown -R 1000:1000 ./data
docker compose up -d
```
