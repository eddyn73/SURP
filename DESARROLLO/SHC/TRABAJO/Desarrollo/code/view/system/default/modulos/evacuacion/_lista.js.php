<script><?php f::jsStart();?>
$(document).ready(function()
{  
    $('.buttonNuevoEvacuacion')
    .removeClass('buttonNuevoEvacuacion')
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
           primary: 'ui-icon-circle-plus'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___evacuacion_nuevo();
    }); 
    
    $('.buttonEditarEvacucaion')
    .removeClass('buttonEditarEvacucaion')
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
           primary: 'ui-icon-pencil'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___evacuacion_editar(this);
    }); 
    
    $('.buttonEliminarEvacucaion')
    .removeClass('buttonEliminarEvacucaion')
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
           primary: 'ui-icon-trash'
        },
        text: false
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___evacuacion_eliminar(this);
    }); 
}); 
<?php f::jsStop();?></script>