<?php

if (version_compare(phpversion(), '7.1', '<'))
{
    echo '<!DOCTYPE html>
<html>
    <head>
        <title>Azizi Search Engine</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: \'Lato\', sans-serif;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <img src="imgs/error.png" width="280" height="280"/>
                <div class="title">PHP version</div>
                <div class="description">PHP version not supported please use PHP version 7.2 or above</div>
            </div>
        </div>
    </body>
</html>';
    die();
}