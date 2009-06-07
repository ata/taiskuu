document.observe('dom:loaded',function(){
    $$('table.data tr:nth-child(even)').each(function(e){
        e.addClassName('even');
    });
   
});
