<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BL_MasterPage
 *
 * @author epalomino
 */
class BL_MasterPage extends BL
{ 
    function __construct()
    { 
        
    }

    public function iniciarSistema()
    { 
        if(f::isEmpty(v::getError()))
        {
            $this->validaCredencial();
        }
        
        if(!f::isEmpty(v::getError()))
        {
            v::validaErrorUL(true);
        }
        else
        { 
            $idUsuario=f::getSession('idUsuario');
            if(f::isEmpty($idUsuario))
            {
                c::getViewSystem('modulos/login/index.php');
            }
            else
            {
                c::getViewSystem('modulos/masterPage/index.php');
            }
            
        }
    } 
}