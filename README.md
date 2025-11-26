# Repaso - simulados de espanhol

Este repositorio reune o arquivo HTML interativo 'repaso.html' e os dados das questoes 'questoes.json' usados para praticar conteudos basicos de espanhol.

## Inicialização

### Pre-requisitos
- Python 3 instalado e disponível no PATH.
- Navegador web moderno (Chrome, Firefox, Edge, etc.)

### Primeira execução
1. Clone ou baixe este repositório.
2. Certifique-se de que todos os arquivos estão presentes:
   - `repaso.html`
   - `questoes.json`
   - `start_server.bat` (Windows) ou `start_server.sh` (Linux/Mac)
3. (Opcional) Execute `python verificar_projeto.py` para validar a estrutura do projeto.
4. Execute o servidor (veja seção "Como iniciar" abaixo).

## Como iniciar

### Windows
1. Execute `start_server.bat` (duplo clique no arquivo).
2. Abra o navegador em http://localhost:8000/repaso.html.

### Linux/Mac
1. Abra o terminal na pasta do projeto.
2. Execute: `chmod +x start_server.sh && ./start_server.sh` (ou `python3 -m http.server 8000`).
3. Abra o navegador em http://localhost:8000/repaso.html.

O servidor simples do Python expoe todos os arquivos da pasta atual; mantenha apenas os artefatos necessarios neste diretorio quando estiver compartilhando o conteudo.

## Estrutura
- `repaso.html`: front-end que carrega as questões e aplica a lógica do simulado.
- `questoes.json`: banco de questões em formato JSON, organizado por simulados, grupos e perguntas.
- `start_server.bat`: script auxiliar para Windows que inicia o servidor HTTP local.
- `start_server.sh`: script auxiliar para Linux/Mac que inicia o servidor HTTP local.
- `verificar_projeto.py`: script de validação que verifica se o projeto está configurado corretamente.
- `.gitignore`: arquivo que define quais arquivos devem ser ignorados pelo Git.

## Desenvolvimento
- Ajuste ou amplie os simulados editando questoes.json, respeitando a estrutura existente.
- Atualizacoes na interface podem ser feitas em repaso.html; basta recarregar o navegador apos salvar.
- Perguntas podem trazer uma imagem opcional definindo os campos imagem (URL) e altImagem no questoes.json.
- Perguntas podem incluir audio adicionando o campo audio (URL) no questoes.json.
- Para parar o servidor HTTP, pressione Ctrl+C na janela em que ele foi iniciado.

## Próximos Passos
Consulte o arquivo `PROXIMOS_PASSOS.md` para uma lista detalhada de melhorias sugeridas e roadmap do projeto.
