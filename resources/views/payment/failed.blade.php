<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test | Success</title>
    </head>
    <body>
        <a>Order failed, due to payment cancelation !</a><br><br>
        <a>Reference order id : {{ $orderID }}</a><br><br>
    </body>
</html>