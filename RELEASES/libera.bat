@echo off
set /p proj="Ingrese acronimo del PROYECTO (PRJ):"
set /p cli="Ingrese acronimo del CLIENTE (CLI):"
set /p ver="Ingrese la version (VER):"

set fecha=%date:~-4%%date:~3,2%%date:~0,2%
set folder=_%proj%_LIBERACION#01
set folder_base= %proj%\%cli%\%ver%\%fecha%%folder%

mkdir %folder_base%
mkdir %folder_base%\Documentos
mkdir %folder_base%\PHP
mkdir %folder_base%\HTML
mkdir %folder_base%\Imagenes
mkdir %folder_base%\JS
mkdir %folder_base%\DBScripts


copy ..\Documentos\Formatos\formatoLiberacion.xlsx %folder_base%\%folder_base%.xlsx
@echo %filename%
goto :eof 

:usage
@echo Usage: %0 Proyecto