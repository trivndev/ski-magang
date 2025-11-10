<?php

if (!function_exists('number_shorten')) {
    function number_shorten($number, $precision = 2)
    {
        if ($number < 1000) {
            return number_format($number, 0, ',', '.');
        }

        $suffixes = ['', 'K', 'M', 'B', 'T'];
        $suffixIndex = floor((strlen((int)$number) - 1) / 3);
        $shortNumber = $number / pow(1000, $suffixIndex);

        $formatted = number_format($shortNumber, $precision, ',', '.');

        $formatted = preg_replace('/,?0+$/', '', $formatted);

        return $formatted . $suffixes[$suffixIndex];
    }
}
