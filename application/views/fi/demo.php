<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scanner.js demo: Scan as JPEG and display on the web page</title>
    <meta charset='utf-8'>
    <script src="<?php echo base_url('assets/');?>plugins/scanner/scanner.js" type="text/javascript"></script>

    <script>
        //
        // Please read scanner.js developer's guide at: http://asprise.com/document-scan-upload-image-browser/ie-chrome-firefox-scanner-docs.html
        //

        /** Initiates a scan */
        function scanToJpg() {
            scanner.scan(displayImagesOnPage,
                    {
                        "output_settings": [
                            {
                                "type": "return-base64",
                                "format": "jpg"
                            }
                        ]
                    }
            );
        }

        /** Processes the scan result */
        function displayImagesOnPage(successful, mesg, response) {
            if(!successful) { // On error
                console.error('Failed: ' + mesg);
                return;
            }

            if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
                console.info('User cancelled');
                return;
            }

            var scannedImages = scanner.getScannedImages(response, true, false); // returns an array of ScannedImage
            for(var i = 0; (scannedImages instanceof Array) && i < scannedImages.length; i++) {
                var scannedImage = scannedImages[i];
                processScannedImage(scannedImage);
            }
        }

        /** Images scanned so far. */
        var imagesScanned = [];

        /** Processes a ScannedImage */
        function processScannedImage(scannedImage) {
            imagesScanned.push(scannedImage);
            var elementImg = scanner.createDomElementFromModel( {
                'name': 'img',
                'attributes': {
                    'class': 'scanned',
                    'src': scannedImage.src
                }
            });
            document.getElementById('images').appendChild(elementImg);
        }

    </script>

    <style>
        img.scanned {
            height: 200px; /** Sets the display size */
            margin-right: 12px;
        }

        div#images {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>Scanner.js: scan as JPG and display on the web page</h2>

    <button type="button" onclick="scanToJpg();">Scan</button>

    <div id="images"></div>


    <!-- HELP_LINKS_START help links at the bottom -->
    <style>
        .asprise-footer, .asprise-footer a:visited { font-family: Arial, Helvetica, sans-serif; color: #999; font-size: 13px; }
        .asprise-footer a {  text-decoration: none; color: #999; }
        .asprise-footer a:hover {  padding-bottom: 2px; border-bottom: solid 1px #9cd; color: #06c; }
    </style>
    <!-- <div class="asprise-footer" style="margin-top: 48px;">
        <a href="http://asprise.com/document-scan-upload-image-browser/direct-to-server-php-asp.net-overview.html" target="_blank" title="Opens in new tab">Scanner.js Homepage</a> |
        <a href="http://asprise.com/scan/scannerjs/docs/html/scannerjs-javascript-guide.html" target="_blank" title="Opens in new tab">Developer's Guide to ScannerJs</a> |
        <a href="https://github.com/Asprise/scannerjs.javascript-scanner-access-in-browsers-chrome-ie.scanner.js" target="_blank" title="Opens in new tab">Sample code on Github</a>
    </div> -->
    <!-- HELP_LINKS_END -->
</body>
</html>