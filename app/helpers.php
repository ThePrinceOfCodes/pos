<?php

function format_money($money)
{
    if(!$money) {
        return "NGN0.00";
    }

    $money = number_format($money, 2);

    if(strpos($money, '-') !== false) {
        $formatted = explode('-', $money);
        return "-NGN$formatted[1]";
    }

    return "NGN$money";
}
