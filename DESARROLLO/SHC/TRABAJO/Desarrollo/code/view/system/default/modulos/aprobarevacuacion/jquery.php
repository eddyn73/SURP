<?php if(false):?><script><?php endif;?>
callFunction.f___aprobarevacuacion_ver=function(objeto)
{  
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
   
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__aprobarevacuacion'
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
			 title:'Ver Evacuación'
			,resizable: 'false'
			,modal: 'true'
			,autoOpen:'true'
			,width: '800'
			,height: 'auto'
			,position:'center'
			,show: { effect: 'drop', direction: 'up' ,duration:200}
			,hide: { effect: 'drop', direction: 'up' ,duration:200}
			,open: function() 
			{  
                $(divDialog).parent('.ui-dialog').attr('id',divDialogId); 
                callFunction.f__dialogTitle('div#'+divDialogId); 
				$('.ui-dialog-buttonpane').find('button:contains("Cerrar")').button({icons: {primary: 'ui-icon-close'},text: true});
			}
			,buttons:
			{
				Cerrar: function()
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
callFunction.f___aprobarevacuacion_aprobar=function(objeto)
{
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
   
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__aprobarevacuacion'
    +'&p__i=e__controller'
    +'&p__function=e__aprobar'
    +'&p__typeResponse=e__json'
    +'&p__credencial='+$('#p__credencialAprobarEvacuacion').val()
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
callFunction.f___aprobarevacuacion_desaprobar=function(objeto)
{
    var p__codEvacuacion= $(objeto).parent().parent().attr('p__codEvacuacion');
   
    var overlaySelect='#divMasterPageCenter';
    var overlayTemp = callFunction.f__loadon(overlaySelect);
    
    $.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__aprobarevacuacion'
    +'&p__i=e__controller'
    +'&p__function=e__desaprobar'
    +'&p__typeResponse=e__json'
    +'&p__credencial='+$('#p__credencialAprobarEvacuacion').val()
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