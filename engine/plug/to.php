<?php

To::_('LESS', $less = static function (?string $content, $tidy = false): ?string {
    $less = new lessify;
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
    $content = $less->parse($content);
    return "" !== $content ? $content : null;
});

// Alias
To::_('less', $less);