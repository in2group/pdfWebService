<?php

include("mPDF_wrapper.php");

header("Content-Type:application/json");

// HTML
if( ! empty( $_POST['html']) )
{
    $html = $_POST['html'];
    $html = base64_decode( $html );
}

// Header
$header = null;
if( ! empty( $_POST['header']) )
{
    $header = $_POST['header'];
    $header = base64_decode( $header );
}



// Footer
$footer = null;
if( ! empty( $_POST['footer']) )
{
    $footer = $_POST['footer'];
    $footer = base64_decode( $footer );
}

// Watermark
$watermark=null;
if( ! empty( $_POST['watermark']) )
{
    $watermark = $_POST['watermark'];
    $watermark = base64_decode( $watermark );
}

// Page
$page=null;
if( ! empty( $_POST['page']) )
{
    $page = $_POST['page'];
    $page = base64_decode( $page );
}


set_error_handler('errHandle');

$success = true;

$mpdf = new mPDF_wrapper();



$output = $mpdf->writeOutput( $html , $header, $footer, $watermark, $page );

echo  json_encode(   $output );  // api returns

exit;




function errHandle($errNo, $errStr, $errFile, $errLine) {
    $msg = "$errStr in $errFile on line $errLine";
    if ($errNo == E_NOTICE || $errNo == E_WARNING) 
    {
        $success = false;
        throw new ErrorException($msg, $errNo);
    } 
    else 
    {
        echo "Error: " .$msg;
    }
}


