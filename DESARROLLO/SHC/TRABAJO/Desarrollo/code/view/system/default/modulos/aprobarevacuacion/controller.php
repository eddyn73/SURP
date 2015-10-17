<?php
function nuevo()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->nuevo();
}
function preBuscarPersonal()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->preBuscarPersonal();
} 
function preBuscarLugarDestino()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->preBuscarLugarDestino();
} 

function preBuscarPersonalAcompaniante()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->preBuscarPersonalAcompaniante();
} 

function aprobar()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->aprobar();
}

function desaprobar()
{
    $oBL_Evacuacion=new BL_Evacuacion();
    $oBL_Evacuacion->desaprobar();
}