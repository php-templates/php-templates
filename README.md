# php-templates

TODO:

absolut toate componentele si sloturile si componentele din sloturi trebuie compilate in global scope, cu merge prioritar de la local scope (pe render)

nestLevel per parser instance ++ on accessing childnodes and reset on body reached

sa acopar urm cazuri:
1: comp x
2: slot
<comp>
  <comp2>
  html
  
3:comp recursivity