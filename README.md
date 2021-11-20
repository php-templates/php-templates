# php-templates

TODO:

later: fix bind attrs din Component render daca se poate
note: slot in slot va fi imposibil
renunt la switches si salvez comp doar cu numele request pentru a putea avea events pt setData
functiile vor fi salvate ca si componente(obj) cu setadata si getdata

events vor fi de 2 tipuri: creating si rendering
creating cu acces la html5domdocument, mai exact la html5domdoc al elementului va permite queryselector si addChild new Parser(viewname)
rendering cu acces la this de componenta respectiva in momentul rendering pentru a putea face setData
preferabil ar fi ca event cb de rendering sa nu fie inreg pana nu e treaba cu ele

DomEvent::creating(viewName, function(html5domdocument $dom) {
    dom qs what, appendChild new parser parse(default true)
})
