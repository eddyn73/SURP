ECHO OFF
IF %1.==. GOTO No1
IF %2.==. GOTO No2

REM * Crea arbol de directorios de liberacion **
set Fecha=%Date:~0,2%%Date:~3,2%%Date:~6,4%
set ruta=%2\%Fecha%-%1-Liberacion
rem echo %ruta%
MD %ruta%
cd %ruta%
MD Documentos
MD PHP
MD HTML
MD JS
MD Imagenes
MD DBScripts
ECHO ** LIBRERIA CREADA **
DIR
GOTO End1

:No1
  ECHO Debe ingresar las siglas del SISTEMA!
GOTO End1
:No2
  ECHO Debe ingresar la ruta destino!
GOTO End1

:End1