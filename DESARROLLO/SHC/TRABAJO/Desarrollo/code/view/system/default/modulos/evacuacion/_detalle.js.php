<script><?php f::jsStart();?>
$(document).ready(function()
{   
    callFunction.f__validaCaracteres('#p__codCIP','.p__codCIP',5,5);
    callFunction.f__validaCaracteres('#p__lugarOrigen','.p__lugarOrigen',145);
    callFunction.f__validaCaracteres('#p__lugarDestino','.p__lugarDestino',145);
    callFunction.f__validaCaracteres('#p__motivo','.p__motivo',500);
    callFunction.f__validaCaracteres('#p__observaciones','.p__observaciones',500);
     
    $( "#p__fechaInicio" ).datepicker(
    {
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
        dateFormat: "yy-mm-dd",
        selectOtherMonths: true,
        showOtherMonths: true,
        onSelect: function( selectedDate ) 
        {
            $( "#p__fechaInicio" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
}); 
<?php f::jsStop();?></script>