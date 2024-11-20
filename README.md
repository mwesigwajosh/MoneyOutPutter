# MoneyOutPutter 🏦💰

A simple PHP library to format currency amounts in both figures and words.
Easily convert between ISO currency codes or numeric codes and get the formatted result with beautiful output.

## Features 🚀

1. **Currency Code Lookup**: Format currency amounts using ISO currency codes (e.g., **USD**, **UGX**).
2. **ISO Numeric Code Lookup**: Convert currency using ISO numeric codes (e.g., **840** for USD, **800** for UGX).
3. **Error Handling**: Throws exceptions for invalid currency or numeric codes.
4. **Formatting Options**:
   - Format amounts as **figures** (e.g., _USh 1,000,000_).
   - Format amounts **in words** (e.g., _"One million Ugandan Shillings"_).

## Installation 📥

To install MoneyOutPutter via Composer, run the following command in your terminal:

```bash
$ composer require mwesigwajoshua/moneyoutputter
```

## Usage Example 💡

### Example 1 (Format as Words)

```php
require 'vendor/autoload.php';
use mwesigwajoshua\MoneyOutPutter;

$amount = "1,000,000"; // Amount should be passed as a string
$currencyCode = 'UGX'; // ISO currency code for Ugandan Shillings

// Get formatted amount in words
$formattedAmount = MoneyOutPutter::useCode($currencyCode, $amount);
echo $formattedAmount; // Output: **One million Ugandan Shillings**
```

### Example 2 (Format as Figures with Currency Symbol)

```php
require 'vendor/autoload.php';
use mwesigwajoshua\MoneyOutPutter;

$amount = "1,000,000"; // Amount should be passed as a string
$currencyCode = 'UGX'; // ISO currency code for Ugandan Shillings

// Get formatted amount as figures with currency symbol
// **Note**: A **3rd argument** is passed as `true` to include currency symbol
$formattedAmount = MoneyOutPutter::useCode($currencyCode, $amount, true);
echo $formattedAmount; // Output: **USh 1,000,000**
```

### Example 3 (Using ISO num)

```php
require 'vendor/autoload.php';

use  mwesigwajoshua\MoneyOutPutter;

$amount =  "5225.50"; //Please note: amount should be passed as a string
$Isonum = '800'; // 800 is Ugandan Shilling ISOnum

$formattedAmount = MoneyOutPutter::useISONum($Isonum, $amount);
echo $formattedAmount; //output: **Five Thousand Two Hundred Twenty Five Ugandan Shillings And Fifty Five Cents**

$formattedAmount = MoneyOutPutter::useISONum($Isonum, $amount, true);
echo $formattedAmount; //output: **USh 5,225.50**
```