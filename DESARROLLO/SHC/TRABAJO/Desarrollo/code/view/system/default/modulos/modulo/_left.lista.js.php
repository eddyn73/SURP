<script><?php f::jsStart();?>
$(document).ready(function()
{
    callFunction.f__mouseOverOutClass('.classDivModulo','ui-state-hover');
    $('.classDivModulo').click(function() 
    {
        var p__idModulo=$(this).attr('p__idModulo');
        var p__persistente=$(this).attr('p__persistente');
        var p__titulo=$(this).html();
        var p__credencial=$('#p__credencialLeftModulo').val();

        $('.classDivModulo').removeClass('ui-state-highlight');
        $(this).addClass('ui-state-highlight'); 
        
        callFunction.f___Modulo_VerModulo(p__idModulo,p__persistente,p__credencial,p__titulo);
    });
});
<?php f::jsStop();?></script>