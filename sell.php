<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("sell_form.php", ["title" => "Sell"]);
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

                 $rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);

                 if(count($rows) == 1)
                 {
                     $shares = $rows[0]["shares"];
                     if($shares >= $_POST["shares"])
                     {
                        $actual_price = $stock["price"];
                        $get_cash = $actual_price * $_POST["shares"];
                        $shares_update = $shares - $_POST["shares"];
                        $update_cash = CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $get_cash, $_SESSION["id"]);
                        $update_shares = CS50::query("UPDATE portfolio SET shares = ? WHERE user_id = ? AND symbol = ?", $shares_update, $_SESSION["id"], $_POST["symbol"]);
                        date_default_timezone_set('US/Eastern');
                        $time = date('m/d/y, H:i:s');
                        $rows = CS50::query("INSERT INTO history (user_id, symbol, shares, price, date_time, transaction) VALUES(?, ?, ?, ?, ?, 'Sell')", $_SESSION["id"], $stock["symbol"], $_POST["shares"], $stock["price"], $time);
                     }
                     else
                     {
                         apologize("You must provide correctly amount of stock shares to sale.");
                     }

                 }
            }


        }
        redirect("/");

    }

?>