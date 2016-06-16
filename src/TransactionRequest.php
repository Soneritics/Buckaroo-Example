<?php
/**
 * Initialize an iDeal payment.
 * As a result, we should get a redirect location where a bank can be chosen.
 */

// Start the example (test) ideal payment
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../vendor/autoload.php';
require_once 'configs.php';

$gateway = new \Buckaroo\Gateways\Test;
$transactionRequest = new \Buckaroo\ServiceOperations\TransactionRequest;
$buckaroo = new \Buckaroo\Buckaroo($gateway, $websiteKey, $secretKey);

$transactionRequest
    ->setCurrency(new \Buckaroo\Currency\EUR)
    ->setPaymentMethod(new \Buckaroo\PaymentMethods\iDeal)
    ->setAmount(12.5)
    ->setInvoiceNumber('Test-' . time())
    ->setReturnURL($returnURL)
    ->setCancelURL($returnURL)
    ->setRejectURL($returnURL)
    ->setErrorURL($returnURL);

$response = $buckaroo->performServiceOperation($transactionRequest);

try {
    $redirectURL = $response->getField('BRQ_REDIRECTURL');
    header("Location: {$redirectURL}");
} catch (Exception $ex) {
    echo 'ERROR: Something went wrong: ' . $ex->getMessage();
}
