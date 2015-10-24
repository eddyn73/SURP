<script><?php f::jsStart();?>
$(document).ready(function()
{ 
    var parametroTimeout=setTimeout(function () 
    {
        callFunction.f___plantillasui_loadIframe();
        clearTimeout(parametroTimeout);
    }, 1000);
    var parametroTimeout=setTimeout(function () 
    {
        callFunction.f___plantillasui_loadIframe();
        clearTimeout(parametroTimeout);
    }, 100);
    
    callFunction.f__mouseOverOutClass('.classSelectUI','ui-state-hover');
    
    $('.classSelectUI').removeClass('classSelectUI').click(function()
    {
        $('#cssJquery').attr('href','<?php echo f::getUrlApp();?>css.php?<?php echo f::id('src')?>='+$(this).attr('p__ruta')); 
        var parametroTimeout=setTimeout(function () 
        {
            callFunction.f__paginadoCSS();
            clearTimeout(parametroTimeout);
        }, 100);
    });
});
<?php f::jsStop();?></script>