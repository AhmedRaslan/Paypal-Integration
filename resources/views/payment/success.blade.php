<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test | Success</title>
        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body>
        <a>Thank you for your purchase</a><br><br>
        <a>Reference order id : {{ $orderID }}</a>
    </body>
</html>