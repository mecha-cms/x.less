<?php

From::_('LESS', $fn = function(string $in, $minify = false) {
    $less = new lessc;
    $less->importDisabled = true; // Disable `@import` rule
    $less->setFormatter($minify ? 'compressed' : 'classic');
    if ($function = Extend::state('less:function')) {
        foreach ((array) $function as $k => $v) {
            $less->registerFunction($k, $v);
        }
    }
    if ($variable = Extend::state('less:variable')) {
        $less->setVariables((array) $variable);
    }
    $out = $less->compile($in);
    return $minify && Extend::exist('minify') ? Minify::CSS($out) : $out;
});

// Alias(es)
From::_('less', $fn);