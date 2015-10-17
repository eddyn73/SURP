<?php
$scrip=array();
$css=array();

$pScript['type']='text/javascript';
$pScript['charset']='utf-8';

$pCss['rel']='stylesheet';
$pCss['type']='text/css';

#**************************************************************************************************/
#                                              GUI                                                */
#**************************************************************************************************/
$pScript['patch']='resource/plugin/jquery/js/jquery-1.10.2.js';$scrip[]=$pScript;

$pScript['patch']='resource/plugin/jquery/js/jquery-ui-1.10.2.custom.js';$scrip[]=$pScript;

$pCss['id']='cssJquery';
$pCss['href']=f::getPlantillaUI();
$css[]=$pCss;

$pCss['id']='cssAplicacion';
$pCss['href']=c::get('templateSystem').'css/default/css.css';
$css[]=$pCss;

$pCss['id']=null;

$pCss['href']=c::get('templateSystem').'css/default/ui.css';$css[]=$pCss;

#**************************************************************************************************/
#                                        timer                                                    */
#**************************************************************************************************/
$pScript['patch']='resource/plugin/timer/jquery.timer.js';$scrip[]=$pScript;

foreach($scrip as $row)
{ 
    echo '<script type="'.$row['type'].'" charset="'.$row['charset'].'" src="'.f::getUrlApp().'js.php?'.f::id('src').'='.f::encode($row['patch']).'"></script>'.PHP_EOL;
}

foreach($css as $row)
{
    echo '<link rel="'.$row['rel'].'" type="'.$row['type'].'" id="'.$row['id'].'" href="'.f::getUrlApp().'css.php?'.f::id('src').'='.f::encode($row['href']).'"/>'.PHP_EOL;
}