# php-templates

php templates won't defend you against infinite recursions, yet


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

addSlot va pastra referinta catre Parent, functia e binduita cu this de Parsed, iar sloturile nested sunt preluate folosind this parent ... 
facem asa
cand vine primul comp, incepem calatoria:
facem new parser parse cu nest++:
la primul e cu nest 0
pentru fiecare slotnode, new Parser, deep trecut in constructir
in aceat moment, 
de fiecare data cand intalnesc un comp slot direct al unei comp, deep devine 0+1
de fiecare data cand intalnesc un nod normal ca slot al unui component, deep se reseteaza la 0

trb ca parse sa aiba si un cbf extern...