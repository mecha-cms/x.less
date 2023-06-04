<?php

namespace x\less {
    function asset() {
        // Output is not required in this case, just trigger the asset(s)
        \class_exists("\\Asset") && \Asset::join('*.less');
    }
    // Make sure to run this hook before `head`
    \Hook::set('content', __NAMESPACE__ . "\\asset", -1);
}

namespace {
    require __DIR__ . \D . 'engine' . \D . 'vendor' . \D . 'autoload.php';
    if (\defined("\\TEST") && 'x.less' === \TEST) {
        \Asset::set(__DIR__ . \D . 'test.less', 20);
    }
}