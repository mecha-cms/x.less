<?php

require __DIR__ . DS . 'lot' . DS . 'worker' . DS . 'less.php' . DS . 'Less.php';
require __DIR__ . DS . 'engine' . DS . 'plug' . DS . 'asset.union.php';

Hook::set('asset.top', function($content) {
    return $content . Hook::fire('asset.less', [Asset::less()]);
});