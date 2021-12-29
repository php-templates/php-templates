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

block in block lease (indirect) nu are acces la slotur...
cam confuz modul in care se index...

make template with no is sa mearga ca un layer invisible, va crea un scope

<b><b11></b11><b12></b12><b121></b121><b122></b122><n><b1221></b1221><b1222></b1222></n></b><b21></b21>
<b><b11></b11><b12></b12><b121></b121><n><b1221></b1221></n><b122></b122></b><b21></b21>


<b><b11></b11><b12></b12><b121></b121><b122></b122><n><b1221></b1221><b1222></b1222></n></b><b21></b21>
<b><b11></b11><b12></b12><b121></b121><b122></b122><n><b1221></b1221></n></b><b21></b21>