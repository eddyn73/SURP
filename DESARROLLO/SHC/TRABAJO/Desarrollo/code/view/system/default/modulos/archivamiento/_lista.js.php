<script><?php f::jsStart();?>
$(document).ready(function()
{   
    $('.classButtonArchivar')
    .removeClass('classButtonArchivar')
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
           primary: 'ui-icon-check'
        },
        text: true
    }) 
    .click(function(e) 
    {
        e.preventDefault();
        callFunction.f___archivamiento_archivar(this);
    }); 
}); 
<?php f::jsStop();?></script>