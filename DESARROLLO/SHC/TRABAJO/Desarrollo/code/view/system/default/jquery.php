<?php if(false){?><script><?php } f::jsStart();?>
var callFunction={};    
callFunction.v__flagDialog1=false;
callFunction.v__flagDialog2=false;
callFunction.v__flagDialogNoClic=false;
callFunction.v__flagDialogNoClic=false;
callFunction.v__tituloPagina='';
callFunction.v__tiempotranscurrido=(new Date()).getTime();
callFunction.v__tiempodeespera=1000;
callFunction.v__rutaModulo='<?php echo base64_encode('controller.php');?>';
callFunction.v__tempTimeout;
callFunction.v__starstoptimerBodyGeneral;
callFunction.v__objetoDivOverlayBodyGeneral;
callFunction.v__objetoDivTimerBodyBodyGeneral;
callFunction.v__flagLoad=false;
callFunction.v__flagRefrescar=false;
callFunction.v__Base64KeyPublico='<?php echo f::llaveMaestra();?>';
callFunction.v__vistaNoClic=true;
callFunction.v__MesageSystem='#divMasterPageRightContent';

$(document).ready(function()
{
    callFunction.v__tituloPagina=$('title').html();
    if(callFunction.v__vistaNoClic)
    {
        $(document).bind('contextmenu', function(e) 
        {
            e.preventDefault();
            callFunction.f__noclic(callFunction.v__tituloPagina,'');
        });
    }
	callFunction.f__iniciarSistema();
});
callFunction.f__iniciarSistema=function()
{
	$.post(callFunction.f__rutaModulo(),callFunction.f__encriptar(
     '&p__m=e__masterPage'
    +'&p__i=e__controller'
    +'&p__function=e__iniciarSistema'
    +'&p__credencial=<?php echo f::encode(f::getCredencial());?>'
    ), function(data)
	{
		$('#divLoadingPage').hide("fade",{}, 200,function()
		{
			$('body').addClass('classBody',200);
			$('body').hide().html(data).show("fade",{}, 500,function()
			{
				callFunction.f__paginadoCSS();
				$('#divLoadingPage').remove();
			});
		});
	}).fail(function(p__r){callFunction.f__mFail(p__r);});
};
callFunction.f__paginadoCSS=function()
{
	$('.classPaginadoFooter').hover(
	function()
	{
		if(!$(this).hasClass('ui-state-disabled'))$(this).toggleClass('ui-state-hover');
	}
	,function()
	{
		if(!$(this).hasClass('ui-state-disabled'))$(this).toggleClass('ui-state-hover');
	});
	
	$('.classTablaUI tbody tr').hover(
	function()
	{
		$(this).addClass('ui-state-default').css('font-weight','normal');
	}
	,function()
	{
		$(this).removeClass('ui-state-default').css('font-weight','normal');
	});
	$('.classTablaUI tbody tr td, .classTablaUI thead tr th').css('border-color',callFunction.f__getAttrCSS('ui-widget-content','borderTopColor'));
    $('body').css('color',callFunction.f__getAttrCSS('ui-widget-content','color'));
	$('body').css('background-color',callFunction.f__getAttrCSS('ui-widget-content','backgroundColor'));
};
callFunction.f__getAttrCSS=function(fromClass,prop) 
{
    var inspector = $('<div>').css('display', 'none').addClass(fromClass);
    $('body').append(inspector);
	var propiedad=inspector.css(prop);
	inspector.remove();
	return propiedad;
};
callFunction.f__rutaModulo=function()
{ 
    return callFunction.f__Base64.f__decode(callFunction.v__rutaModulo);
};
callFunction.f__encriptar=function(p)
{ 
	var encriptartemp='l<?php echo f::encode('Base64ParametrosPublicos',false);?>=' 
    +callFunction.f__Base64.f__encode('l<?php echo f::encode('Base64KeyPublico',false);?>='+callFunction.v__Base64KeyPublico+p);
	return encriptartemp;
};
callFunction.f__noclic=function(p__titulo,p__texto)
{
	if(callFunction.v__flagDialogNoClic===false)
	{
		p__texto+='<div>Copyright &copy; Todos los derechos reservados'+
		'<br/><?php echo (f::p(ucwords(strftime("%d de %B del %Y"))));?></div>';
        
        var divDialogId ='id'+new Date().getTime();
		var divDialog = $("<div>").appendTo("body");
		$(divDialog).html(p__texto);
		$(divDialog).dialog(
		{
			title: p__titulo
			,resizable: false
			,modal: true			
            ,autoOpen:true
			,height: 'auto'
			,width:'400'
			,position:'center'
			,show: { effect: 'drop', direction: 'up' ,duration:200}
			,hide: { effect: 'drop', direction: 'up' ,duration:200}
            ,open: function()
			{
                $(divDialog).parent('.ui-dialog').attr('id',divDialogId);
                $('div#'+divDialogId).find('button:contains("Aceptar")').button({icons: {primary: 'ui-icon-circle-check'},text: true});
                callFunction.v__flagDialogNoClic=true;
                callFunction.f__dialogTitle('div#'+divDialogId);
			}
            ,close: function() 
            {
                $(this).dialog('close').remove();
                callFunction.v__flagDialogNoClic=false;
            }
            ,beforeClose: function() 
            {
                
            }
            ,buttons:
            {
                Aceptar: function()
                {
                    $(this).dialog('close');
                }
            }
		});
	}
};
callFunction.f__dialogTitle=function(div)
{
    var title=$(div).find('span.ui-dialog-title').html();   
    $(div).find('span.ui-dialog-title').html(title);
    $(div).find('div.ui-dialog-titlebar button').remove();
    var divTitleBar ='titlebar'+new Date().getTime();
    $(div).find('div.ui-dialog-titlebar').attr('id',divTitleBar);
    var divTitleBarHTML=$('div#'+divTitleBar).html();
    $('div#'+divTitleBar).html('<div>'+divTitleBarHTML+'</div>');
};
callFunction.f__mensajeFail=function(mensajeFail,mensajeFailTitle)
{
	if (typeof mensajeFail == 'undefined') mensajeFail='';
	if (typeof mensajeFailTitle == 'undefined') mensajeFailTitle='Error';
	callFunction.f__mensajeAjax('ui-state-error','ui-icon-alert','0',callFunction.v__MesageSystem,'up',mensajeFailTitle,mensajeFail);
    callFunction.f__deslizaInicioPantalla();
};
callFunction.f__mFail=function(p__response,p__overlaySelect,p__overlayTemp)
{
    if (typeof p__overlaySelect !== 'undefined') 
    {
        callFunction.f__loadoff(p__overlaySelect,p__overlayTemp);
    }
    
    if (typeof p__response !== 'undefined') 
    {
        callFunction.f__mensajeFail(p__response.responseText
        ,p__response.status+' '+p__response.statusText );
    }
};
callFunction.f__loadon=function(tagDiv)
{
	if (typeof tagDiv == 'undefined') 
	{
		if(callFunction.v__flagLoad===false)
		{
            try
            {
                $('button').button('disable');
            }
            catch(e)
            {
                //mensajeFail("No se pudo ejcutar <strong>$('button').button('disable');</strong>");
            }
			
			callFunction.v__flagLoad=true;
			var array = new Array();
			array=callFunction.f__fOverlay('body');
			callFunction.v__starstoptimerBodyGeneral=array[0];
			callFunction.v__objetoDivOverlayBodyGeneral=array[1];
			callFunction.v__objetoDivTimerBodyBodyGeneral=array[2];
			return true;
		}
		else
		{
            callFunction.f__mensajeFail('Un proceso se esta corriendo actualemte');
			return false;
		}
		
  	}
	else
	{
        try
        {
            $(tagDiv).find('button').button('disable');
        }
        catch(e)
        {
            //mensajeFail("No se pudo ejcutar <strong>$(tagDiv).find('button').button('disable');</strong>");
        }
		$(tagDiv).find('select').attr('disabled','disabled');
		return callFunction.f__fOverlay(tagDiv);
	}
};
callFunction.f__loadoff=function(tag,arreglo)
{
	if (typeof tag == 'undefined' || typeof arreglo == 'undefined') 
	{
        try
        {
            $('button').button('enable');
        }
        catch(e)
        {
            //mensajeFail("No se pudo ejcutar <strong>$('button').button('enable');</strong>");
        }
		callFunction.v__flagLoad=false;
		
		callFunction.v__starstoptimerBodyGeneral.stop().once();
		callFunction.v__objetoDivOverlayBodyGeneral.remove();
		callFunction.v__objetoDivTimerBodyBodyGeneral.remove();
  	}
	else
	{
        try
        {
            $(tag).find('button').button('enable');
        }
        catch(e)
        {
            //mensajeFail("No se pudo ejcutar <strong>$(tag).find('button').button('enable');</strong>");
        }
		$(tag).find('select').removeAttr('disabled');
		arreglo[0].stop().once();
		arreglo[1].remove();
		arreglo[2].remove();
	}
};
callFunction.f__fOverlay=function(objetoDiv)
{
	var objetoDivOverlay = $("<div>");
	var objetoDivTimerBody = $("<div>");
	
	$(objetoDiv).prepend(objetoDivTimerBody);
	$(objetoDiv).prepend(objetoDivOverlay);
	var objetoDivTimerLabel= 't'+new Date().getTime();
	
	var objetoDivHeight='';
	
	if(objetoDiv==='body')
	{ 
		$(objetoDivOverlay).css(
		{
			'position': 'fixed'
			,'top': '0'
			,'left': '0'
			,'width': '100%'
			,'height': '100%'
 			,'z-index':'101'
		});
		
		$(objetoDivTimerBody).css(
		{
			'width':'100px'
			,'height':'26px'
 			,'z-index':'101'
			,'position':'absolute'
			,'left':'50%'
			,'top':'50%'
			,'margin-left':'-50px'
			,'margin-top':'-13px'
		});
		if(callFunction.v__flagRefrescar)
		{
			$(objetoDivTimerBody).css(
			{
				'width':'250px'
				,'height':'50px'
				,'margin-left':'-125px'
				,'margin-top':'-25px'
			});
	 
		}
		objetoDivHeight='100';
		
	}
	else
	{
		callFunction.f__fOverlayGetCSS(objetoDiv,objetoDivOverlay);
		callFunction.f__fOverlayGetCSS(objetoDiv,objetoDivTimerBody);
		objetoDivHeight=$(objetoDiv).css('height');
	}
	
	$(objetoDivOverlay).addClass('ui-widget-overlay ui-front');
	
	var flagRefrescarTexto='<div class="ui-state-error">Seguridad Caducada <br/> La pagina se reiniciara en 5 segundos...</div>';
	var flagRefrescarWidth='90';
	
	if(callFunction.v__flagRefrescar)
	{
		flagRefrescarWidth='250'
	}
	else
	{
		flagRefrescarTexto='';
	}
	
	$(objetoDivTimerBody).html(''+
	'<div>'+
	'<table width="100%" height="'+objetoDivHeight+'" border="0" cellspacing="0" cellpadding="0">'+
	'  <tr>'+
	'	<td align="center" valign="middle">'+
	'		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all" style="width:'+flagRefrescarWidth+'px;padding:5px 5px 0px 5px;">'+flagRefrescarTexto+
	'			<div class="ui-dialog-title" id="'+objetoDivTimerLabel+'" style="overflow:hidden;width:100%;text-overflow:clip;"></div>'+
	'			<div class="ui-progressbar ui-widget ui-widget-content ui-corner-all ui-progressbar-indeterminate" style="height:2px;margin:0px;padding:0px;">'+
	'				<div class="ui-progressbar-value ui-widget-header ui-corner-left">'+
	'					<div class="ui-progressbar-overlay"></div>'+
	'				</div>'+
	'			</div>'+
	'		</div>'+
	'	</td>'+
	'  </tr>'+
	'</table>'+
	'</div>'+
	'');
	
	var starstoptimer ;
	var starstopcurrent=0;
	
	
	starstoptimer = $.timer(function() 
	{
		var min = parseInt(starstopcurrent/6000);
		var sec = parseInt(starstopcurrent/100)-(min*60);
		var micro = callFunction.f__pad(starstopcurrent-(sec*100)-(min*6000),2);
		var output="00";
		var output_hora="00";
		if(min>0)output=callFunction.f__pad(min,2);
		if(min>60)output_hora=callFunction.f__pad((min/60),2);
		$('#'+objetoDivTimerLabel).html(output_hora+':'+output+':'+callFunction.f__pad(sec,2)+'.'+micro);
		starstopcurrent+=7;
	},
	70,
	true);

	var array = new Array();
	array[0]=starstoptimer;
	array[1]=objetoDivOverlay;
	array[2]=objetoDivTimerBody;
	return array;
};
callFunction.f__fOverlayGetCSS=function(objetoDivInicial,objetoDivFinal)
{
	var objetoDivFinalWidth;
	//if($(objetoDivInicial).css('left')=='auto')objetoDivFinalWidth="99%";
	//else objetoDivFinalWidth=$(objetoDivInicial).css('width');
	objetoDivFinalWidth=$(objetoDivInicial).css('width');
	if(callFunction.f__existeString($(objetoDivInicial)[0].style.width, '%') )objetoDivFinalWidth=$(objetoDivInicial)[0].style.width;
	
	/*alert('width:'+$(objetoDivInicial).css('width')+'\n'
	+'left:'+$(objetoDivInicial).css('left')+'\n'
	+'style.width:'+$(objetoDivInicial)[0].style.width+'\n'
	
	);
	*/
	$(objetoDivFinal).css(
	{
		'position':'absolute'
		,'width':objetoDivFinalWidth
		,'height':$(objetoDivInicial).css('height')
		,'left':'auto'
		,'top':'auto'
		,'z-index':$(objetoDivInicial).css('z-index')
	});
};
callFunction.f__existeString=function(cadena, string) 
{ 
	var pos = 0;
	cadena += '';
	string += '';
	pos = cadena.indexOf( string );
	 
	if(cadena=='' || string=='')return false;
	else if ( pos == -1)return false;
	else return true;
};
callFunction.f__pad=function(number,length)
{
	var str=''+number;
	while(str.length < length){ str='0'+str; }
	return str;
};
callFunction.f__deslizaInicioPantalla=function()
{ 
    $('html, body').stop().animate(
    {
        scrollTop: $('body').offset().top  
    }, 1000);  
};
callFunction.f__borrarMensajeAjax=function(divMensajeAjax)
{
    $(divMensajeAjax).find('div.mensajeAjax').hide('blind', { direction: 'vertical' }, 500,function()
    {
        $(this).remove();
    });
};

