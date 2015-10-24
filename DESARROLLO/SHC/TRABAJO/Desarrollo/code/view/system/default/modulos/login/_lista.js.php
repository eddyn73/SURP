<script><?php f::jsStart();?>
$(document).ready(function()
{
    callFunction.f__validaCaracteres('#p__usuario','.p__usuario',15);
    callFunction.f__validaCaracteres('#p__clave','.p__clave',15);
    callFunction.f__validaCaracteres('#p__captcha','.p__captcha',9,9);
    
    $('.buttonAceptar')
    .removeClass('buttonAceptar')
    .css(
    {
         //'padding':'0px'
        //,'margin':'2px'
        //,'width':'37px'
        //,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-check'
        },
        text: true
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___fLogin();
    }); 
    
    $('.buttonRefresh')
    .removeClass('buttonRefresh')
    .css(
    {
        // 'padding':'0px'
        //,'margin':'0px'
        //,'width':'37px'
        //,'height':'20px'
    })
    .button(
    {
        icons: 
        {
                primary: 'ui-icon-refresh'
        }
        ,text: true
    }).click(function() 
    {
         callFunction.f___fCambiarCaptcha();
    });
    
    var tempTimeout=setTimeout(function () 
    {
        $('#p__usuario').focus();
        callFunction.f___fCambiarCaptcha();
        clearTimeout(tempTimeout);
    }, 400);
	
    $('#p__usuario').keypress(function(e) 
    {
        if(e.which === 13)
        {
            $("#p__clave").focus();
        }
    });
	
    $('#p__clave').keypress(function(e) 
    {
        if(e.which === 13)
        {
            $("#p__captcha").focus();
        }
    });
    
    $('#p__captcha').keypress(function(e) 
    {
        if(e.which === 13)
        {
            $('.divLogin').find('button:contains("Aceptar")').click();
        }
    });
    
    //callFunction.f___login_cargarFormulario();
}); 
<?php f::jsStop();?></script>