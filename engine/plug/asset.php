<?php namespace x\less;

function files(string $path): array {
    if (!\is_file($path)) {
        return [];
    }
    $out = [$path];
    foreach (\stream($path) as $v) {
        $r = '/@import\s+(?:([\'"])([^\'"\s]+)\1|url\(([\'"]?)([^\n]+)\1\))/';
        if (false !== \strpos($v, '@import') && \preg_match_all($r, $v, $m)) {
            foreach ($m[2] as $vv) {
                if (
                    false !== \strpos($vv, '://') ||
                    0 === \strpos($vv, '//') ||
                    '.css' === \substr($vv, -4)
                ) {
                    // Ignore external file(s) and native CSS file(s)
                    continue;
                }
                $vv = \dirname($path) . \DS . \strtr($vv, '/', \DS);
                if (\is_file($vv) || \is_file($vv .= '.less')) {
                    $out = \array_merge($out, files($vv)); // Recurse…
                }
            }
        }
    }
    return $out;
}

\Asset::_('.less', function($value, $key) {
    $data = $value[2];
    $path = $value['path'];
    $stack = $value['stack'];
    $url = $value['url'];
    $x = false !== \strpos($url, '://') || 0 === \strpos($url, '//');
    if (!$path && !$x) {
        return '<!-- ' . $key . ' -->';
    }
    $f = \str_replace([
        \DS . 'less' . \DS,
        \DS . \basename($path) . \P,
        \P
    ], [
        \DS . 'css' . \DS,
        \DS . \basename($path, '.less') . '.css',
        ""
    ], $path . \P);
    $ff = \substr($f, 0, -4) . '.min.css';
    if (!\is_dir($d = \dirname($f))) {
        \mkdir($d, 0777, true);
    }
    $update = 0;
    foreach (files($path) as $v) {
        $v = \filemtime($v);
        $update < $v && ($update = $v);
    }
    if (
        !\is_file($f) || $update > \filemtime($f) ||
        !\is_file($ff) || $update > \filemtime($ff)
    ) {
        $less = new \lessc;
        $less->setImportDir([\dirname($path)]);
        $d = __DIR__ . \DS . '..' . \DS . '..' . \DS . 'state';
        if ($function = (static function($f) {
            extract($GLOBALS, \EXTR_SKIP);
            return require $f;
        })($d . \DS . 'function.php')) {
            foreach ((array) $function as $k => $v) {
                $less->registerFunction($k, $v);
            }
        }
        if ($variable = (static function($f) {
            extract($GLOBALS, \EXTR_SKIP);
            return require $f;
        })($d . \DS . 'variable.php')) {
            $less->setVariables((array) $variable);
        }
        $content = \file_get_contents($path);
        $less->setFormatter('classic');
        $less->setPreserveComments(true);
        $css = $less->compile($content);
        \file_put_contents($f, $css);
        \chmod($f, 0777);
        $less->setFormatter('compressed');
        $less->setPreserveComments(false);
        $css = $less->compile($content);
        \file_put_contents($ff, $css);
        \chmod($f, 0777);
    }
    return static::set($ff, $stack, $data);
});