callFunction.f__mensajeAjaxParseJson=function(parseJSON)
{
    callFunction.f__mensajeAjax(parseJSON.estilo
    ,parseJSON.icono
    ,parseJSON.segundos
    ,parseJSON.tag
    ,parseJSON.ubicacion
    ,parseJSON.respuesta
    ,parseJSON.descripcion
    ,parseJSON.cerrar);
};
callFunction.f__mensajeAjax=function(estilo,icono,tiempo,tag,lugar,mensajeStrong,mensajeLight,cerrar)
{
    callFunction.f__borrarMensajeAjax(tag);
    if (typeof cerrar === 'undefined') cerrar=true;
	/*
	ui-state-default  
	ui-state-disabled  
	ui-state-active 
	ui-state-hover 
	ui-state-error 
	ui-state-highlight
	
	ui-icon-alert
	ui-icon-circle-check
	ui-icon-info
	*/
	tiempo=tiempo*1000;
	var divMensajeAjax=$("<div>");
	if(lugar=='up')$(tag).prepend(divMensajeAjax);
	else $(divMensajeAjax).appendTo(tag);
	$(divMensajeAjax).css(
	{
		'display' : 'none',
		'margin' : '1px',
		'padding' : '5px',
		'font-size' : '14px'
	}).addClass(estilo).addClass('mensajeAjax');
	var boton_cerrar='';
    if(cerrar===true)
    {
        boton_cerrar='<span class="ui-icon ui-icon-close ui-helper-clearfix"'+
        'style="margin: -5px -5px 0px 4px;cursor: pointer;float: right;" title="Cerrar"></span>';
    }
	$(divMensajeAjax).html(boton_cerrar+
    '<span class="ui-icon '+icono+'" style="float: left; margin-right: .3em;"></span>'+
	'<strong>'+mensajeStrong+'</strong><br/>'+mensajeLight).addClass('ui-corner-all');
	
	$(divMensajeAjax).show('blind', { direction: 'vertical' }, 500);
	
	$(divMensajeAjax).find('span.ui-icon-close').click(function()
	{
		$(divMensajeAjax).hide('blind', { direction: 'vertical' }, 500,function(){$(this).remove();});
	});
	
	if(tiempo==0 || tiempo=="")
	{
		
	}
	else  
	{ 
		var parametroTimeout=setTimeout(function () 
		{
			$(divMensajeAjax).hide('blind', { direction: 'vertical' }, 500,function(){$(this).remove();});
			clearTimeout(parametroTimeout);
		}, tiempo);
	}
};
callFunction.f__fRefrescar=function()
{
	callFunction.v__flagRefrescar=true;
	callFunction.f__loadon();
	var parametroTimeout=setTimeout(function () 
	{
		document.location.reload(true);
		clearTimeout(parametroTimeout);
	}, 5000);
};
callFunction.f__div=function(data,destino,idFila)
{
	$(destino).hide("blind", { direction: "up" }, 250, function() 
	{
		$(destino).html(data).hide();
		callFunction.f__paginadoCSS();
		$(destino).show("blind", { direction: "up" }, 250, function()
		{ 
			if(idFila!==null)
			{
				$('tr#tr_'+idFila).addClass('ui-state-highlight',{duration:250});
			}
		});
	});
};
callFunction.f__warning=function(mensajeWarning)
{
	if($.trim(mensajeWarning)=='')
	{
		callFunction.f__mensajeAjax('ui-state-error','ui-icon-alert','60',callFunction.v__MesageSystem,'up','Error Interno','No hay mensaje de Retorno');
		return true;
	}
	try
	{
		jQuery.parseJSON(mensajeWarning);
		return false;
	}
	catch(e)
	{
		callFunction.f__mensajeAjax('ui-state-error','ui-icon-alert','60',callFunction.v__MesageSystem,'up','Error Interno',mensajeWarning.split(',"data":"')[0]);
		return true;
	}
};
callFunction.f__fValidaRefrescar=function(data)
{
	try
	{
		var pTemp=jQuery.parseJSON(data);
		if(pTemp.refrescar)
		{
			callFunction.f__fRefrescar();
			return true;
		}
		else
		{
			return false;
		}
	}
	catch(e)
	{
		return false;
	}
};
callFunction.f__pintarFilasParesImpares=function(tagFila)
{
	$(tagFila+" tbody tr:odd").addClass("odd"); // filas impares
    $(tagFila+" tbody tr:even").addClass("even"); // filas pares
};
callFunction.f__generarPassword=function(length, special) 
{
    var iteration = 0;
    var password = "";
    var randomNumber;
    if(special == undefined)
	{
        var special = false;
    }
    while(iteration < length)
	{
        randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
        if(!special){
            if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
            if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
            if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
            if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
        }
        iteration++;
        password += String.fromCharCode(randomNumber);
    }
    return password;
};
callFunction.f__validaCaracteres=function(input,output,total,maximo,estado)
{
    callFunction.f__validaCaracteresAux(input,output,total,maximo,estado);
    
    $(input).keyup(function() 
	{
		callFunction.f__validaCaracteresAux(input,output,total,maximo,estado);
	});
	
	$(input).keydown(function() 
	{
		callFunction.f__validaCaracteresAux(input,output,total,maximo,estado);
	});
};
callFunction.f__validaCaracteresAux=function(input,output,total,maximo,estado)
{
    if (typeof maximo === 'undefined') 
    {
        maximo=total+10;
    }
    if(maximo<total)
    {
        maximo=total;
    }
    
    if (typeof estado === 'undefined') 
    {
        estado=true;
    }
    
	var longitud = $(input).val().length;
	var resto = total - longitud;
    var mensaje=null;
    
    if(estado===true)
    {
        if(resto===total)
        {
            mensaje='Resta '+resto+' caracteres';
        }
        else if(resto===1)
        {
            mensaje='Resta '+resto+' caracter de '+ total;
        }
        else if(resto>0)
        {
            mensaje='Resta '+resto+' caracteres de '+ total;
        }
        else if(resto===0)
        {
            mensaje='Alcanzó el máximo de caracteres';
        }
        else if(resto===-1)
        {
            mensaje='<span class="ui-state-error">Se exedió por un caracter</span>';
        }
        else
        {
            mensaje='<span class="ui-state-error">Se exedió por '+(resto*-1)+' caracteres</span>';
        }
        //mensaje='<ul style="padding:0px 0px 0px 10px;margin:0px"><li style="padding:0px;margin:0px">'+mensaje+'</li></ul>'
    }
    else
    {
        mensaje=resto;
    }
	$(output).html(mensaje);
    $(input).attr("maxlength", maximo);
};
callFunction.f__mouseOverOutClass=function(div,clase)
{
    $(div)
    .mouseover(function() 
    {
        $(this).addClass(clase);
    })
    .mouseout(function() 
    {
        $(this).removeClass(clase);
    });
};
callFunction.f__valCheckBox=function(objeto)
{
    var aux=null;
    if($(objeto).is(':checked'))
    {
        aux=1;
    }
    else
    {
        aux=0;
    }
    return aux;
};
callFunction.f__Base64=(function()
{
    var _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

    var f__f_utf8_encode = function (string) {

        var utftext = "", c, n;

        string = string.replace(/\r\n/g,"\n");

        for (n = 0; n < string.length; n++) {

            c = string.charCodeAt(n);

            if (c < 128) {

                utftext += String.fromCharCode(c);

            } else if((c > 127) && (c < 2048)) {

                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);

            } else {

                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);

            }

        }

        return utftext;
    };

    var f__f_utf8_decode = function (utftext) {
        var string = "", i = 0, c = 0, c1 = 0, c2 = 0;

        while ( i < utftext.length ) {

            c = utftext.charCodeAt(i);

            if (c < 128) {

                string += String.fromCharCode(c);
                i++;

            } else if((c > 191) && (c < 224)) {

                c1 = utftext.charCodeAt(i+1);
                string += String.fromCharCode(((c & 31) << 6) | (c1 & 63));
                i += 2;

            } else {

                c1 = utftext.charCodeAt(i+1);
                c2 = utftext.charCodeAt(i+2);
                string += String.fromCharCode(((c & 15) << 12) | ((c1 & 63) << 6) | (c2 & 63));
                i += 3;

            }

        }

        return string;
    };

    var f__f_hexEncode = function(input) {
        var output = '', i;

        for(i = 0; i < input.length; i++) {
            output += input.charCodeAt(i).toString(16);
        }

        return output;
    };

    var f__f_hexDecode = function(input) {
        var output = '', i;

        if(input.length % 2 > 0) {
            input = '0' + input;
        }

        for(i = 0; i < input.length; i = i + 2) {
            output += String.fromCharCode(parseInt(input.charAt(i) + input.charAt(i + 1), 16));
        }

        return output;
    };

    var f__encode = function (input) {
        var output = "", chr1, chr2, chr3, enc1, enc2, enc3, enc4, i = 0;

        input = f__f_utf8_encode(input);

        while (i < input.length) {

            chr1 = input.charCodeAt(i++);
            chr2 = input.charCodeAt(i++);
            chr3 = input.charCodeAt(i++);

            enc1 = chr1 >> 2;
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
            enc4 = chr3 & 63;

            if (isNaN(chr2)) {
                enc3 = enc4 = 64;
            } else if (isNaN(chr3)) {
                enc4 = 64;
            }

            output += _keyStr.charAt(enc1);
            output += _keyStr.charAt(enc2);
            output += _keyStr.charAt(enc3);
            output += _keyStr.charAt(enc4);

        }

        return output;
    };

    var f__decode = function (input) {
        var output = "", chr1, chr2, chr3, enc1, enc2, enc3, enc4, i = 0;

        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        while (i < input.length) {

            enc1 = _keyStr.indexOf(input.charAt(i++));
            enc2 = _keyStr.indexOf(input.charAt(i++));
            enc3 = _keyStr.indexOf(input.charAt(i++));
            enc4 = _keyStr.indexOf(input.charAt(i++));

            chr1 = (enc1 << 2) | (enc2 >> 4);
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
            chr3 = ((enc3 & 3) << 6) | enc4;

            output += String.fromCharCode(chr1);

            if (enc3 !== 64) {
                output += String.fromCharCode(chr2);
            }
            if (enc4 !== 64) {
                output += String.fromCharCode(chr3);
            }

        }

        return f__f_utf8_decode(output);
    };

    var f__decodeToHex = function(input) {
        return f__f_hexEncode(f__decode(input));
    };

    var f__encodeFromHex = function(input) {
        return f__encode(f__f_hexDecode(input));
    };

    return {
        'f__encode': f__encode,
        'f__decode': f__decode,
        'f__decodeToHex': f__decodeToHex,
        'f__encodeFromHex': f__encodeFromHex
    };
}());
callFunction.f__dump=function(obj)
{
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
    return out;
};
jQuery(function($)
{
	$.datepicker.regional['es']= 
	{
		closeText: 'Cerrar',
		prevText: '&#x3c;Ant',
		nextText: 'Sig&#x3e;',
		currentText: 'Hoy',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
		'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
		'Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
});
(function($){
	$.eddyUpload=function(options)
	{
		var idUpload ='id'+new Date().getTime()+'0'+Math.floor((Math.random()*100)+1);                         
		var porDefecto =
		{
			 url:'upload.php'
			,nameFile:'nameFile'
			,tipo:'text'// html,text
			,titulo:'Upload'
			,data:{}
			,antes: function(archivo, extension){}
			,despues: function(archivo, response){}
		};
		if(options){$.extend(porDefecto, options);}
		
		function getArchivo(path)
		{
        	return path.replace(/.*(\/|\\)/, "");                   
		}
		
		function getExtension(archivo)
		{
			return (/[.]/.exec(archivo)) ? /[^.]+$/.exec(archivo.toLowerCase()) : '';
		}
		
		function ejecutar()
		{
			var iframeUpload=$('<iframe name="'+ idUpload +'Iframe"></iframe>').attr(
			{
				 id: idUpload+'Iframe'
				,src: 'about:blank'
			}).css('display','none');
			var formUpload=$('<form></form>').attr(
			{
				 'method':'POST'
				,'enctype':'multipart/form-data'
				,'action':porDefecto.url
				,'name':idUpload+'Form'
				,'target': idUpload+'Iframe'
				,'id':idUpload+'Form'
				//,'onsubmit':'return false;'
			}).css('display','nones');
			var inputFile=$('<input/>').attr(
			{
				 'type':'file'
				,'name':porDefecto.nameFile
				,'id':idUpload+'File'
			});
			inputFile.addClass('urp-input ')
            .addClass('urp-input-border');
 
			
			for (var key in porDefecto.data)
			{
				$(formUpload).append($('<input/>').attr(
				{
					 'type':'hidden'
					,'name':key
					,'value':porDefecto.data[key]
				}));
			} 
 
			var divDialogUpload = $('<div>').appendTo("body");
			
			$(formUpload).append(inputFile);
			$(divDialogUpload).append(formUpload);
			$(divDialogUpload).append(iframeUpload);
			
			$(divDialogUpload).dialog(
			{
				title: porDefecto.titulo,
				resizable: 'false',
				modal: 'true',
				autoOpen:'true',
				width: '290',
				height:'auto',
				position:'center',
				show: { effect: 'drop', direction: 'up' ,duration:200},
				hide: { effect: 'drop', direction: 'up' ,duration:200},
				buttons: 
				{
					Cancelar: function()
                    {
                        $(divDialogUpload).dialog('close');
                    }
				},
				open: function()
				{
					$(divDialogUpload).parent('.ui-dialog').attr('id',idUpload+'DivDialogUpload'); 
                    callFunction.f__dialogTitle('div#'+idUpload+'DivDialogUpload');
                    $('div#'+idUpload+'DivDialogUpload').find('button:contains("Cancelar")').button({icons: {primary: 'ui-icon-cancel'},text: true});
				},
				beforeClose: function(event, ui) 
				{
					jQuery('#<?php echo f::id('formulario');?>').validationEngine('hide');
				},
				close: function(ev, ui) 
				{
					iframeUpload.unbind('load');
					iframeUpload.remove();
					formUpload.remove();
					$(this).dialog('close').remove();
				}
			});
			inputFile.on('change',function()
			{
				var archivoTemp=inputFile.val();
				if(porDefecto.antes(getArchivo(archivoTemp), getExtension(getArchivo(archivoTemp.toLowerCase()))) == false )
				{
					iframeUpload.unbind('load');
					return false;                         
                }
				var overlayUploadSelect='div#'+idUpload+'DivDialogUpload';
				var overlayUploadTemp=loadon(overlayUploadSelect);
				
				iframeUpload.on('load',function()
				{
					loadoff(overlayUploadSelect,overlayUploadTemp);
					var data='';
					var fileNameTemp=inputFile.val();
					if(porDefecto.tipo=='text')data=$(this).contents().find('body').text();
					else if(porDefecto.tipo=='html')data=$(this).contents().find('html').text();
		 			iframeUpload.remove();
					formUpload.remove();
					$(divDialogUpload).dialog('close');
					porDefecto.despues(getArchivo(fileNameTemp),data);
				});
				formUpload.submit();
			});
		}
		ejecutar();
	};
})(jQuery); 
<?php
$ruta=dirname(__FILE__).'/modulos/';
$ruta_directorio = opendir($ruta);

while($ruta_archivo = readdir($ruta_directorio))
{
	if(is_dir($ruta.$ruta_archivo) and $ruta_archivo!='.' and $ruta_archivo!='..')
	if(file_exists($ruta.$ruta_archivo.'/jquery.php'))include_once($ruta.$ruta_archivo.'/jquery.php');
}
closedir($ruta_directorio); 
?>
<?php if(false){?></script><?php } f::jsStop();?>