<?php

From::_('LESS', $fn = function(string $in, $minify = false) {
    $less = new lessc;
    $less->importDisabled = true; // Disable `@import` rule
    $less->setFormatter($minify ? 'compressed' : 'classic');
    if ($function = extension('less:function')) {
        foreach ((array) $function as $k => $v) {
            $less->registerFunction($k, $v);
        }
    }
    if ($variable = extension('less:variable')) {
        $less->setVariables((array) $variable);
    }
    $out = $less->compile($in);
    return $minify && extension('minify') !== null ? Minify::CSS($out) : $out;
});

// Alias(es)
From::_('less', $fn);