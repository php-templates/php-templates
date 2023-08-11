<tpl is="cases2:comp/ct">
    {t 'Hi there1, ' . $role = 'admin'}
</tpl>
{t 'Hi there2, ' . $role = 'admin'}
=====
<div>
    cases2::Hi there, admin
    cases2::Hi there, admin. Cookies?
    default::Hi there1, admin
</div>
default::Hi there2, admin

-----

<div class="{t 'Olla'}"></div>
=====
<div class="default::Olla"></div>