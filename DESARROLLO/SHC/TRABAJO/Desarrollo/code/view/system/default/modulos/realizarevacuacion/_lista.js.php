<script><?php f::jsStart();?>
$(document).ready(function()
{   
    callFunction.v___realizarevacuacion_codPesonal=null;
    callFunction.v___realizarevacuacion_lugarDestino=null;
    callFunction.v___realizarevacuacion_codPesonalAcompaniante=null;
    
    callFunction.v__setTimeout=setTimeout(function () 
    {
        $('#p__buscarPersonal').focus();
        clearTimeout(callFunction.v__setTimeout);
    }, 500);
    
    callFunction.f___realizarevacuacion_preBuscarPersonal();
    callFunction.f___realizarevacuacion_preBuscarLugarDestino();
    callFunction.f___realizarevacuacion_preBuscarPersonalAcompaniante();
    
    callFunction.f__validaCaracteres('#p__observaciones','.p__observaciones',500);
     
    $( "#p__fechaInicio" ).datepicker(
    {
        minDate: -0,
        dateFormat: "yy-mm-dd",
        selectOtherMonths: true,
        showOtherMonths: true,
        onSelect: function( selectedDate ) 
        {
            $( "#p__fechaFin" ).datepicker( "option", "minDate", selectedDate );
        }
    });

    $( "#p__fechaFin" ).datepicker(
    {
        minDate: -0,
        dateFormat: "yy-mm-dd",
        selectOtherMonths: true,
        showOtherMonths: true,
        onSelect: function( selectedDate ) 
        {
            $( "#p__fechaInicio" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
    
    $('#buttonRealizarEvacuacionGuardar') 
    .css(
    {
         'padding':'0px'
        ,'margin':'0px'
        //,'width':'20px'
        //,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-disk'
        },
        text: true
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___realizarevacuacion_nuevo();
    });
}); 
<?php f::jsStop();?></script>