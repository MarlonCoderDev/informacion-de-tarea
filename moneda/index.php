<?php
include 'convert.php';
 
$result = '';
$error = '';
$amount = '';
$currency = 'USD';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'] ?? '';
    $currency = $_POST['currency'] ?? 'USD';
 
    $conversion = convertCurrency($amount, $currency);
    $result = $conversion['result'];
    $error = $conversion['error'];
}
?>
 
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Divisas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
 
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 text-center">Conversor de Divisas</h1>
 
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Cantidad en PEN:</label>
                <input type="number" id="amount" name="amount" value="<?= htmlspecialchars($amount) ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700">Convertir a:</label>
                <select id="currency" name="currency" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="USD" <?= $currency === 'USD' ? 'selected' : '' ?>>USD (Dólares)</option>
                    <option value="EUR" <?= $currency === 'EUR' ? 'selected' : '' ?>>EUR (Euros)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Convert</button>
        </form>
 
        <div class="mt-4 text-center">
            <?php if ($error): ?>
                <p class="text-red-500"><?= htmlspecialchars($error) ?></p>
            <?php elseif ($result): ?>
                <p class="text-lg text-gray-700"><?= htmlspecialchars($result) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
 
</html>