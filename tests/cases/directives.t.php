{% $var = 0 %}

<input type="checkbox" p-checked="1>$var">
=====
<input type="checkbox" checked>

-----

<input type="checkbox" p-checked="1<$var">
=====
<input type="checkbox">