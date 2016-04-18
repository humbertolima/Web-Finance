<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
         if (empty($_POST["symbol"]))
        {
            apologize("You must provide the stock symbol.");
        }
        else if (empty($_POST["shares"]))
        {
            apologize("You must provide quantity of shares.");
        }
        else
        {
            $stock = lookup($_POST["symbol"]);
            if ($stock == false)
            {
                apologize("You must provide a valid stock symbol.");
            }
            else
            {

                 $rows = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);

                 if(count($rows) == 1)
                 {
                    $user_cash = $rows[0]["cash"];
                    $cash = $stock["price"] * $_POST["shares"];

                    if($user_cash > $cash)
                    {
                       $update_cash = $user_cash - $cash;
                       $rows = CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + ?", $_SESSION["id"], $stock["symbol"], $_POST["shares"], $_POST["shares"]);
                       $update_cash = CS50::query("UPDATE users SET cash = ? WHERE id = ?", $update_cash, $_SESSION["id"]);
                       date_default_timezone_set('US/Eastern');
                       $time = date('m/d/y, H:i:s');
                       $rows = CS50::query("INSERT INTO history (user_id, symbol, shares, price, date_time, transaction) VALUES(?, ?, ?, ?, ?, 'Buy')", $_SESSION["id"], $stock["symbol"], $_POST["shares"], $stock["price"], $time);
                    }
                    else
                    {
                        apologize("You do not have enough cash.");
                    }
                  }


              }


           }
           redirect("/");
    }

?>