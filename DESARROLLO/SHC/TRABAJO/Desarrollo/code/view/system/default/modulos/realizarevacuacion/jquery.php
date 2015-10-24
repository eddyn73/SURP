<?php if(false):?><script><?php endif;?>
callFunction.v___realizarevacuacion_codPesonal=null;
callFunction.f___realizarevacuacion_preBuscarPersonal=function()
{
    $("#p__buscarPersonal").autocomplete(
    {
		search: function( event, ui )
		{
            $("#p__buscarPersonal").addClass('preloadCenter');
            $("#p__buscarPersonal").addClass('ui-state-error'); 
			callFunction.v___realizarevacuacion_codPesonal=null;
            
            $('#divResultadoRealizarEvacuacionCodigoCIP').html('&nbsp;'); 
            $('#divResultadoRealizarEvacuacionNombre').html('&nbsp;');
            $('#divResultadoRealizarEvacuacionLugarOrigen').html('&nbsp;');
            $('#divResultadoRealizarEvacuacionTipoSangre').html('&nbsp;');
            $('#divResultadoRealizarEvacuacionGrado').html('&nbsp;');
            $('#divResultadoRealizarEvacuacionEdad').html('&nbsp;');
            $('#divResultadoRealizarEvacuacionDNI').html('&nbsp;');
            
		},
		source: function(p__request, p__response) 
		{
			$.ajax(
			{
                type: "POST",
				url: callFunction.f__rutaModulo(),
				data: 
				{ 
                     'p__m':'e__realizarevacuacion'
                    ,'p__i':'e__controller'
                    ,'p__function':'e__preBuscarPersonal'
                    ,'p__typeResponse':'e__json'
                    ,'p__credencial':$('#p__credencialRealizarEvacuacion').val()
                    ,'p__buscar' : p__request.term
				},
				success: function(data) 
				{
                    $("#p__buscarPersonal").removeClass('preloadCenter');
                    if(callFunction.f__warning(data))return false;
                    var p=jQuery.parseJSON(data);
                    if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
                    if(p.accion) 
                    {
                        p__response(p.autocomplete);
                    }
                    else
                    { 
                        callFunction.f__mensajeAjaxParseJson(p);
                    } 
				}
			});
        }
		,minLength: 2
		,delay: 500
		,select: function (event, ui) 
		{ 
            if(ui.item.respuesta==1)
            { 
                $("#p__buscarPersonal").removeClass('ui-state-error'); 
                callFunction.v___realizarevacuacion_codPesonal=ui.item.codigo;
                //alert(callFunction.v___realizarevacuacion_codPesonal);
                $('#divResultadoRealizarEvacuacionCodigoCIP').html(ui.item.codCIP); 
                $('#divResultadoRealizarEvacuacionNombre').html(ui.item.nombres+' '+ui.item.apellidoPat+' '+ui.item.apellidoMat);
                $('#divResultadoRealizarEvacuacionLugarOrigen').html(ui.item.lugarOrigen);
                $('#divResultadoRealizarEvacuacionTipoSangre').html(ui.item.tipoSangre);
                $('#divResultadoRealizarEvacuacionGrado').html(ui.item.grado);
                $('#divResultadoRealizarEvacuacionEdad').html(ui.item.edad);
                $('#divResultadoRealizarEvacuacionDNI').html(ui.item.dni);

                $('#p__buscarDestino').focus();
            }
            else
            {
                callFunction.v___realizarevacuacion_codPesonal=null;
                $("#p__buscarPersonal").addClass('ui-state-error'); 
            }
        }
    });
};    

callFunction.v___realizarevacuacion_lugarDestino=null;
callFunction.f___realizarevacuacion_preBuscarLugarDestino=function()
{
    $("#p__buscarDestino").autocomplete(
    {
		search: function( event, ui )
		{
            $("#p__buscarDestino").addClass('preloadCenter');
			callFunction.v___realizarevacuacion_lugarDestino=null;
            
            $('#p__buscarDestino').addClass('ui-state-error');
		},
		source: function(p__request, p__response) 
		{
			$.ajax(
			{
                type: "POST",
				url: callFunction.f__rutaModulo(),
				data: 
				{ 
                     'p__m':'e__realizarevacuacion'
                    ,'p__i':'e__controller'
                    ,'p__function':'e__preBuscarLugarDestino'
                    ,'p__typeResponse':'e__json'
                    ,'p__credencial':$('#p__credencialRealizarEvacuacion').val()
                    ,'p__buscar' : p__request.term
				},
				success: function(data) 
				{
                    $("#p__buscarDestino").removeClass('preloadCenter');
                    if(callFunction.f__warning(data))return false;
                    var p=jQuery.parseJSON(data);
                    if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
                    if(p.accion) 
                    {
                        p__response(p.autocomplete);
                    }
                    else
                    { 
                        callFunction.f__mensajeAjaxParseJson(p);
                    } 
				}
			});
        }
		,minLength: 2
		,delay: 500
		,select: function (event, ui) 
		{ 
            
            if(ui.item.respuesta==1)
            { 
                callFunction.v___realizarevacuacion_lugarDestino=ui.item.codigo;
                $('#p__buscarDestino').removeClass('ui-state-error');
                $('#p__motivo').focus();
            }
            else
            { 
                callFunction.v___realizarevacuacion_lugarDestino=null;
                $('#p__buscarDestino').addClass('ui-state-error');
            }
            
        }
    });
};   

