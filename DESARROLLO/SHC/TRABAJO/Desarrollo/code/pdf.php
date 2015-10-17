<?php
require_once './core/helper/f.php';
f::importAllClass();
$oBL_ViewPDF=new BL_ViewPDF();
$oBL_ViewPDF->getPDF();