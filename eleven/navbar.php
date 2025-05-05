<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        nav {
            background-color: black;
            padding: 30px;
        }

        ul {
            display: flex;
            gap: 1rem;
        }

        li,
        a {
            text-decoration: none;
            list-style: none;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="create.php">Create</a>
            </li>
            <li>
                <a href="show.php">Show</a>
            </li>
        </ul>
    </nav>
</body>

</html>