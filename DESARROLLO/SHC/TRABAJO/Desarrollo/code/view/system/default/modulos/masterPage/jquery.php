<?php if(false):?><script><?php endif;?>
callFunction.f___fFormatearDivMasterPage=function()
{   
    /**********************************************************************************************/
    /*                                   height: divMasterPage                                    */
    /**********************************************************************************************/
    var windowHeight=$(window).height();
    windowHeight=parseFloat(windowHeight,2).toFixed(0);
    
    var btw= parseInt(callFunction.f___fFormatearDivMasterPageGetCSSint('ui-widget-content','border-top-width'));
    var bbw= parseInt(callFunction.f___fFormatearDivMasterPageGetCSSint('ui-widget-content','border-bottom-width'));
    
    var margin=parseInt(5);
    var padding=parseInt(5);
    windowHeight=parseInt(windowHeight)-parseInt(margin+btw+padding)-parseInt(margin+bbw+padding);
    //$('#divMasterPage').css('height',windowHeight+'px');
    
    /**********************************************************************************************/
    /*    height: trMasterPageBody, divMasterPageLeft, divMasterPageCenter,divMasterPageRight     */
    /**********************************************************************************************/
    
    var header=$('#trMasterPageHeader').css('height');
    header=header.replace('px','');
    header=parseFloat(header,2).toFixed(0);
    
    var footer=$('#trMasterPageFooter').css('height');
    footer=footer.replace('px','');
    footer=parseFloat(footer,2).toFixed(0);
    
    var hBody=parseInt(windowHeight)-parseInt(header)-parseInt(footer)-5-5;
    $('#trMasterPageBody').css('height',hBody+'px');
    
    var hBodyDiv=parseInt(hBody)-parseInt(margin+btw+bbw+padding);
    $('#divMasterPageLeft').css('height',hBodyDiv+'px');
    $('#divMasterPageCenter').css('height',hBodyDiv+'px');
    $('#divMasterPageRight').css('height',hBodyDiv+'px');
    
    /**********************************************************************************************/
    /*                             valida height divMasterPage                                    */
    /**********************************************************************************************/
    
    var altura=$('#trMasterPageHeader').parent().css('height');
    altura.replace('px','');
    altura=parseFloat(altura,2).toFixed(0);
    altura=parseInt(altura)-1;
    $('#divMasterPage').css('height',altura+'px');

}; 

callFunction.f___fFormatearDivMasterPageGetCSSint=function(p__class,p__parameter)
{
    var intAttr=callFunction.f__getAttrCSS(p__class,p__parameter);
    intAttr=intAttr.replace('px','');
    intAttr=parseFloat(intAttr,2).toFixed(0);
    return intAttr;
};
<?php if(false):?></script><?php endif;?>