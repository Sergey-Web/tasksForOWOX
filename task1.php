<?php

function checkBrackets(string $s): bool {
    $brackets = [
        '(' => ')',
        '[' => ']',
        '{' => '}'
    ];

    preg_match_all('/\[|\]|\(|\)|\{|\}/', $s, $matches);
    $substring = implode('', $matches[0]);

    $prevLen = 0;
    $curLen = strlen($substring);

    $clearValidPair = function (&$string) use ($brackets, &$prevLen, &$curLen) {
        foreach ($brackets as $startBracket => $endBracket) {
            $string = str_replace($startBracket . $endBracket, '', $string);
        }
        $prevLen = $curLen;
        $curLen = strlen($string);
    };

    while ($curLen !== $prevLen) {
        $clearValidPair($substring);
    }

    return empty($substring);
}