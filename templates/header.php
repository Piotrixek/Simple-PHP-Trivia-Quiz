<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php quiz challenge!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db; /* brighter blue */
            --secondary-color: #2ecc71; /* green */
            --wrong-color: #e74c3c; /* red */
            --light-bg: #ecf0f1; /* very light grey */
            --dark-text: #2c3e50; /* dark blue/grey */
            --light-text: #ffffff;
            --card-bg: #ffffff;
            --border-color: #bdc3c7;
            --hover-bg: #f1f1f1;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* align top */
            min-height: 100vh;
        }
        .container {
            background-color: var(--card-bg);
            padding: 30px 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 700px;
            text-align: center;
        }
        h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 700;
        }
        h2 {
             color: var(--dark-text);
             margin-bottom: 25px;
             font-weight: 600;
        }
        .message {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-align: left;
            border: 1px solid transparent;
        }
        .message.feedback-correct {
            background-color: #dff0d8; /* light green */
            color: #3c763d; /* dark green */
            border-color: #d6e9c6;
        }
        .message.feedback-wrong {
            background-color: #f2dede; /* light red */
            color: #a94442; /* dark red */
            border-color: #ebccd1;
        }
        .message.info {
             background-color: #d9edf7; /* light blue */
             color: #31708f; /* dark blue */
             border-color: #bce8f1;
        }
        .progress-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            margin-bottom: 20px;
            height: 10px;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            width: 0%; /* set dynamically */
            background-color: var(--secondary-color);
            border-radius: 5px;
            transition: width 0.3s ease-in-out;
        }
        .score-info {
            text-align: right;
            margin-bottom: 15px;
            font-weight: 600;
            color: #555;
        }
        /* General link styling */
        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
        /* Button styling */
        button, .button-link {
            display: inline-block; /* changed for flexibility */
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            text-align: center;
            margin-top: 10px; /* add some space */
        }
        button:hover, .button-link:hover {
            background-color: #2980b9; /* darker blue */
            transform: translateY(-1px);
        }
        button[type="submit"] {
             width: auto; /* allow natural width */
             min-width: 150px;
        }
        .play-again-link {
             background-color: var(--secondary-color);
        }
         .play-again-link:hover {
             background-color: #27ae60; /* darker green */
         }

         /* High score table */
        .high-scores-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }
        .high-scores-table th, .high-scores-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
        }
         .high-scores-table th {
            background-color: var(--light-bg);
            font-weight: 600;
         }
         .high-scores-table tr:last-child td {
            border-bottom: none;
         }
         .high-scores-table td:nth-child(2) { /* Score column */
            font-weight: 700;
            text-align: center;
         }
         .high-scores-table td:nth-child(3) { /* Name column */
             font-style: italic;
         }

         /* Form styling */
         form label {
             display: block;
             background: var(--light-bg);
             padding: 15px;
             margin-bottom: 10px;
             border-radius: var(--border-radius);
             border: 1px solid var(--border-color);
             cursor: pointer;
             transition: background-color 0.2s ease, border-color 0.2s ease;
             text-align: left;
             font-weight: 400; /* normal weight for answers */
         }
         form label:hover {
             background: var(--hover-bg);
             border-color: #999;
         }
         form input[type="radio"] {
             margin-right: 12px;
             transform: scale(1.1); /* slightly larger radio */
             accent-color: var(--primary-color); /* style the radio button itself */
         }
         form input[type="text"], form select {
             display: block;
             width: calc(100% - 24px); /* account for padding */
             padding: 12px;
             margin-bottom: 15px;
             border: 1px solid var(--border-color);
             border-radius: var(--border-radius);
             font-size: 1em;
         }

    </style>
</head>
<body>
    <div class="container">
        <h1>php quiz challenge!</h1>