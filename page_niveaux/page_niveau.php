<?php

$total_niveaux = 6;


$niveau_debloque = 1;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Les Niveaux</title>
    <link rel="stylesheet" href="titre_style.css"> 
</head>
    <style>
        <!---la claase des niveau --->

        h1 {
            margin-top: 40px;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .niveau {
            width: 1000px;
            height: 120px;
            margin: 20px;
            border-radius: 20px;
            display: flex;
            justify-content: left;
            align-items: center;
            font-size: 25px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .accessible {
            background-color: #e87979f6;
            color: black;
        }

        .accessible:hover {
            background-color: #a72e1e;
            transform: scale(1.2);
        }

        .verrouille {
            background-color: #555;
            cursor: not-allowed;
            position: relative;
        }

        .verrouille::after {
            content: "🔒";
            position: absolute;
            right: 10px;
            font-size: 48px;
        }
    </style>
</head>
<body>

<h1>Les Niveaux</h1>


<div class="container">
    <?php
    for ($i = 1; $i <= $total_niveaux; $i++) {
        if ($i <= $niveau_debloque) {
            echo "<a href='niveau$i.php' class='niveau accessible'> ㅤㅤㅤNiveau $i : </a>";
        } else {
            echo "<div class='niveau verrouille'> ㅤㅤㅤNiveau $i : </div>";
        }
    }
    ?>
</div>

</body>
</html>

