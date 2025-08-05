<?php

namespace App\Helpers;

class NumberToWordsHelper
{
    public static function convertNumberToWordsINR($number)
    {
        $words = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six',
            'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve',
            'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
            'Eighteen', 'Nineteen'
        ];

        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

        if ($number == 0) return 'Zero Rupees Only';

        $result = '';
        $num = (int) $number;
        $decimal = round(($number - $num) * 100);

        $parts = [];

        // Split number into parts [crore, lakh, thousand, hundred, rest]
        $parts[] = (int)($num / 10000000);           // Crores
        $parts[] = (int)(($num / 100000) % 100);      // Lakhs
        $parts[] = (int)(($num / 1000) % 100);        // Thousands
        $parts[] = (int)(($num / 100) % 10);          // Hundreds
        $parts[] = (int)($num % 100);                 // Last two digits

        $labels = ['Crore', 'Lakh', 'Thousand', 'Hundred', ''];

        for ($i = 0; $i < count($parts); $i++) {
            $n = $parts[$i];
            if ($n == 0) continue;

            if ($n < 20) {
                $result .= $words[$n] . ' ';
            } else {
                $result .= $tens[(int)($n / 10)] . ' ' . $words[$n % 10] . ' ';
            }

            $result .= $labels[$i] . ' ';
        }

        $result = trim($result);
        $final = 'Rupees ' . $result;

        if ($decimal > 0) {
            if ($decimal < 20) {
                $final .= ' and ' . $words[$decimal] . ' Paise';
            } else {
                $final .= ' and ' . $tens[(int)($decimal / 10)] . ' ' . $words[$decimal % 10] . ' Paise';
            }
        }

        return $final . ' Only';
    }
}
