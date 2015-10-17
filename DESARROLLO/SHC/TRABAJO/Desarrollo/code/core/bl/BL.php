<?php
/**
 * Description of BL
 * 
 * @author epalomino
 */
class BL
{
    protected function configurarIntentos()
    {
        if(f::isEmpty(f::getSession('intentoLimite')))
        {
            f::setSession('intentoLimite','10');
        }
        
        if(f::isEmpty(f::getSession('intentoActual')))
        {
            $this->resetearIntentoActual();
        }
        
        if(f::isEmpty(f::getSession('tiempoLimite')))
        {
            f::setSession('tiempoLimite','10');//en minutos
        }
        
        if(f::isEmpty(f::getSession('tiempoActual')))
        {
            f::setSession('tiempoActual','0');
        }
    }
    
    protected function resetearIntentoActual()
    {
        f::setSession('intentoActual','0');
    } 
    
    protected function aumentaIntento()
    {
        $this->configurarIntentos();
        $resta=f::getSession('intentoLimite')-f::getSession('intentoActual');
        if($resta>0)
        {
            f::setSession('intentoActual',f::getSession('intentoActual')+1);
            $resta=f::getSession('intentoLimite')-f::getSession('intentoActual');
            if($resta>0)
            {
                if($resta==1)
                {
                    $plural='';
                    $resta='un';
                }
                else
                {
                    $plural='s';
                }
                $resta='<strong>'.$resta.'</strong>';
                v::setError('Le resta '.$resta.' intento'.$plural);
                
            }
            f::setSession('tiempoActual',  time());
            $this->validaIntento();
        }
        
    }
    protected function validaIntento()
    {
        $this->configurarIntentos();
        $resta=f::getSession('intentoLimite')-f::getSession('intentoActual');
        
        if($resta<=0)
        {
            $resta=time()-f::getSession('tiempoActual');
            
            if($resta>=(f::getSession('tiempoLimite')*60))
            {
                f::setSession('intentoActual','0');
            }
            else
            {
                v::setError('Exedió el máximo de intentos');
                v::setError('Vuelva a intentar dentro de '.date('00:i:s',(f::getSession('tiempoLimite')*60)-$resta).' minutos');
            }
        }
    }
    
    protected function validaCredencial()
    {
        $credencial=f::request('post', 'decode', f::id('credencial'));
        if($credencial!=f::getCredencial())
        {
            v::setError('La credencial caducó, vuelva a cargar la aplicación');
        }
    }
    
    protected function validaCaptcha()
    {
        $captcha=f::request('post', 'normal', f::id('captcha'));
        if(str_replace(' ', '', strtolower($captcha))!=  str_replace(' ', '', strtolower(f::getSession('captcha'))))
        {
            v::setError('El código de la imágen no es válido.');
        }
        else
        {
            f::setSession('captcha',  Cifrar::random(10));
        }
    }
    
    protected function getPaginadoFilas($modulo=null)
    {
        $filas=f::getSession('paginado.filas.'.$modulo);
        if(f::isEmpty($filas))
        {
            $filas=10;
        }
        return $filas;
    }
    
    protected  function setPaginadoFilas($value, $modulo=null)
    {
        f::setSession('paginado.filas.'.$modulo,$value);
    }
    
    protected function getPaginadoPagina($modulo=null)
    {
        $pagina=f::getSession('paginado.pagina.'.$modulo);
        if(f::isEmpty($pagina))
        {
            $pagina=1;
        }
        return $pagina;
    }
    
    protected function setPaginadoPagina($value, $modulo=null)
    {
        f::setSession('paginado.pagina.'.$modulo,$value);
    }
    
