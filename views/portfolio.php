<?php foreach ($cash as $ca): ?>
<div class="table-responsive">
       <table class='table'>
            <tr>
                <td>Cash: $<?= number_format($ca["cash"], 4, '.', '') ?></td>
            </tr>

        </table>
</div>
<?php endforeach ?>
<?php if (isset($positions)): ?>
<?php foreach ($positions as $position): ?>
<div class="table-responsive">
       <table class='table'>
            <tr>
                <td>Symbol: <?= $position["symbol"] ?></td>
            </tr>
            <tr>
                <td>Company Name: <?= $position["name"] ?></td>
            </tr>
            <tr>
                <td>Stocks: <?= $position["shares"] ?></td>
            </tr>
            <tr>
                <td>Price: <?= $position["price"] ?></td>
            </tr>
        </table>
</div>
<?php endforeach ?>
<?php endif ?>