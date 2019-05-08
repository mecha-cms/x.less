<?php

require __DIR__ . DS . 'engine' . DS . 'i' . DS . '@less' . DS . 'less.inc.php';

require __DIR__ . DS . 'engine' . DS . 'plug' . DS . 'asset.php';
require __DIR__ . DS . 'engine' . DS . 'plug' . DS . 'from.php';

Hook::set('asset:head', function($content) {
    return $content . Hook::fire('asset.less', [Asset::join('less')], null, Asset::class); // Append
});

// Add `less` to the allowed file extension(s)
File::$config['x'][] = 'less';