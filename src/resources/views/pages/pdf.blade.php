<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .product {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        .product .name {
            flex-basis: 70%;
        }
        .product .price {
            flex-basis: 30%;
            text-align: right;
        }
        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #ccc;
            font-weight: bold;
        }
        .total .label {
            flex-basis: 70%;
        }
        .total .amount {
            flex-basis: 30%;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ticket de Compra</h1>
        </div>

        <div class="products">
            @foreach ($order as $products)
                @foreach ($products[0] as $product)
                    <div class="product">
                        <div class="name">{{ $product->name }}</div>
                        <div class="price">{{ $product->price }}€</div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div class="total">
            <div class="label">Total:</div>
            <div class="amount">{{ $total }}€</div>
        </div>
    </div>
</body>
</html>
