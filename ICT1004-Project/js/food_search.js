  $(document).ready(function()
  {  
       $('#search_food_posts').keyup(function()
       {  
            search_table($(this).val());  
       });  
       function search_table(value)
       {  
            $('#food_posts').each(function()
            {  
                 var found = 'false';  
                 $(this).each(function()
                 {  
                      if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
                      {  
                           found = 'true';  
                      }  
                 });  
                 if(found == 'true')  
                 {  
                      $(this).show();  
                 }  
                 else  
                 {  
                      $(this).hide();  
                 }  
            });  
       }  
  });  