<?php

Asset::_('.less', function($value, $key, $attr) {
    extract($value);
    $state = Extend::state('less');
    $state_asset = Extend::state('asset');
    if ($path !== false) {
        $minify = !empty($state['less']['compress']);
        $path_css = str_replace([
            DS . 'less' . DS,
            DS . basename($path) . X,
            X
        ], [
            DS . 'css' . DS,
            DS . Path::N($path) . ($minify ? '.min' : "") . '.css',
            ""
        ], $path . X);
        $t_less = filemtime($path);
        $t_css = file_exists($path_css) ? filemtime($path_css) : 0;
        if ($t_less > $t_css) {
            $less = new Less_Parser($state['less']);
            $css = $less->parseFile($path)->getCss();
            if ($minify && Extend::exist('minify')) {
                $css = Minify::css($css); // Optimize where possible!
            }
            File::set($css)->saveTo($path_css);
        }
        return HTML::unite('link', false, extend($attr, [
            'href' => candy($state_asset['url'], [To::URL($path_css), $t_css ?: $_SERVER['REQUEST_TIME']]),
            'rel' => 'stylesheet'
        ]));
    }
    return '<!-- ' . $key . ' -->';
});