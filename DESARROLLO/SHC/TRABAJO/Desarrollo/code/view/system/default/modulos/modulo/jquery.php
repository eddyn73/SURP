<?php if(false):?><script><?php endif;?>
callFunction.f___Modulo_VerModulo=function(p__idModulo, p__persistente, p__credencial, p__titulo)
{  
    //if(p__titulo!==$('#divMasterPageCenterHeader').html())
    if(true)
    {
        var overlaySelect='#divMasterPageCenter';
        var overlayTemp = callFunction.f__loadon(overlaySelect);

        var overlaySelect2='#divMasterPageLeft';
        var overlayTemp2 = callFunction.f__loadon(overlaySelect2);

        $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
         '&p__m=e__modulo'
        +'&p__i=e__controller'
        +'&p__function=e__verModulo'
        +'&p__credencial='+p__credencial
        +'&p__idModulo='+p__idModulo
        )
        ,function(data)
        {
            callFunction.f__loadoff(overlaySelect,overlayTemp);
            callFunction.f__loadoff(overlaySelect2,overlayTemp2);

            if(callFunction.f__warning(data))return false;
            var p=jQuery.parseJSON(data);
            if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
            if(p.accion)
            { 
                $('#divMasterPageCenterHeader').html(p__titulo);
                callFunction.f__div(p.data,'#divMasterPageCenterContent',null);
            }
            else
            {
                callFunction.f__mensajeAjaxParseJson(p);
            } 
        }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
    } 
};
<?php if(false):?></script><?php endif;?>