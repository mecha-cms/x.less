<?php

// Automatically generate `css.data` file from `less.data` file
namespace _\lot\x\art {
    function less($content) {
        if (!$path = $this->path) {
            return $content;
        }
        $update = 0;
        $d = \Path::F($path);
        if (\is_file($f = $d . \DS . 'less.data')) {
            $update = \filemtime($f);
        } else {
            $update = \filemtime($path);
        }
        $ff = $d . \DS . 'css.data';
        if (!\is_file($ff) || $update > \filemtime($ff)) {
            if ($out = $this->less) {
                $out = \From::LESS($out);
                if (!\is_dir($d)) {
                    \mkdir($d, 0775, true);
                }
                \file_put_contents($ff, $out);
                return $out;
            }
        }
        return $content;
    }
    \Hook::set('page.css', __NAMESPACE__ . "\\less", 0);
}

namespace _\lot\x {
    function less() {
        // No output needed, just trigger the asset(s)
        \Asset::join('.less');
    }
    // Make sure to run before `asset:head`
    \Hook::set('content', __NAMESPACE__ . "\\less", -1);
}
