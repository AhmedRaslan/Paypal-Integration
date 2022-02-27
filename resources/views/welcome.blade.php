<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test | Checkout</title>
        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body>
        <form action="{{ route('payment.checkout') }}" method="GET">
            @csrf
            <input type="text" name="amount" value="10"><br><br>
            <input type="submit" value="Pay Now with PayPal">
        </form>
    </body>
</html>
