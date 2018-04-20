# PHP-paginator-class
Put the class into your included source code. Then use it by:
    $p = new paginator(YOUR SQL QUERY, ROWS PER PAGE);
    e.g.: $p = new paginator("SELECT id FROM user WHERE 1", 10);
    
Get the query data by using:
    $array = $p->getList();

Show the links of pages by using:
    $p->showPages();
it will show all the pages through html tags.

The default element count of showing the pages' links is 5, 
you can customize it by changing the value of '$element' in side the class.
