<?php

    // configuration
    require("../includes/config.php");

    $rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $_SESSION["id"]);
    $user = CS50::query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
    if (count($rows) >= 1)
    {
        $positions = [];
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => $stock["price"],
                    "shares" => $row["shares"],
                    "symbol" => $row["symbol"]
                ];
            }
        }

        render("portfolio.php", ["positions"=>$positions, "cash"=>$user, "title" => "Portfolio"]);
    }
    else
    {
        render("portfolio.php", ["cash"=>$user, "title" => "Portfolio"]);
    }
?>
