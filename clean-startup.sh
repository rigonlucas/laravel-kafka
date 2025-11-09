#!/usr/bin/env bash
set -e

echo "
Limpando dados antigos do Kafka e ZooKeeper..."

KAFKA_DIR="./data/kafka"
ZOOKEEPER_DIR="./data/zookeeper"

echo "Parando containers Kafka e ZooKeeper..."
docker compose stop broker zookeeper >/dev/null 2>&1 || true

echo "Removendo diretórios antigos..."
sudo rm -rf "$KAFKA_DIR" "$ZOOKEEPER_DIR"

echo "Recriando diretórios..."
sudo mkdir -p "$KAFKA_DIR" "$ZOOKEEPER_DIR"
sudo chown -R 1000:1000 "$KAFKA_DIR" "$ZOOKEEPER_DIR"

echo "Limpeza concluída."

read -p "Deseja subir o ambiente Kafka novamente? (y/N): " resp
if [[ "$resp" =~ ^[Yy]$ ]]; then
  echo "Subindo containers Kafka e ZooKeeper..."
  docker compose up -d
else
  echo "Ambiente limpo, mas não iniciado."
fi
