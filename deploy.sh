#!/bin/bash

# Script de deploy - cria ZIP apenas com arquivos essenciais para produção
# Uso: ./deploy.sh

ZIP_NAME="repaso-deploy-$(date +%Y%m%d-%H%M%S).zip"
TEMP_DIR=".deploy_temp"

echo "🚀 Criando arquivo de deploy..."

# Criar diretório temporário
mkdir -p "$TEMP_DIR"

# Copiar arquivos essenciais
echo "📋 Copiando arquivos essenciais..."

cp repaso.html "$TEMP_DIR/" 2>/dev/null || echo "⚠️  repaso.html não encontrado"
cp questoes.json "$TEMP_DIR/" 2>/dev/null || echo "⚠️  questoes.json não encontrado"
cp .htaccess "$TEMP_DIR/" 2>/dev/null || echo "⚠️  .htaccess não encontrado (opcional)"

# Copiar pasta media completa
if [ -d "media" ]; then
  echo "📦 Copiando pasta media..."
  cp -r media "$TEMP_DIR/"
else
  echo "⚠️  Pasta media não encontrada"
fi

# Criar ZIP
echo "📦 Criando arquivo ZIP..."
cd "$TEMP_DIR"
zip -r "../$ZIP_NAME" . -q
cd ..

# Limpar diretório temporário
rm -rf "$TEMP_DIR"

echo ""
echo "✅ Deploy concluído!"
echo "📦 Arquivo criado: $ZIP_NAME"
echo ""
echo "📊 Arquivos incluídos no ZIP:"
echo "   - repaso.html"
echo "   - questoes.json"
echo "   - .htaccess"
echo "   - media/ (pasta completa)"
echo ""
echo "🚫 Arquivos excluídos:"
echo "   - README.md"
echo "   - start_server.sh"
echo "   - start_server.bat"
echo "   - verificar_projeto.py"
echo "   - deploy.sh"
echo "   - deploy.bat"
echo "   - .gitignore"
echo ""
echo "💡 Próximos passos:"
echo "   1. Descompacte $ZIP_NAME no servidor"
echo "   2. Certifique-se de que o servidor suporta .htaccess (Apache)"

