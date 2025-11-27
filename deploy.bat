@echo off
REM Script de deploy - cria ZIP apenas com arquivos essenciais para produção
REM Uso: deploy.bat

setlocal enabledelayedexpansion

set "TIMESTAMP=%date:~-4%%date:~3,2%%date:~0,2%-%time:~0,2%%time:~3,2%%time:~6,2%"
set "TIMESTAMP=%TIMESTAMP: =0%"
set "ZIP_NAME=repaso-deploy-%TIMESTAMP%.zip"
set "TEMP_DIR=.deploy_temp"

echo 🚀 Criando arquivo de deploy...

REM Criar diretório temporário
if exist "%TEMP_DIR%" rmdir /s /q "%TEMP_DIR%"
mkdir "%TEMP_DIR%"

REM Copiar arquivos essenciais
echo 📋 Copiando arquivos essenciais...

if exist "repaso.html" (
    copy "repaso.html" "%TEMP_DIR%\" >nul
) else (
    echo ⚠️  repaso.html não encontrado
)

if exist "questoes.json" (
    copy "questoes.json" "%TEMP_DIR%\" >nul
) else (
    echo ⚠️  questoes.json não encontrado
)

if exist ".htaccess" (
    copy ".htaccess" "%TEMP_DIR%\" >nul
) else (
    echo ⚠️  .htaccess não encontrado (opcional)
)

REM Copiar pasta media completa
if exist "media" (
    echo 📦 Copiando pasta media...
    xcopy "media" "%TEMP_DIR%\media\" /E /I /Y >nul
) else (
    echo ⚠️  Pasta media não encontrada
)

REM Criar ZIP usando PowerShell
echo 📦 Criando arquivo ZIP...
powershell -Command "Compress-Archive -Path '%TEMP_DIR%\*' -DestinationPath '%ZIP_NAME%' -Force" >nul

REM Limpar diretório temporário
rmdir /s /q "%TEMP_DIR%"

echo.
echo ✅ Deploy concluído!
echo 📦 Arquivo criado: %ZIP_NAME%
echo.
echo 📊 Arquivos incluídos no ZIP:
echo    - repaso.html
echo    - questoes.json
echo    - .htaccess
echo    - media/ (pasta completa)
echo.
echo 🚫 Arquivos excluídos:
echo    - README.md
echo    - start_server.sh
echo    - start_server.bat
echo    - verificar_projeto.py
echo    - deploy.sh
echo    - deploy.bat
echo    - .gitignore
echo.
echo 💡 Próximos passos:
echo    1. Descompacte %ZIP_NAME% no servidor
echo    2. Certifique-se de que o servidor suporta .htaccess (Apache)

pause

