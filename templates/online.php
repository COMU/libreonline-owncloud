<!DOCTYPE html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Libreoffice Online Viewer</title>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
  $urlGenerator = $_['urlGenerator'];
?>
<link rel="stylesheet" href="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/dist/leaflet.css')) ?>">
<link rel="stylesheet" href="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/plugins/draw-0.2.4/dist/leaflet.draw.css')) ?>">
<link rel="stylesheet" href="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/src/scrollbar/jquery.mCustomScrollbar.css')) ?>">
<link rel="stylesheet" href="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/dist/dialog/vex.css')) ?>" />
<link rel="stylesheet" href="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/dist/dialog/vex-theme-plain.css')) ?>" />
<style type="text/css"></style></head>
<body>
<script src="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/src/scrollbar/jquery-1.11.0.min.js')) ?>"></script>
    <script src="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/dist/leaflet-src.js')) ?>"></script>
    <script src="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/plugins/draw-0.2.4/dist/leaflet.draw.js')) ?>"></script>
    
    <script src="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/src/scrollbar/jquery.mCustomScrollbar.js')) ?>"></script>
    <script src="<?php p($urlGenerator->linkTo('libreonline', 'loleaflet/dist/dialog/vex.combined.min.js')) ?>"></script>
    <script type="text/javascript">vex.defaultOptions.className = 'vex-theme-plain';</script>


    <div id="toolbar">
    </div>
    <div id="document-container">
        <div id="map"></div>
    </div>

	<script type="text/javascript">
    var LOOLWSD_IP = window.location.hostname;
    var LOOLWSD_PORT = '9980';

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : results[1].replace(/\+/g, " ");
    }

    var host = getParameterByName('host');
    var edit = getParameterByName('edit') === 'true';
    var timestamp = getParameterByName('timestamp');
    var filePath= decodeURIComponent(getParameterByName('file'));

    var extension = filePath.split('.').pop();
    if (filePath.indexOf('/') > -1)
    {
        var parts = filePath.split('/');
        var newtitle = filePath.split('/')[parts.length-1];
        document.title = newtitle;
        if (top.document) {
            top.document.title = newtitle;
        }
    }
    else
    {
        if (top.document) {
            top.document.title = newtitle;
        }
    }

   //var filePath = decodeURIComponent(getParameterByName('file'));
    if (filePath === '') {
        vex.dialog.alert('Wrong file_path, usage: file_path=/path/to/doc/');
    }
    host='ws://' + LOOLWSD_IP + ':' + LOOLWSD_PORT;
    if (host === '') {
        vex.dialog.alert('Wrong host, usage: host=ws://localhost:9980');
    }

    var renderingOptions = {
        ".uno:HideWhitespace": {
            "type": "boolean",
            "value": "false"
        }
    };


    L.TileLayer.prototype._onDownloadAsMsg = function(textMsg) {
        var command = L.Socket.parseServerCmd(textMsg);

        $.get(
            "save", 
            {
                ip: LOOLWSD_IP,
                port: LOOLWSD_PORT,
                jail: command.jail, 
                dir: command.dir, 
                name: command.name,
                target: decodeURIComponent(getParameterByName('file'))
            },
            function(data) {
                vex.dialog.alert('File saved.')
            });
    }

    L.TileLayer.prototype.__onMessage = L.TileLayer.prototype._onMessage;

    L.TileLayer.prototype._onMessage = function(textMsg, img) {
        if (textMsg.startsWith('unocommandresult:')) {
            L.Socket.sendMessage("downloadas name=document." + extension + " id=-1 format=" + extension + " options=");
        }

        this.__onMessage(textMsg, img);
    }

    $.get(
        "generateFileURL", 
        {
            file: filePath
        },
        function(fileURL) {
            var globalMap = L.map('map', {
                    doc: "http://" + location.hostname + "/" + fileURL,
                    renderingOptions: renderingOptions,
                    server: host,
                    edit: edit,
                    timestamp: timestamp,
                    readOnly: false
                });

            ////// Controls /////
            globalMap.addControl(L.control.styles());
            globalMap.addControl(L.control.fonts());
            globalMap.addControl(L.control.buttons());
            globalMap.addControl(L.control.statusIndicator());
            globalMap.addControl(L.control.scroll());
            globalMap.addControl(L.control.formulaBar());
            globalMap.addControl(L.control.zoom());
            globalMap.addControl(L.control.parts());
            globalMap.addControl(L.control.search());
            globalMap.addControl(L.control.insertImg());
            globalMap.addControl(L.control.dialog());
            globalMap.addControl(L.control.partsPreview());
    });
    
    </script>
</body></html>
