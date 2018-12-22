<?php

Asset::_('.less', function($value, $key, $attr) use($url) {
    extract($value);
    $state_asset = Extend::state('asset');
    if ($path !== false) {
        $path_css = str_replace([
            DS . 'less' . DS,
            DS . basename($path) . X,
            X
        ], [
            DS . 'css' . DS,
            DS . Path::N($path) . '.min.css',
            ""
        ], $path . X);
        $directory = CACHE . DS . '@less';
        $cache = $directory . DS . Less_Cache::Get([$path => $url . '/'], [
            'prefix' => 'less-',
            'prefix_vars' => 'less-var-',
            'cache_dir' => $directory,
            'cache_method' => 'php',
            'compress' => true
        ]);
        $t = filemtime($cache);
        if (!file_exists($path_css) || $t > filemtime($path_css)) {
            $css = file_get_contents($cache);
            // Optimize where possible
            if (Extend::exist('minify')) {
                $css = Minify::css($css);
            }
            File::put($css)->saveTo($path_css);
        }
        return HTML::unite('link', false, extend($attr, [
            'href' => candy($state_asset['url'], [To::URL($path_css), $t ?: $_SERVER['REQUEST_TIME']]),
            'rel' => 'stylesheet'
        ]));
    }
    return '<!-- ' . $key . ' -->';
});