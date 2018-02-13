# About mPDFWrapper

**mPDFWrapper** is a prototyping REST API web service tool meant for users who want to create PDF files from online HTML form.  **mPDFWrapper**  API returns a PDF download to the browser of the POSTed URL using the users's own print styles .

It is based on [mPDF](https://github.com/mpdf/mpdf) PHP library which generates PDF files from UTF-8 encoded HTML.

## About mPDF
[mPDF](https://github.com/mpdf/mpdf) is a PHP library which generates PDF files from UTF-8 encoded HTML.

It is based on [FPDF](http://www.fpdf.org/) and [HTML2FPDF](http://html2fpdf.sourceforge.net/)
(see [CREDITS](CREDITS.txt)), with a number of enhancements. mPDF was written by Ian Back and is released
under the GNU GPL v2 licence.

## Status
This tool is a prototype and is not recommended for use in a production environment.

## Requirements
Requires PHP ^5.6 || ~7.0.0 || ~7.1.0 || ~7.2.0. PHP mbstring and gd extensions have to be loaded.

### Installation using Composer
You can install the class mPDFWrapper with Composer and Packagist by adding the in2group/mpdfwrapper package to your composer.json file.


```
 "require": {
		"php": ">=5.4",
        "in2group/mpdfwrapper"
    },
```
Or you can add the class directly from the terminal prompt:
```
composer require in2group/mpdfwrapper
```
### Configuration note
mPDFWrapper and mPDF are pre-configured to use <path to mPDFWrapper>/tmp as a directory to write temporary files (mainly for images and fonts). Write permissions must be set for read/write access for the tmp directory.  

## Usage
**mPDFWrapper** accepts POST HTTP requests with HTML content and renders PDF document out of it. Only the following Content Types are supported:
- text/plain
- text/html
- application/json

To generate PDF, you have to define parameters for the POST request. Available options are *html*, *header*, *footer*, *watermark* and *page*.

POST:

```
html      : base64 encoded text or HTML for document body. Mandatory.
header    : base64 encoded text or HTML for document header. Optional
footer    : base64 encoded text or HTML for document footer. Optional
watermark :  base64 encoded JSON data for watermark text. Optional
page      :  base64 encoded JSON data for page setup. Optional
```

Response from the **mPDFWrapper** will be sent in JSON format as follows:

```
success      : true/false. If any error occour value is false
errorCode    : numeric, default 0. If any error occour value is error code
errorMessage : null, If any error occour value is error description 
pdfData      : if success, base64 encoded stream

{
	"success": true,
	"errorCode": 0,
	"errorMessage": null,
	"pdfData":"JVBERi0xLjQKJeLjz9MKJVBE......"
}

```

   
### Licence information:
mPDFWrapper was written by [In2Group](https://github.com/in2group/) and is released under the [GNU GPL v2 licence](LICENSE).
