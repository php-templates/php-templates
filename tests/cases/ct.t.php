<tpl is="cases2:comp/ct">
    {t 'Hi there1, ' . $role = 'admin'}
</tpl>
{t 'Hi there2, ' . $role = 'admin'}
=====
<div>
    cases2::Hi there, admin
    cases2::Hi there, admin. Cookies?
    ::Hi there1, admin
</div>
::Hi there2, admin