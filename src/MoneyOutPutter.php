<?php

namespace mwesigwajoshua;

class InvalidCurrencyCodeException extends \Exception {}
class InvalidISOCodeException extends \Exception {}

class MoneyOutPutter
{
    private static $currencies;

    private static function loadCurrencies(): void
    {
        if (null === self::$currencies) {
            $currencyFile = __DIR__ . '/currencies.php';
            if (file_exists($currencyFile)) {
                self::$currencies = require $currencyFile;
            } else {
                throw new \Exception("Currency data file not found.");
            }
        }
    }

    public static function useCode(string $code, string $amount, bool $asFigure = false): ?string
    {
        $amount = str_replace(',', '', $amount);

        self::loadCurrencies();
        if (!isset(self::$currencies[$code])) {
            throw new InvalidCurrencyCodeException("Invalid currency code: $code");
        }

        return self::formatCurrency(self::$currencies[$code], $amount, $asFigure);
    }

    public static function useISONum(int $isoNum, string $amount, bool $asFigure = false): ?string
    {
        self::loadCurrencies();
        $currency = array_filter(self::$currencies, fn($data) => $data['ISOnum'] === $isoNum);
        if (empty($currency)) {
            throw new InvalidISOCodeException("Invalid ISO currency number: $isoNum");
        }
        return self::formatCurrency(array_values($currency)[0], $amount, $asFigure);
    }

    private static function formatCurrency(array $currency, string $amount, bool $asFigure = false): string
    {
        $whole = bcdiv($amount, '1', 0); // Extract whole number part
        $decimalPart = bcsub($amount, $whole, $currency['decimals']); // Get decimal part

        if ($asFigure) {
            // Format as figure
            $result = $currency['symbol'] . ' ' . number_format($whole);
            if (bccomp($decimalPart, '0', $currency['decimals']) !== 0) {
                $result .= '.' . ltrim($decimalPart, '0'); // Add decimal part
            }
        } else {
            // Format as words
            $wholeInWords = self::numberToWords($whole);
            $decimalPartInWords = self::numberToWords(bcmul($decimalPart, $currency['numToBasic']));
            $major = $whole === '1' ? $currency['majorSingle'] : $currency['majorPlural'];
            $minor = $decimalPart === '1' ? $currency['minorSingle'] : $currency['minorPlural'];

            $result = ucfirst($wholeInWords) . ' ' . $currency['demonym'] . ' ' . $major;
            if (bccomp($decimalPart, '0', $currency['decimals']) > 0) {
                $result .= ' and ' . ucfirst($decimalPartInWords) . ' ' . $minor;
            }
        }

        return $result;
    }

    private static function numberToWords(string $number): string
    {
        if (bccomp($number, '0') === 0) {
            return 'zero';
        }

        $words = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
        ];

        $scales = [
            '1000000000000000000000000000000' => 'decillion',
            '1000000000000000000000000000' => 'nonillion',
            '1000000000000000000000000' => 'octillion',
            '1000000000000000000000' => 'septillion',
            '1000000000000000000' => 'sextillion',
            '1000000000000000' => 'quadrillion',
            '1000000000000' => 'trillion',
            '1000000000' => 'billion',
            '1000000' => 'million',
            '1000' => 'thousand',
            '100' => 'hundred',
        ];

        $result = '';

        foreach ($scales as $scale => $word) {
            if (bccomp($number, $scale) >= 0) {
                $count = bcdiv($number, $scale, 0);
                $result .= self::numberToWords($count) . ' ' . $word;
                $number = bcmod($number, $scale);

                if (bccomp($number, '0') > 0) {
                    $result .= ' ';
                }
            }
        }

        if (bccomp($number, '0') > 0) {
            if (bccomp($number, '20') < 0) {
                $result .= $words[(int)$number];
            } else {
                $tens = bcmul(bcdiv($number, '10', 0), '10');
                $units = bcmod($number, '10');
                $result .= $words[(int)$tens];
                if (bccomp($units, '0') > 0) {
                    $result .= '-' . $words[(int)$units];
                }
            }
        }

        return trim($result);
    }
}
