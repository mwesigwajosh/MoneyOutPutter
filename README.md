MoneyOutPutter 🏦💰
A simple PHP library to format currency amounts in both figures and words.
Easily convert between ISO currency codes or numeric codes and get the formatted result with beautiful output.


Features 🚀
Currency Code Lookup: Format currency amounts using ISO currency codes (e.g., USD, UGX).
ISO Numeric Code Lookup: Convert currency using ISO numeric codes (e.g., 840 for USD, 800 for UGX).
Error Handling: Throws exceptions for invalid currency or numeric codes.
Formatting Options:
Format amounts as figures (e.g., UGX 1,000,000).
Format amounts in words (e.g., "One million Ugandan Shillings").

Installation 📥
To install MoneyOutPutter via Composer, run the following command in your terminal:
$composer require mwesigwajoshua/moneyoutputter


Usage Example 💡
Below are examples of how you can use MoneyOutPutter to format currency amounts.

Example 1: Format as Words

require 'vendor/autoload.php';
use mwesigwajoshua\MoneyOutPutter;

$amount = "1,000,000"; // Amount should be passed as a string
$currencyCode = 'UGX'; // ISO currency code for Ugandan Shillings

// Get formatted amount in words
$formattedAmount = MoneyOutPutter::useCode($currencyCode, $amount);
echo $formattedAmount; // Output: One million Ugandan Shillings


Example 2: Format as Figures (with Currency Symbol)

require 'vendor/autoload.php';

use mwesigwajoshua\MoneyOutPutter;

$amount = "1,000,000"; // Amount should be passed as a string
$currencyCode = 'UGX'; // ISO currency code for Ugandan Shillings

// Get formatted amount as figures with currency symbol
//Note: A 3rd arguement is passed as true
$formattedAmount = MoneyOutPutter::useCode($currencyCode, $amount, true);
echo $formattedAmount; // Output: USh 1,000,000

