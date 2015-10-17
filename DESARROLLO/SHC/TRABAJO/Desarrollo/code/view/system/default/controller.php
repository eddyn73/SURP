<?php
require_once('../../../core/helper/f.php');
f::validaServidor();
f::importAllClass();
$oFrontController= new FrontController();
$oFrontController->decodeParametrosBase64();
$oFrontController->loadTemplateSystemLayout();