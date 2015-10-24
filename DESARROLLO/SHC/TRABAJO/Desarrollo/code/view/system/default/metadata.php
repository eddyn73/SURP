<?php $type = getimagesize(c::get('icono'));?>
<base href="<?php echo f::getUrlApp();?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo c::get('title');?></title>
<meta name="keywords" content="<?php echo c::get('keyword');?>" />
<meta name="description" content="<?php echo c::get('descripcion');?>" />
<meta name="author" content="<?php echo c::get('autor');?>" />
<link rel="icon" href="<?php echo f::getUrlApp().c::get('icono');?>" type="<?php echo ($type['mime']);?>"/> 
<link rel="shortcut icon" href="<?php echo f::getUrlApp().c::get('icono');?>" type="<?php echo ($type['mime']);?>"/>