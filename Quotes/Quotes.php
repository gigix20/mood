<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positive Quote Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f8ff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .quote {
            font-size: 1.8em;
            margin-bottom: 20px;
            font-style: italic;
            color: #007bff;
        }
        .author {
            font-size: 1.2em;
            color: #555;
        }
        .refresh {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
            font-size: 1em;
        }
        .refresh:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Array of positive quotes
        $quotes = [
            ["quote" => "Keep your face always toward the sunshine—and shadows will fall behind you.", "author" => "Walt Whitman"],
            ["quote" => "You are never too old to set another goal or to dream a new dream.", "author" => "C.S. Lewis"],
            ["quote" => "Start where you are. Use what you have. Do what you can.", "author" => "Arthur Ashe"],
            ["quote" => "The only limit to our realization of tomorrow is our doubts of today.", "author" => "Franklin D. Roosevelt"],
            ["quote" => "It always seems impossible until it’s done.", "author" => "Nelson Mandela"],
            ["quote" => "Every day is a new beginning. Take a deep breath, smile, and start again.", "author" => "Anonymous"],
            ["quote" => "Believe you can and you're halfway there.", "author" => "Theodore Roosevelt"],
            ["quote" => "Happiness is not by chance, but by choice.", "author" => "Jim Rohn"],
            ["quote" => "What lies behind us and what lies before us are tiny matters compared to what lies within us.", "author" => "Ralph Waldo Emerson"],
            ["quote" => "Act as if what you do makes a difference. It does.", "author" => "William James"],
        ];

        // Generate a random positive quote
        $randomIndex = array_rand($quotes);
        $randomQuote = $quotes[$randomIndex];

        // Display the quote and author
        echo "<div class='quote'>\"{$randomQuote['quote']}\"</div>";
        echo "<div class='author'>- {$randomQuote['author']}</div>";
        ?>
        <a href="" class="refresh">Get Another Quote</a>
    </div>
</body>
</html>
