@echo off
set SOURCE=awkirin
set DEST=%USERPROFILE%\bin\%SOURCE%

if not exist "%SOURCE%" (
    echo Файл %SOURCE% не найден
    pause
    exit /b 1
)

mkdir "%USERPROFILE%\bin" 2>nul

net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Запустите от Администратора
    pause
    exit /b 1
)

mklink "%DEST%" "%SOURCE%"
