<?php foreach ($values as $value): ?>
<div class="table-responsive">
       <table class='table'>
            <tr>
                <td>Transaction: <?= $value["transaction"] ?></td>
            </tr>
            <tr>
                <td>Date/Time: <?= $value["date_time"] ?></td>
            </tr>
            <tr>
                <td>Symbol: <?= $value["symbol"] ?></td>
            </tr>
            <tr>
                <td>Shares: <?= $value["shares"] ?></td>
            </tr>
            <tr>
                <td>Price: $<?= $value["price"] ?></td>
            </tr>
        </table>
</div>

<?php endforeach ?>