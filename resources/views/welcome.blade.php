<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test | Checkout</title>
    </head>
    <body>
        <form action="{{ route('payment.checkout') }}" method="GET">
            @csrf
            <span>Item Name : </span><input type="text" name="name" value="Great Goods"><br><br>
            <span>Item Description : </span><input type="text" name="desc" value="A collection of great goods."><br><br>
            <span>Item Price in USD : </span><input type="text" name="amount" value="10"><br><br>
            <span>Item Quantity : </span><input type="text" name="quant" value="2"><br><br>
            <input type="submit" value="Pay Now with PayPal">
        </form>
    </body>
</html>
