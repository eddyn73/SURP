<?php if(false):?><script><?php endif;?>
callFunction.f___fLogin=function()
{
    var overlaySelect='body';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__login'
    +'&p__i=e__controller'
    +'&p__function=e__login'
    +'&p__typeResponse=e__json'
    +'&p__credencial='+$('#p__credencial').val()
    +'&p__captcha='+$('#p__captcha').val()
    +'&p__usuario='+$('#p__usuario').val()
    +'&p__clave='+$('#p__clave').val()
    )
    ,function(data)
    {
        callFunction.f__loadoff(overlaySelect,overlayTemp);
        if(callFunction.f__warning(data))return false;
        var p=jQuery.parseJSON(data);
        if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
        if(p.accion)
        {
            callFunction.f__div(p.descripcion,p.tag,null);
        }
        else
        {
            callFunction.f___fCambiarCaptcha();
            $('#p__captcha').val('').focus(); 
            callFunction.f__mensajeAjaxParseJson(p);	
        }
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};

callFunction.f___fCambiarCaptcha=function()
{
    $('#p__imagenCapcha').attr('src','<?php f::getUrlApp()?>captcha.php?t='+new Date().getTime());
};

callFunction.f___login_logoff=function()
{
    var overlaySelect='body';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__login'
    +'&p__i=e__controller'
    +'&p__function=e__logoff'
    +'&p__typeResponse=e__json'
    )
    ,function(data)
    {
        callFunction.f__loadoff(overlaySelect,overlayTemp);
        if(callFunction.f__warning(data))return false;
        var p=jQuery.parseJSON(data);
        if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
        if(p.accion)
        {
            callFunction.f__div(p.descripcion,p.tag,null);
        }
        else
        {
            callFunction.f___fCambiarCaptcha();
            $('#p__captcha').val('').focus(); 
            callFunction.f__mensajeAjaxParseJson(p);	
        }
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};
<?php if(false):?></script><?php endif;?>