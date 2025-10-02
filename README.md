# Repaso - simulados de espanhol

Este repositorio reune o arquivo HTML interativo 'repaso.html' e os dados das questoes 'questoes.json' usados para praticar conteudos basicos de espanhol.

## Pre-requisitos
- Python 3 instalado e disponivel no PATH.

## Como iniciar
1. Execute 'start_server.bat' (ou rode 'python -m http.server 8000').
2. Abra o navegador em http://localhost:8000/repaso.html.

O servidor simples do Python expoe todos os arquivos da pasta atual; mantenha apenas os artefatos necessarios neste diretorio quando estiver compartilhando o conteudo.

## Estrutura
- repaso.html: front-end que carrega as questoes e aplica a logica do simulado.
- questoes.json: banco de questoes em formato JSON, organizado por simulados, grupos e perguntas.
- start_server.bat: script auxiliar para subir rapidamente o servidor HTTP local.

## Desenvolvimento
- Ajuste ou amplie os simulados editando questoes.json, respeitando a estrutura existente.
- Atualizacoes na interface podem ser feitas em repaso.html; basta recarregar o navegador apos salvar.
- Para parar o servidor HTTP, pressione Ctrl+C na janela em que ele foi iniciado.
