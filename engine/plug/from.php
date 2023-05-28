<?php

From::_('LESS', $less = static function (?string $content, $tidy = false): ?string {
    $less = new lessc;
    $less->setImportDir([]); // Disable `@import` rule
    $less->setFormatter($tidy ? 'classic' : 'compressed');
    $folder = __DIR__ . D . '..' . D . '..' . D . 'state';
    if ($function = (static function ($f) {
        extract($GLOBALS, EXTR_SKIP);
        return require $f;
    })($folder . D . 'function.php')) {
        foreach ((array) $function as $k => $v) {
            $less->registerFunction($k, $v);
        }
    }
    if ($variable = (static function ($f) {
        extract($GLOBALS, EXTR_SKIP);
        return require $f;
    })($folder . D . 'variable.php')) {
        $less->setVariables((array) $variable);
    }
    $content = $less->compile($content ?? "");
    return "" !== $content ? $content : null;
});

// Alias
From::_('less', $less);