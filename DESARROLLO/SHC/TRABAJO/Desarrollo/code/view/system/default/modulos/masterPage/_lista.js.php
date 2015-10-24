<script><?php f::jsStart(); ?>
$(document).ready(function()
{ 
    var parametroTimeout=setTimeout(function () 
    {
        callFunction.f___fFormatearDivMasterPage();
        clearTimeout(parametroTimeout);
    }, 100);
    callFunction.f___fFormatearDivMasterPage();
    $(window).resize(function()
    {
        callFunction.f___fFormatearDivMasterPage();
    });
    
    //
    $('#buttonCerrarSesion') 
    .css(
    {
         'padding':'0px'
        ,'margin':'0px'
        ,'width':'20px'
        ,'height':'14px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-power'
        },
        text: false
    }) 
     .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___login_logoff();
    }); 
});
<?php f::jsStop(); ?></script>