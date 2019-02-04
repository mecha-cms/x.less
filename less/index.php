<?php

require __DIR__ . DS . 'lot' . DS . 'worker' . DS . '@less' . DS . 'Less.php';
require __DIR__ . DS . 'engine' . DS . 'plug' . DS . 'asset.php';

Hook::set('asset:head', function($content) {
    return $content . Hook::fire('asset.less', [Asset::less()], null, Asset::class);
});

// Add `less` to the allowed file extension(s)
File::$config['x'][] = 'less';