callFunction.v___realizarevacuacion_codPesonalAcompaniante=null;
callFunction.f___realizarevacuacion_preBuscarPersonalAcompaniante=function()
{
    $("#p__buscarPersonalAcompaniante").autocomplete(
    {
		search: function( event, ui )
		{
            $("#p__buscarPersonalAcompaniante").addClass('preloadCenter');
			callFunction.v___realizarevacuacion_codPesonalAcompaniante=null;
            
            $('#p__buscarPersonalAcompaniante').addClass('ui-state-error');
            
		},
		source: function(p__request, p__response) 
		{
			$.ajax(
			{
                type: "POST",
				url: callFunction.f__rutaModulo(),
				data: 
				{ 
                     'p__m':'e__realizarevacuacion'
                    ,'p__i':'e__controller'
                    ,'p__function':'e__preBuscarPersonalAcompaniante'
                    ,'p__typeResponse':'e__json'
                    ,'p__credencial':$('#p__credencialRealizarEvacuacion').val()
                    ,'p__buscar' : p__request.term
				},
				success: function(data) 
				{
                    $("#p__buscarPersonalAcompaniante").removeClass('preloadCenter');
                    if(callFunction.f__warning(data))return false;
                    var p=jQuery.parseJSON(data);
                    if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
                    if(p.accion) 
                    {
                        p__response(p.autocomplete);
                    }
                    else
                    { 
                        callFunction.f__mensajeAjaxParseJson(p);
                    } 
				}
			});
        }
		,minLength: 2
		,delay: 500
		,select: function (event, ui) 
		{  
			if(ui.item.respuesta==1)
            {
                callFunction.v___realizarevacuacion_codPesonalAcompaniante=ui.item.codigo;
                $('#p__buscarPersonalAcompaniante').removeClass('ui-state-error');
                $('#p__fechaInicio').focus().click();
            }
            else
            {
                callFunction.v___realizarevacuacion_codPesonalAcompaniante=null;
                $('#p__buscarPersonalAcompaniante').addClass('ui-state-error');
            } 
        }
    });
};


callFunction.f___realizarevacuacion_nuevo=function()
{
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
      
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__realizarevacuacion'
    +'&p__i=e__controller'
    +'&p__function=e__nuevo'
    +'&p__typeResponse=e__json'
    +'&p__credencial='+$('#p__credencialRealizarEvacuacion').val()
    
    
    
    +'&p__codPersonal='+callFunction.v___realizarevacuacion_codPesonal
    +'&p__lugarDestino='+callFunction.v___realizarevacuacion_lugarDestino
    +'&p__codPersonalAcompaniante='+callFunction.v___realizarevacuacion_codPesonalAcompaniante
    
    +'&p__medioEvacuacion='+$('#p__medioEvacuacion').val()
    +'&p__motivo='+$('#p__motivo').val()
    +'&p__fechaInicio='+$('#p__fechaInicio').val()
    +'&p__fechaFin='+$('#p__fechaFin').val()
    +'&p__observaciones='+$('#p__observaciones').val()
    
    )
    ,function(data)
    {
       callFunction.f__loadoff(overlaySelect,overlayTemp);
       if(callFunction.f__warning(data))return false;

       var p=jQuery.parseJSON(data);
       if(p.refrescar===true){callFunction.f__fRefrescar();return false;}/*valida llave 2*/
       if(p.accion)
       {
           callFunction.f___realizarevacuacion_reset(); 
       }
       callFunction.f__mensajeAjaxParseJson(p);
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
}; 

callFunction.f___realizarevacuacion_reset=function()
{ 
    $("#p__buscarPersonal").addClass('ui-state-error'); 
    callFunction.v___realizarevacuacion_codPesonal=null;

    $('#divResultadoRealizarEvacuacionCodigoCIP').html('&nbsp;'); 
    $('#divResultadoRealizarEvacuacionNombre').html('&nbsp;');
    $('#divResultadoRealizarEvacuacionLugarOrigen').html('&nbsp;');
    $('#divResultadoRealizarEvacuacionTipoSangre').html('&nbsp;');
    $('#divResultadoRealizarEvacuacionGrado').html('&nbsp;');
    $('#divResultadoRealizarEvacuacionEdad').html('&nbsp;');
    $('#divResultadoRealizarEvacuacionDNI').html('&nbsp;');
    
    callFunction.v___realizarevacuacion_lugarDestino=null;
    $('#p__buscarDestino').addClass('ui-state-error');

    callFunction.v___realizarevacuacion_codPesonalAcompaniante=null;
    $('#p__buscarPersonalAcompaniante').addClass('ui-state-error');
    
    $('#p__buscarPersonal').val('');
    $('#p__buscarDestino').val('');
    $('#p__motivo').val('');
    $('#p__medioEvacuacion').val('');
    $('#p__buscarPersonalAcompaniante').val('');
    $('#p__fechaInicio').val('');
    $('#p__fechaFin').val('');
    $('#p__observaciones').val('');
    
     callFunction.v__setTimeout=setTimeout(function () 
    {
        $('#p__buscarPersonal').focus();
        clearTimeout(callFunction.v__setTimeout);
    }, 100);
    
};
<?php if(false):?></script><?php endif;?>