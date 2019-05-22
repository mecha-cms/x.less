<?php namespace _\less;

function files(string $path): array {
    if (!\is_file($path)) {
        return [false, []];
    }
    $out = [$path];
    $content = \file_get_contents($path);
    $r = '#@import\s+(?:([\'"])([^"\'\s]+)\1|url\(([\'"]?)([^\n]+)\1\))#';
    if (\strpos($content, '@import') !== false && \preg_match_all($r, $content, $m)) {
        foreach ($m[2] as $v) {
            // Ignore external file(s) and native CSS file(s)
            if (
                \strpos($v, '://') !== false ||
                \strpos($v, '//') === 0 ||
                \substr($v, -4) === '.css'
            ) {
                continue;
            }
            $v = \dirname($path) . DS . \strtr($v, '/', DS);
            if (\is_file($v) || \is_file($v .= '.less')) {
                $out = \concat($out, files($v)[1]); // Recurse…
            }
        }
    }
    return [$content, $out];
}

\Asset::_('.less', function($value, $key) {
    extract($value, \EXTR_SKIP);
    $state = \extend('asset');
    if (isset($path)) {
        $less = new \lessc;
        $less->setFormatter('compressed');
        $less->setImportDir([dirname($path)]);
        if ($function = \extend('less:function')) {
            foreach ((array) $function as $k => $v) {
                $less->registerFunction($k, $v);
            }
        }
        if ($variable = \extend('less:variable')) {
            $less->setVariables((array) $variable);
        }
        $result = str_replace([
            DS . 'less' . DS,
            DS . \basename($path) . P,
            P
        ], [
            DS . 'css' . DS,
            DS . \Path::N($path) . '.min.css',
            ""
        ], $path . P);
        $t = 0;
        $files = files($path);
        foreach ($files[1] as $v) {
            $v = \filemtime($v);
            $t < $v && ($t = $v);
        }
        if (!\is_file($result) || $t > \filemtime($result)) {
            $css = $less->compile($files[0]);
            // Optimize where possible
            if (\extend('minify') !== null) {
                $css = \Minify::CSS($css);
            }
            \File::set($css)->saveTo($result);
        }
        return new \HTML(['link', false, \alter($data, [
            'href' => \To::URL($result) . '?v=' . ($t ?: $_SERVER['REQUEST_TIME']),
            'rel' => 'stylesheet'
        ])]);
    }
    return '<!-- ' . $key . ' -->';
});