<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'autoloader.php';
require_once 'configs.php';

try {
    $transactionStatusResponse = new \Buckaroo\Response\TransactionStatusResponse($_POST, $secretKey);

    if ($transactionStatusResponse->getStatus() === \Buckaroo\Status::SUCCESS) {
        $order = $transactionStatusResponse->getInvoiceNumber();
        $currency = $transactionStatusResponse->getCurrency();
        $amount = $transactionStatusResponse->getAmount();
        echo "The order {$order} with amount {$currency} {$amount} has been paid.";
    } elseif ($transactionStatusResponse->getStatus() === \Buckaroo\Status::PENDING_PROCESSING) {
        $paymentCode = $transactionStatusResponse->getPaymentCode();
        echo "The order is pending. Fetch transaction details later for order with payment code {$paymentCode}.";
    } else {
        echo 'Order has not been paid for.';
    }
} catch (\Buckaroo\Exceptions\InvalidSignatureException $e) {
    echo 'Signature does not match, possible break in attempt.';
}
