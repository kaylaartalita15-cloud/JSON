<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daily Quotes</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f1eb;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .quote-card {
            width: 90%;
            max-width: 600px;
            background: white;
            padding: 50px 45px;
            border-radius: 20px;
            text-align: center;

            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .title {
            color: #8b6f5c;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .quote {
            font-size: 28px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 20px;
        }

        .quote::before {
            content: "“";
            font-size: 50px;
            color: #c9a98d;
        }

        .author {
            color: #777;
            font-size: 16px;
            font-style: italic;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            padding: 10px 22px;
            background: #8b6f5c;
            color: white;
            text-decoration: none;
            border-radius: 10px;
        }

        .button:hover {
            background: #6f5748;
        }
    </style>
</head>

<body>

    <div class="quote-card">

        <div class="title">
            ✦ Daily Quotes ✦
        </div>

        <div class="quote">
            {{ $singleQoute['quote'] }}
        </div>

        <div class="author">
            — {{ $singleQoute['author'] }}
        </div>

        <a href="/quotes" class="button">
            Quote Lainnya
        </a>

    </div>

</body>
</html>