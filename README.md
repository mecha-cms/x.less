Less Extension for [Mecha](https://github.com/mecha-cms/mecha)
==============================================================

![Code Size](https://img.shields.io/github/languages/code-size/mecha-cms/x.less?color=%23444&style=for-the-badge)

This extension compiles LESS code into CSS code by looking for files with extension `.less` added through the `Asset::set()` method, storing the compiled results as static files and then displays them as CSS files. The compiled file contents will be updated automatically on every file modification changes on the LESS files.

---

Release Notes
-------------

### 2.7.0

 - **PS:** The LESS library has been updated manually to remove `$foo{$bar}` sequence into `$foo[$bar]` to remove the PHP deprecation warning. The project seems abandoned since 2018.
 - Moved `vendor` folder to the extension root.
 - [@mecha-cms/mecha#96](https://github.com/mecha-cms/mecha/issues/96)

### 2.6.0

 - Updated LESS library to `0.5.0`.
 - **TODO:** Add `To::LESS()` method.
 - Removed `mecha-cms/extend.plugin.less` repository. Art direction with LESS syntax is available by default.