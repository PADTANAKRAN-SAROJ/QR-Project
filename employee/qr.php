<?php
include "../connect.php";

$sql = "SELECT * FROM customer WHERE state = 'On_table'";
$stmt = $pdo->query($sql);

$tableStatus = array_fill(1, 10, 'empty');

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tableStatus[$row['table_number']] = 'full';
}
?>

<!DOCTYPE html>
<html>
<head>

</head>
<body>
<table>
    <tr>
        <th>Table Number</th>
    </tr>
    <?php for ($tableNumber = 1; $tableNumber <= 10; $tableNumber++): ?>
        <?php
            $tableClass = ($tableStatus[$tableNumber] === 'full') ? 'full' : 'empty';
            $cusId = getCusId($tableNumber);
        ?>
        <tr>
            <td class="<?= $tableClass ?>">
                <?php if ($tableStatus[$tableNumber] === 'full'): ?>
                    <button class="button" onclick="showDetail(<?= $cusId ?>)"><?= $tableNumber ?> full</button>
                <?php else: ?>
                    <button class="button" onclick="createQR(<?= $tableNumber ?>)"><?= $tableNumber ?></button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endfor; ?>
</table>
</body>
</html>

<?php
function getCusId($tableNumber) {
    global $pdo;
    $sql = "SELECT cus_id FROM customer WHERE state = 'On_table' AND table_number = $tableNumber";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['cus_id'] : null;
}
?>
