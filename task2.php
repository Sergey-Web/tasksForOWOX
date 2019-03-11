function luckyTickets(int $k): false {
    if ($k & 1) {
        return false;
    }
    $numberDigitsTicket = \mb_strlen($k);
    $firstPartTicket = \mb_substr($k, 0, \mb_strlen($k)/2);
    $lastPartTicket = \mb_substr($k, \mb_strlen($k)/2);
    $sumFirstPart = \array_sum(\str_split($firstPartTicket, 1));
    $sumLastPart = \array_sum(\str_split($lastPartTicket, 1));

    return $sumFirstPart == $sumLastPart;
}
