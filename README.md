# php-templates

TODO:

later: fix bind attrs din Component render daca se poate


note: slot in slot va fi imposibil pt ca nu pot sti la ce nivel de nest pot fi, pot fi ascunse intr un component definit, iar atunci... nu am cum sti cine ii da slots

events vor fi de 2 tipuri: creating si rendering

creating cu acces la html5domdocument, mai exact la html5domdoc al elementului va permite queryselector si addChild new Parser(viewname)
rendering cu acces la this de componenta respectiva in momentul rendering pentru a putea face setData
preferabil ar fi ca event cb de rendering sa nu fie inreg pana nu e treaba cu ele

DomEvent::creating(viewName, function(html5domdocument $dom) {
    dom qs what, appendChild new parser parse(default true)
})

trimhtml se va face mereu pentru elementele care nu au content pe html