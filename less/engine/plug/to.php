<?php

To::_('LESS', $fn = function($in/* , $minify = false */) {
    $less = new lessify;
    $d = __DIR__ . DS . '..' . DS . '..' . DS . 'state';
    if ($function = (function($f) {
        extract($GLOBALS, EXTR_SKIP);
        return require $f;
    })($d . DS . 'function.php')) {
        foreach ((array) $function as $k => $v) {
            $less->registerFunction($k, $v);
        }
    }
    if ($variable = (function($f) {
        extract($GLOBALS, EXTR_SKIP);
        return require $f;
    })($d . DS . 'variable.php')) {
        $less->setVariables((array) $variable);
    }
    return $less->parse($in);
});

// Alias(es)
To::_('less', $fn);
