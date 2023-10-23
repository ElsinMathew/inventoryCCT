<?php
// Debugging
ini_set('error_reporting', E_ALL);

// DATABASE INFORMATION
define('DATABASE_HOST', getenv('IP'));
define('DATABASE_NAME', 'shop_inventory');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');



// EMAIL DETAILS
define('EMAIL_FROM', 'calanjiyam.cct@gmmail.com'); // Email address invoice emails will be sent from
define('EMAIL_NAME', 'Inventory Mg System'); // Email from address
define('EMAIL_SUBJECT', 'Inventory default email subject'); // Inventory email subject
define('EMAIL_BODY_INVOICE', 'Inventory default body'); // Invoice email body
define('EMAIL_BODY_QUOTE', 'Quote default body'); // Invoice email body
define('EMAIL_BODY_RECEIPT', 'Receipt default body'); // Invoice email body

// OTHER SETTINFS
define('INVOICE_PREFIX', 'MD'); // Prefix at start of invoice - leave empty '' for no prefix
define('INVOICE_INITIAL_VALUE', '1'); // Initial invoice order number (start of increment)
define('INVOICE_THEME', '#222222'); 
define('TIMEZONE', 'Kolkata/Asia'); 
define('DATE_FORMAT', 'DD/MM/YYYY'); // DD/MM/YYYY or MM/DD/YYYY
define('CURRENCY', '₹'); // Currency symbol
define('ENABLE_VAT', true); // Enable TAX/VAT
define('VAT_INCLUDED', false); // Is VAT included or excluded?
define('VAT_RATE', '18'); // This is the percentage value

// CONNECT TO THE DATABASE
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

?>