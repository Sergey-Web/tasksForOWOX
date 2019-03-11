function checkBrackets(string $s): bool {
    $parenthesis = [')' => '(', ']' => '[', '}' => '{'];
    $parenthesisClose = \array_keys($parenthesis);
    $pattern = '/\[|\]|\(|\)|\{|\}/'; 
    \preg_match_all($pattern, $s, $matches);
    $res = [];
    foreach ($matches[0] as $v) {
        if (\array_search($v, $parenthesisClose) === false) {
            array_push($res, $v);
            continue;
        }

        if (empty($res)) {
            $res[] = $v;
            break;
        }

        if (\end($res) === $parenthesis[$v]) {
            \array_pop($res);    
        } else {
            break;
        }

    }

    return !empty($res) ? false : true;
}
