#!/usr/bin/env bash
set -e

echo "Criação de tópicos Kafka iniciada..."

create_topic() {
  local topic=$1
  local partitions=$2
  local replication=$3

  if docker exec broker kafka-topics --bootstrap-server broker:29092 --list | grep -q "^${topic}$"; then
    echo "Tópico '${topic}' já existe. Pulando criação."
  else
    echo "Criação do tópico '${topic}' (${partitions} partitions, RF=${replication})..."
    docker exec broker kafka-topics \
      --create \
      --topic "${topic}" \
      --bootstrap-server broker:29092 \
      --partitions "${partitions}" \
      --replication-factor "${replication}"
  fi
}

# Criações
create_topic "auth-login-v1" 2 1
create_topic "auth-login-v1-dlq" 1 1
create_topic "auth-login-v1-to-throw-error" 1 1
create_topic "auth-recovery-v1" 1 1
create_topic "auth-dead-letter-queue" 1 1
create_topic "unknow-topic" 1 1


echo "Criação de tópicos Kafka concluída."
