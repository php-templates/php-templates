# php-templates

TODO:
<slot></slot> rezulta else gol pe fn declaration.. verifica la parsare pe insert slot clauza de else
<component>text slot</component> ar trebui sa verifice daca nodul e text si sa il parseze si treaca ca si string, nu sa creeze o noua fn inutila


nestLevel per parser instance ++ on accessing childnodes and reset on body reached

sa acopar urm cazuri:
1: comp x
<comp1>
  <comp2>
  html
<comp2>
html

2: slot
<comp>
  <comp2>
  html
  
3:comp recursivity
