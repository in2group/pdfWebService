<?php

require_once __DIR__ . '/vendor/autoload.php';
    
class mPDF_wrapper
{
    private $mpdf;


    function writeOutput( $html, $header=null, $footer=null, $watermark=null, $pageJson=null )
    {

        try
        {
            $mpdfConfig = array (
                "format"  => "A4",
                "tempDir" => __DIR__ . '/temp'
            );

            $mpdfConfig = $this->setPage($pageJson, $mpdfConfig);

                //'tempDir'       => __DIR__ . '/temp',
                //'debug'         => true,
                //'allow_output_buffering' => true, 
                // 'format'        => $page["format"],
                // 'orientation'   => $page["orientation"]
                // 'margin_left'   => '40',
                // 'margin_top'    => '30', margin_header
                // 'format'        => 'A5',
                //    'orientation'   => 'L',
                
            $mpdf = new \Mpdf\Mpdf( $mpdfConfig );

            //  Watermark
            $this->setWatermark($mpdf, $watermark);
            
            
            if ( null != $header )
                $mpdf->SetHTMLHeader($header);

            if ( null != $footer )
                $mpdf->SetHTMLFooter($footer);

            $mpdf->WriteHTML($html);
            
            $output = $mpdf->Output('',  \Mpdf\Output\Destination::STRING_RETURN );
        }
        catch(\Mpdf\MpdfException $me)
        {
            $retVal = $this->writeResult( false, $me->getCode(), "ERROR: " .$me->getMessage() , null);
            return $retVal;
        }
        catch(Exception $e)
        {
            $retVal = $this->writeResult( false, $e->getCode(), "ERROR 2: " .$e->getMessage() , null);
            return $retVal;
        }

        $retVal = $this->writeResult( true, 0, null , $output);
        return $retVal;
    }

    function writeResult( $success, $errorCode, $errorMessage, $pdfData  )
    {
        $data = array("success"     => $success,
                    "errorCode"     => $errorCode,
                    "errorMessage"  => $errorMessage,
                    "pdfData"       => base64_encode($pdfData)
                        );
        
        return $data;
    }

    function setWatermark($mpdf, $watermarkJson )
    {
        if( null == $watermarkJson)
            return;

        
        $watermark = json_decode($watermarkJson, true); 
        
        if(null == $watermarkJson)
        {
            $mpdf->showWatermarkText = true;
            $mpdf->SetWatermarkText($watermarkJson) ;
            return;
        }
        else
        {

            if( ! empty($watermark["text"]))
                $text = $watermark["text"];
            
            $imageUrl = null; 
            if( ! empty($watermark["imageUrl"]))
                $imageUrl = $watermark["imageUrl"];

            $alpha = null;   
            if( ! empty($watermark["alpha"]))
                $alpha = $watermark["alpha"];

            $fontFamily = null;    
            if( ! empty($watermark["fontFamily"]))
                $fontFamily = $watermark["fontFamily"];

            if( null != $imageUrl )
                $this->_setWatermarkPicture( $mpdf, $imageUrl, $alpha);
            else
                $this->_setWatermarkText( $mpdf, $text, $alpha, $fontFamily);
        }

        return;
    }

    function _setWatermarkPicture($mpdf, $imageUrl, $alpha )
    {
        if (null == $alpha)
            $alpha = 0.1;

        $mpdf->SetWatermarkImage($imageUrl, $alpha);
        $mpdf->showWatermarkImage = true;    
    }

    function _setWatermarkText($mpdf, $text, $alpha, $fontFamily )
    {
        if (null == $alpha)
            $alpha = 0.1;

        $mpdf->SetWatermarkText($text, $alpha);
        $mpdf->showWatermarkText = true;    

        if (null != $fontFamily)
            $mpdf->watermark_font = $fontFamily;
    }

    function setPage($pageJson, $mpdfConfig)
    {
        $retVal = $mpdfConfig;

        if( null == $pageJson)
            return $retVal;

        
        $page = json_decode($pageJson, true); 
        
        if( ! empty($page["format"]))
            $retVal["format"] = $page["format"];
            
        if( ! empty($page["margin_left"]))
            $retVal["margin_left"] = $page["margin_left"];

        if( ! empty($page["margin_right"]))
            $retVal["margin_right"] = $page["margin_right"];

        if( ! empty($page["margin_top"]))
            $retVal["margin_top"] = $page["margin_top"];

        if( ! empty($page["margin_bottom"]))
            $retVal["margin_bottom"] = $page["margin_bottom"];


        if( ! empty($page["margin_header"]))
            $retVal["margin_header"] = $page["margin_header"];

        if( ! empty($page["margin_footer"]))
            $retVal["margin_footer"] = $page["margin_footer"];

        return $retVal;
    }





}

