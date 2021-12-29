# php-templates

php templates won't defend you against infinite recursions, yet


TODO:
block fara nume trb sa throw error

events vor fi de 2 tipuri: creating si rendering

creating cu acces la html5domdocument, mai exact la html5domdoc al elementului va permite queryselector si addChild new Parser(viewname)
rendering cu acces la this de componenta respectiva in momentul rendering pentru a putea face setData
preferabil ar fi ca event cb de rendering sa nu fie inreg pana nu e treaba cu ele

DomEvent::creating(viewName, function(html5domdocument $dom) {
    dom qs what, appendChild new parser parse(default true)
})

de modificat tag de <component> in <template>

de gasit o solutie pentru bind attrs mai elegant? prefix a- gen a-rows/:a-rows pare cel mai ok pana acum


de testat event-urile daca merg:
event-uri care sa fie globale pe o componenta, sau locale (in cazul in care o componenta se rendereaza intr-un anumnit scope)... va trebui sa aiba acces la numele scopului superior... o variabila ceva...