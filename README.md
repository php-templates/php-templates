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

de testat foreach pe:
 componenta
 componenta slot
 slot propriu zis

de asigurat ca daca cineva incearca sa bage slot in slot nu se intampla ceva ciudat

de modificat tag de <component> in <template>

de gasit o solutie pentru bind attrs mai elegant? prefix a- gen a-rows/:a-rows pare cel mai ok pana acum

!!!blocks!!! un fel se sloturi, completate prin addSlot, dar care nu arunca childnodes, in schimb fac parse pentru fiecare in parte, vor avea un sortorder dupa care sunt filtrate inainte de render
pentru a fi viabile, trb sa am slot in slot posibil
fac ++ si -- pe fiecare parsare si tin un map
file
 <comp>
  comp2
   bind

comp2
 comp3
  slot

comp3 ia slots de la comp2

function comp() {
    comp2->render()
}

function comp2() {
    comp3->addSlot(this slot)
    comp3->render()
}