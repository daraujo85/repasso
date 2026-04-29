#!/bin/bash
# Inicia o ambiente usando Docker Compose
echo "🐳 Iniciando container Docker..."
docker-compose up -d
echo "🌐 Projeto rodando em: http://localhost:8080"
echo "💡 Para parar: docker-compose down"
