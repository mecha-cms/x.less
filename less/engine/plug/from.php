<?php

From::_('LESS', $fn = function(string $in, $minify = false) {
    $less = new lessc;
    $less->setImportDir([]); // Disable `@import` rule
    $less->setFormatter($minify ? 'compressed' : 'classic');
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
    return $less->compile($in);
});

// Alias(es)
From::_('less', $fn);
