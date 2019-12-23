
$(document).ready(function(){
  set_events();
});

function hfilter(new_href)
{
  console.log("["+new_href+"]");
  if ( (new_href!="") )
  {
    if ((typeof(new_href) != "undefined"))
      {new_href=new_href.replace("&amp;",'&');}
    $("#filter_form").attr("action",new_href);
  }
  var in_stock = $("input[name='in_stock']").prop('checked');
  var form_data = $('#filter_form').serializeArray();

  if(in_stock){
    form_data.push({name: 'in_stock', value: 'on'});
  } else{
    form_data.push({name: 'in_stock', value: 'off'});
  }

  $.post(
    $("#filter_form").attr("action"),
    form_data,
    function(data) 
    {
      // $(".products").html($(data).find(".products").html());
      $(".ajax_products_wrap").html($(data).find(".ajax_products_wrap").html());
      $(".filter-results").html($(data).find(".filter-results").html());
      $(".sort").html($(data).find(".sort").html());
      $(".pagination").html("");
      $(".pagination").html($(data).find(".pagination").html());
      $(".filterblock").html($(data).find(".filterblock").html());
      $("#filter_form").attr("action",$(data).find("#filter_form").attr("action"));
      $(".category-description").html("");
      set_events();
      set_sorts();

      window.inProgress=false;
      window.page_number=1;
    }
  );
  $('body,html').animate({
                  scrollTop: 0
              }, 800);
}


function set_events()
{
  //--------------  SORTS ----------------
    $(".sort a").removeClass("active").on("click",function(e){  
      e.preventDefault();
      hfilter($(this).attr("href") );
      $(document).ready();
    });

  //--------------  IN STOCK ----------------
    $("input[name='in_stock']").on("click",function(e){  
      e.preventDefault();
      hfilter('');
      $(document).ready();
    });

  //--------------  PAGINATION ----------------
    $(".pagination a").on("click",function(e){  
      e.preventDefault();
      hfilter($(this).attr("href") );
      $(document).ready();
    });

  //---------------- LIMITS ---------------

    $("[name=sort-amount]").change(function(e){  
      e.preventDefault();
      hfilter($("[name=sort-amount]").val());
      $(document).ready();
    });

  //---------------- FILTER BUTTON ---------------

    $(".filter-button").on("click",function(e){  
      e.preventDefault();
      if ($(this).attr("id")!="price_button")
      {
        $('#filter-price').data('ionRangeSlider').update({from:$("#filter-price").data("ionRangeSlider").options.min, to:$("#filter-price").data("ionRangeSlider").options.max});        
        $(".criterion input").removeAttr("checked");
      }

      if ($(this).attr("id")!="clear_button")
      {
        // $('#filter-price').data('ionRangeSlider').update({from:$("#filter-price").data("ionRangeSlider").options.min, to:$("#filter-price").data("ionRangeSlider").options.max});
        // $("#filter_form").find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $(".criterion input").removeAttr("checked");
        $("#attributes_gag").prop("checked",true);
        hfilter(window.this_link);
        $(document).ready();
        if ($(this).attr('data-tags')=="true")
        {
        if (window.location.origin+window.location.pathname!=window.this_link)
          {window.location.href=window.this_link;}
        }
      }
      
    });

    $(".tag_type_filter").on("click",function(e){  
      e.preventDefault();
    });

    // $(".filter-button").on("click",function(e){  
    //   e.preventDefault();
    //   $(".criterion input").removeAttr("checked");
    //   hfilter();
    //   $(document).ready();
    // });
}