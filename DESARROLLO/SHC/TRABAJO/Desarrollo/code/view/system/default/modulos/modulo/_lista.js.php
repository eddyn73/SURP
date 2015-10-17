<script><?php f::jsStart();?>
$(document).ready(function()
{
    $('.classButtonAgregar')
    .removeClass('classButtonAgregar')
    .css(
    {
        // 'padding':'0px'
        //,'margin':'2px'
        //,'width':'20px'
        //,'height':'20px'
    })
    .button(
    {
        icons: 
        {
           primary: 'ui-icon-circle-plus'
        },
        text: true
    }) 
    .click(function(event) 
    {
        event.preventDefault();
        //f<?php echo f::id('fInsertItem');?>(this);
    }); 
}); 
<?php f::jsStop();?></script>