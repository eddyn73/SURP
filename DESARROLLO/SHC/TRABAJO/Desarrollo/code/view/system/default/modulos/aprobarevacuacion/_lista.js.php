<script><?php f::jsStart();?>
$(document).ready(function()
{   
    $('.classButtonAprobar')
    .removeClass('classButtonAprobar')
    .css(
    {
         'padding':'0px'
        ,'margin':'0px'
        ,'width':'20px'
        ,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-check'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___aprobarevacuacion_aprobar(this);
    });
    
    $('.classButtonDesaprobado')
    .removeClass('classButtonDesaprobado')
    .css(
    {
         'padding':'0px'
        ,'margin':'0px'
        ,'width':'20px'
        ,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-close'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___aprobarevacuacion_desaprobar(this);
    });
    
    $('.classButtonVer')
    .removeClass('classButtonVer')
    .css(
    {
         'padding':'0px'
        ,'margin':'0px'
        ,'width':'20px'
        ,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-search'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___aprobarevacuacion_ver(this);
    });
}); 
<?php f::jsStop();?></script>