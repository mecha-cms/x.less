LESS Extension for [Mecha](https://github.com/mecha-cms/mecha)
==============================================================

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
