LESS Extension for Mecha
========================

> Convert LESS syntax into CSS syntax.

This extension will compile LESS code into CSS code by looking for files with `.less` extension that added to the asset storage by the `Asset::set()` method and then will store the results into static CSS files with the same name as the source name. Static CSS files will be updated automatically whenever the file modification time of each LESS file is changed:

~~~ .txt
path/to/file.less → path/to/file.css
path/to/less/file.less → path/to/css/file.css
~~~

### Usage

Dynamic loading:

~~~ .php
Asset::set('path/to/file.less');
~~~

Direct loading:

~~~ .php
echo Asset::less('path/to/file.less');
~~~