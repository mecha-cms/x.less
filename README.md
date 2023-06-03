Less Extension for [Mecha](https://github.com/mecha-cms/mecha)
==============================================================

![Code Size](https://img.shields.io/github/languages/code-size/mecha-cms/x.less?color=%23444&style=for-the-badge)

Less (which stands for Leaner Style Sheets) is a backwards-compatible language extension for CSS. Because Less looks
just like CSS, learning it is a breeze. Less only makes a few convenient additions to the CSS language, which is one of
the reasons it can be learned so quickly.

This extension compiles Less code into CSS code by looking for files with extension `.less` added through the
`Asset::set()` method, storing the compiled results as static files and then displays them as CSS files. The compiled
file contents will be updated automatically on every file modification changes on the Less files.
