<?php if(false):?><script><?php endif;?>
callFunction.f___evacuacion_nuevo=function()
{  
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__evacuacion'
    +'&p__i=e___detalle'
    )
    ,function(data)
    {
        callFunction.f__loadoff(overlaySelect,overlayTemp);      
        var divDialogId ='id'+new Date().getTime();
        var divDialog = $("<div>").appendTo("body");      
        $(divDialog).html(data);
		$(divDialog).dialog(
		{
			 title:'Evacución - Nuevo'
			,resizable: 'false'
			,modal: 'true'
			,autoOpen:'true'
			,width: '550'
			,height: 'auto'
			,position:'center'
			,show: { effect: 'drop', direction: 'up' ,duration:200}
			,hide: { effect: 'drop', direction: 'up' ,duration:200}
			,open: function() 
			{  
                $(divDialog).parent('.ui-dialog').attr('id',divDialogId); 
                callFunction.f__dialogTitle('div#'+divDialogId); 
				$('.ui-dialog-buttonpane').find('button:contains("Guardar")').button({icons: {primary: 'ui-icon-disk'},text: true});
				$('.ui-dialog-buttonpane').find('button:contains("Cancelar")').button({icons: {primary: 'ui-icon-cancel'},text: true});
			}
			,buttons:
			{
				Guardar: function()
				{
					
                    /*************************/
                    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
                     '&p__m=e__evacuacion'
                    +'&p__i=e__controller'
                    +'&p__function=e__nuevo'
                    +'&p__typeResponse=e__json'
                    +'&p__credencial='+$('#p__credencialEvacuacion').val()
                    +'&p__codCIP='+$('#p__codCIP').val()
                    +'&p__lugarOrigen='+$('#p__lugarOrigen').val()
                    +'&p__lugarDestino='+$('#p__lugarDestino').val()
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
                           $(divDialog).dialog('close');
                           callFunction.f__div(p.data,p.tagdata,null);
                       }
                       callFunction.f__mensajeAjaxParseJson(p);
                    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
                    /***************************/
                    
                    
				}
				,Cancelar: function()
				{
					$(divDialog).dialog('close');
				}
			}
            ,close: function(ev, ui) 
            { 
                $(this).dialog('close').remove();
                flagDialog1=false;
            }
			,beforeClose: function(event, ui) 
            {
                
            }
		});	 
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};

callFunction.f___evacuacion_editar=function(objeto)
{  
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
  
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__evacuacion'
    +'&p__i=e___detalle'
    +'&p__codEvacuacion='+p__codEvacuacion
    )
    ,function(data)
    {
        callFunction.f__loadoff(overlaySelect,overlayTemp);      
        var divDialogId ='id'+new Date().getTime();
        var divDialog = $("<div>").appendTo("body");      
        $(divDialog).html(data);
		$(divDialog).dialog(
		{
			 title:'Evacución - Editar'
			,resizable: 'false'
			,modal: 'true'
			,autoOpen:'true'
			,width: '550'
			,height: 'auto'
			,position:'center'
			,show: { effect: 'drop', direction: 'up' ,duration:200}
			,hide: { effect: 'drop', direction: 'up' ,duration:200}
			,open: function() 
			{  
                $(divDialog).parent('.ui-dialog').attr('id',divDialogId); 
                callFunction.f__dialogTitle('div#'+divDialogId); 
				$('.ui-dialog-buttonpane').find('button:contains("Guardar")').button({icons: {primary: 'ui-icon-disk'},text: true});
				$('.ui-dialog-buttonpane').find('button:contains("Cancelar")').button({icons: {primary: 'ui-icon-cancel'},text: true});
			}
			,buttons:
			{
				Guardar: function()
				{
					
                    /*************************/
                    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
                     '&p__m=e__evacuacion'
                    +'&p__i=e__controller'
                    +'&p__function=e__editar'
                    +'&p__typeResponse=e__json'
                    +'&p__credencial='+$('#p__credencialEvacuacion').val()
                    +'&p__codCIP='+$('#p__codCIP').val()
                    +'&p__lugarOrigen='+$('#p__lugarOrigen').val()
                    +'&p__lugarDestino='+$('#p__lugarDestino').val()
                    +'&p__motivo='+$('#p__motivo').val()
                    +'&p__fechaInicio='+$('#p__fechaInicio').val()
                    +'&p__fechaFin='+$('#p__fechaFin').val()
                    +'&p__observaciones='+$('#p__observaciones').val()
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
                           $(divDialog).dialog('close');
                           callFunction.f__div(p.data,p.tagdata,null);
                       }
                       callFunction.f__mensajeAjaxParseJson(p);
                    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
                    /***************************/
                    
                    
				}
				,Cancelar: function()
				{
					$(divDialog).dialog('close');
				}
			}
            ,close: function(ev, ui) 
            { 
                $(this).dialog('close').remove();
                flagDialog1=false;
            }
			,beforeClose: function(event, ui) 
            {
                
            }
		});	 
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};

callFunction.f___evacuacion_eliminar=function(objeto)
{  
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
  
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__evacuacion'
    +'&p__i=e___eliminar'
    +'&p__codEvacuacion='+p__codEvacuacion
    )
    ,function(data)
    {
        callFunction.f__loadoff(overlaySelect,overlayTemp);      
        var divDialogId ='id'+new Date().getTime();
        var divDialog = $("<div>").appendTo("body");      
        $(divDialog).html(data);
		$(divDialog).dialog(
		{
			 title:'Evacución - Eliminar'
			,resizable: 'false'
			,modal: 'true'
			,autoOpen:'true'
			,width: '550'
			,height: 'auto'
			,position:'center'
			,show: { effect: 'drop', direction: 'up' ,duration:200}
			,hide: { effect: 'drop', direction: 'up' ,duration:200}
			,open: function() 
			{  
                $(divDialog).parent('.ui-dialog').attr('id',divDialogId); 
                callFunction.f__dialogTitle('div#'+divDialogId); 
				$('.ui-dialog-buttonpane').find('button:contains("Aceptar")').button({icons: {primary: 'ui-icon-disk'},text: true});
				$('.ui-dialog-buttonpane').find('button:contains("Cancelar")').button({icons: {primary: 'ui-icon-cancel'},text: true});
			}
			,buttons:
			{
				Aceptar: function()
				{
					
                    /*************************/
                    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
                     '&p__m=e__evacuacion'
                    +'&p__i=e__controller'
                    +'&p__function=e__eliminar'
                    +'&p__typeResponse=e__json'
                    +'&p__credencial='+$('#p__credencialEvacuacion').val()
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
                           $(divDialog).dialog('close');
                           callFunction.f__div(p.data,p.tagdata,null);
                       }
                       callFunction.f__mensajeAjaxParseJson(p);
                    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
                    /***************************/
                    
                    
				}
				,Cancelar: function()
				{
					$(divDialog).dialog('close');
				}
			}
            ,close: function(ev, ui) 
            { 
                $(this).dialog('close').remove();
                flagDialog1=false;
            }
			,beforeClose: function(event, ui) 
            {
                
            }
		});	 
    }).fail(function(p__r){callFunction.f__mFail(p__r,overlaySelect,overlayTemp);});
};
<?php if(false):?></script><?php endif;?>