<?php if(false):?><script><?php endif;?>
 
callFunction.f___misevacuaciones_eliminar=function(objeto)
{
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
   
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__misevacuaciones'
    +'&p__i=e__controller'
    +'&p__function=e__eliminar'
    +'&p__typeResponse=e__json'
    +'&p__credencial='+$('#p__credencialMisEvacuaciones').val()
    +'&p__codEvacuacion='+p__codEvacuacion 
    )
    ,function(data)
    {
       callFunction.f__loadoff(overlaySelect,overlayTemp);
       if(callFunction.f__warning(data))return false;

       var p=jQuery.parseJSON(data);
       if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
       if(p.accion)
       {
           callFunction.f__div(p.data,p.tagdata,null);
       }
       callFunction.f__mensajeAjaxParseJson(p);
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};
<?php if(false):?></script><?php endif;?>