    protected function mostrarPaginado($onclick, $total, $pagina, $filas)
    {
        $return=null;
        $p['total_paginas']=ceil($total / $filas);
        $p['mostrarPaginas']=5;

        $p['inicio']=$pagina - floor($p['mostrarPaginas'] / 2);
        $p['fin']=$pagina + floor($p['mostrarPaginas'] / 2);

        if($p['inicio'] < 1)
        {
            $p['inicio']=1;
            $p['fin']=$p['inicio'] + $p['mostrarPaginas'];
        }
        if($p['fin'] > $p['total_paginas'])
        {
            $p['fin']=$p['total_paginas'];
            $p['inicio']=$p['fin'] - $p['mostrarPaginas'];
        }
        if($p['inicio'] < 1)
        {
            $p['inicio']=1;
        }
        $maximo_mostrar=$pagina * $filas;
        if($maximo_mostrar > $total)
            $maximo_mostrar=$total;
        $return.= '
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle">
                <span class="classPaginadoFooter ui-corner-tr ui-corner-bl ui-corner-br ui-state-disabled" style="opacity:1">
                    Del '.(($pagina - 1) * $filas + 1)." al ".$maximo_mostrar." de {$total}".' Registros
                </span>
            </td>
            <td align="right" valign="middle">
        ';


        if($p['inicio'] == $pagina)
        {
            $return.= '<span class="classPaginadoFooter ui-corner-tl ui-corner-bl ui-state-disabled">Primero</span>';
        }
        else
        {
            $return.= '<span class="classPaginadoFooter ui-corner-tl ui-corner-bl ui-state-default" onclick="'.$onclick.'" '.f::id('pagina').'="'.f::encode('1').'">Primero</span>';
        }

        if($pagina == 1)
        {
            $return.= '<span class="classPaginadoFooter ui-state-disabled">Anterior</span>';
        }
        else
        {
            $return.= '<span class="classPaginadoFooter ui-state-default" onclick="'.$onclick.'" '.f::id('pagina').'="'.f::encode($pagina - 1).'">Anterior</span>';
        }

        if($p['inicio'] > 1)
        {
            $return.= '<span class="classPaginadoFooter ui-state-disabled">...</span>';
        }

        for($i=$p['inicio']; $i <= $p['fin']; $i++)
        {
            if($i == $pagina)
            {
                $return.= '<span class="classPaginadoFooter ui-state-disabled">'.$i.'</span>';
            }
            else
            {
                $return.= '<span class="classPaginadoFooter ui-state-default" onclick="'.$onclick.'" '.f::id('pagina').'="'.f::encode($i).'">'.$i.'</span>';
            }
        }

        if($p['fin'] < $p['total_paginas'])
        {
            $return.= '<span class="classPaginadoFooter ui-state-disabled">...</span>';
        }

        if($pagina == $p['total_paginas'])
        {
            $return.= '<span class="classPaginadoFooter ui-state-disabled">Siguiente</span>';
        }
        else
        {
            $return.= '<span class="classPaginadoFooter ui-state-default" onclick="'.$onclick.'" '.f::id('pagina').'="'.f::encode($pagina + 1).'">Siguiente</span>';
        }


        if($p['fin'] == $pagina)
        {
            $return.= '<span class="classPaginadoFooter ui-corner-tr ui-corner-br ui-state-disabled">Último</span>';
        }
        else
        {
            $return.= '<span class="classPaginadoFooter ui-state-tr ui-corner-br ui-state-default" 
                onclick="'.$onclick.'" '.f::id('pagina').'="'.f::encode($p['total_paginas']).'">Último</span>';
        }

        $return.= '
			</td>
		  </tr>
		</table>
		';
        return $return;
    }
    
    protected function dompdf($titulo,$html,$modo='online')
    {  
        $htmlpdf='
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>'.$titulo.'</title>
             
            <style>
            body
            {
                font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
                font-size:12px;
                font-weight:10;
            }
            div.SiguientePagina 
            {
                page-break-after: always;
            }
            </style>
            </head>

            <body>
            <script type="text/php">
            if ( isset($pdf) ) 
            {
              $font = Font_Metrics::get_font("Trebuchet MS");;
              $size = 10;
              $color = array(0,0,0);
              $text_height = Font_Metrics::get_font_height($font, $size);

              $foot = $pdf->open_object();

              $w = $pdf->get_width();
              $h = $pdf->get_height();

              // Draw a line along the bottom
              $y = $h - $text_height - 24;
              $pdf->line(16, $y, $w - 16, $y, $color, 0.5);

              $pdf->close_object();
              $pdf->add_object($foot, "all");

              $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";  

              // Center the text
              $width = Font_Metrics::get_text_width("Pagina 1 de 2", $font, $size);
              $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
            }
            </script>
            '.$html.'
            </body>
        </html>
        ';
        //return $htmlpdf;
        f::import('resource/plugin/dompdf/dompdf_config.inc.php');
        $oDOMPDF=new DOMPDF();
        $oDOMPDF->load_html($htmlpdf);
        //$dompdf->load_html_file('archivos/complementos/dompdf/www/index.php');
        $oDOMPDF->render();
        switch($modo)
        {
            case 'download':
                $modo=array("Attachment" => 1);
                break;
            default:
                $modo=array("Attachment" => 0);
                break;
        }
        $oDOMPDF->stream($titulo.".pdf",$modo);
    }
}