<!-- <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="search"  id="search" >
        <div class="input-group">
           <input type="text" name="search" class="form-control" placeholder="<?php echo $text_search; ?>"  value="<?php echo $search; ?>">
           <span class="input-group-btn">
             <button class="btn" type="button"><img src="catalog/view/theme/keyman/image/icon-search.png" alt="<?php echo $text_search; ?>"></button>
           </span>
         </div>
     </div>
</div> -->

<div class="col-md-3 col-sm-6 col-xs-12">
     <div class="search hidden-xs">
       <form action="<?php echo $search_link; ?>" method="get">
            <div class="input-group">
               <input type="hidden" name="route" value="product/search">
               <input type="text" name="search" class="form-control" placeholder="Поиск" value="<?php echo $search; ?>">
               <span class="input-group-btn">
                 <button class="btn" type="submit"><img src="catalog/view/theme/keyman/image/icon-search.png" alt="<?php echo $text_search; ?>"></button>
               </span>
             </div>
         </form>
     </div>
</div>