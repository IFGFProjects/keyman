function resizevideo() {
        // находим видео YouTube
        var $allVideosB = $(".video iframe"),
            // Элемент с плавающей шириной
            $fluidElB = $(".video");
        // Сохранение пропорций видео
        $allVideosB.each(function() {
                $(this)
                        .data('aspectRatio', this.height / this.width)
                        // удаление ширину и высоты из оригинального кода
                        .removeAttr('height')
                        .removeAttr('width');
        });
        // когда окно браузера изменяет размеры
        $(window).resize(function() {
                var newWidthB = $fluidElB.width();
                // изменение размеров видео с сохранением пропорций
                $allVideosB.each(function() {
                        var $el = $(this);
                        $el
                                .width(newWidthB)
                                .height(newWidthB * $el.data('aspectRatio'));
                });
                
        // фиксирование размеров и отображение видео
        }).resize();
} 

function centerCol() {
    var docw = $(document).width();
    if(docw >= 768) {
        $('.catagory-row').each(function(){
            var countCol = $(this).find('.catblock').length;
            if (countCol%3!=0) {
                if ((countCol+1)%3==0) {
                    $(this).find('.catblock').eq(countCol-2).addClass('col-md-offset-2');
                } else {
                    $(this).find('.catblock').eq(countCol-1).addClass('col-md-offset-4');
                }
            } 
        });
    } else {
        $('.catagory-row').each(function(){
            var countCol = $(this).find('.catblock').length;
            if (countCol%2!=0) {
               $(this).find('.catblock').eq(countCol-1).addClass('col-xs-offset-3 col-md-offset-0');
            } 
        });
    }
}

 function createPhotoElement(photo) {
    // console.log(low_resolution);
      var innerHtml = $('<img>')
        .addClass('instagram-image')
        .attr('src', photo.images.thumbnail.url);
        var title="";

        if (photo['caption']) {
            if(photo.caption['text']) {
                title = photo.caption['text'];
            }
        } 

      innerHtml = $('<a>')
        .attr('class', 'fancybox')
        .attr('data-href', photo.link)
        .attr('rel','insta-gallery')
        .attr('title',title)
        .attr('data-author',photo.user.username)
        .attr('data-authorname',photo.user.full_name)
        .attr('data-authorphoto',photo.user.profile_picture)
        .attr('href', photo.images.standard_resolution.url)
        .append(innerHtml);

    

      return $('<div>')
        .addClass('instagram-placeholder')
        .attr('id', photo.id)
        .append(innerHtml);

    }

    function didLoadInstagram(event, response) {
      var that = this;
      //console.log(response);
      $.each(response.data, function(i, photo) {
        $(that).append(createPhotoElement(photo));
      });

         $('.insta-block').owlCarousel({
            loop:true,
            
            nav:true,
            dots:false,
            navText:[" "," "],
            responsive:{
                0:{
                    items:3,
                    margin:2,
                },
                480:{
                    items:4,
                    margin:5,
                },
                768:{
                    items:6,
                    margin:8,
                },
                991:{
                    items:7,
                    margin:8,
                },
                1400:{
                    items:8,
                    margin:10,
                },
                1680:{
                    items:8,
                    margin:10,
                },
                1920:{
                    items:12,
                    margin:10,
                }

            }
        });
    }

function mobileTrigger(){
    $('.navbar-collapse').toggleClass('in');
    $('.navbar').toggleClass('mobile-offset');
    $('.ib1').toggleClass('onex');
    $('.ib2').toggleClass('twox');
    $('.ib3').toggleClass('fade');
    $('#navbar-toggle').toggleClass('mobile-body'); 
}

     $(document).mouseup(function (e){ // событие клика по веб-документу
        if ($('.navbar').hasClass('mobile-offset')) {
            var div = $(".navbar-mobile"); // тут указываем ID элемента
            var div2 = $('#navbar-toggle');
            if (!div2.is(e.target) && div2.has(e.target).length === 0) {
                if (!div.is(e.target) && div.has(e.target).length === 0) { // и не по его дочерним элементам
                    mobileTrigger();
                }
            }    
        }
    });
    

$(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
        $('#totop').fadeIn();
    } else {
        $('#totop').fadeOut(100);
    }
});


jQuery(document).ready(function($){

var isMobile = {
    Android:        function() { return navigator.userAgent.match(/Android/i) ? true : false; },
    BlackBerry:     function() { return navigator.userAgent.match(/BlackBerry/i) ? true : false; },
    iOS:            function() { return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false; },
    Windows:        function() { return navigator.userAgent.match(/IEMobile/i) ? true : false; },
    any:            function() { return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());  }
};

    $('#navbar-toggle').on('click',function(e) {
        mobileTrigger()
    }); 

    $('#product-gallery .thumbs').on('click', function (e) {
        $('#product-gallery .thumbs').removeClass('active');
        $(this).addClass('active');
        var src = $(this).attr('href');
        var href = $(this).data('image');
        $('#main-image').attr('src', src).attr('data-large',href).data('large',href).parent().attr('href', href);
        e.preventDefault();
    });
    
    $('#product-gallery .fancy').fancybox({
		beforeLoad: function() {
			var group = this.group;
			var href = this.href;
			if (group.length != 1) {return true;}
			$('#product-gallery .thumbs').each(function() {
				var elem = $(this);
				var elem_href = elem.data('image');
				if (elem_href != href) {
					group.push({
						element: elem
						,isDom: true
						,title: ''
						,type: 'image'
						,href: elem_href
					});
				}
			});
			this.group = group;
		}
	});

      $('#totop').on('click',function (e) {
            e.preventDefault();
            $('body,html').animate({
                scrollTop: 0
            }, 800);
        }); 


  
if ( !isMobile.any() ) {
    if($(".zoom-photo").length != 0) {
         $(".zoom-photo").imagezoomsl({
              zoomrange: [2, 6],
              scrollspeedanimate: 10,
              loopspeedanimate: 5,
              cursorshadeborder: "5px solid black",
              magnifiereffectanimate: "slideIn" 
          });
     }
    
}


    // TOPMENU JAM // 

    var $menu = $(".navbar");
    $(window).scroll(function(){
        if ( $(this).scrollTop() > 100 ){
            $menu.addClass("navfixed");
        } else if($(this).scrollTop() <= 100) {
            $menu.removeClass("navfixed");
        }
    });//scroll

    $('#bigversion').on('click',function(event){
        $.cookie('version', '1');
    });
    
    $('#delbigversion').on('click',function(event){
        $.removeCookie('version');
    });
    
    if($("select[name!='sort-amount']").length>0) { 
    $("select[name!='sort-amount']").selectBox(); 
    } 
    
    $('a[data-toggle="popover"]').on('click',function(event){
        event.preventDefault();
    }).popover();
    
    
    $('#total-categories a').on('mouseover',function(event){
        var img = $(this).data('img');
        if(img) {$('.img-categories').attr('src',img);} 
        if (!$(this).parent().hasClass('active')) {
            var target = $(this).data('target');
            if(target) {
                $(this).parent().addClass('active').siblings().removeClass('active');
                $(target).removeClass('hidden').siblings().addClass('hidden');
            }
            if($(this).closest('.high-categories').length) {
                $('.low-categories').addClass('hidden');
                $('.middle-categories').find('li').removeClass('active');
            }
        }
    });

    if($(window).width() < 480) {
        $('#middle-categories  a, a[data-target="#thematic"]').on('click',function(e){
            var target = $(this).data('target');
            var this_a = this;
            if(target) {
                if($(target+' a').length > 0){
                    e.preventDefault();
                    if($(this_a).parent().find(target+'-js').length==0) {
                        $(this_a).after('<ul class="js-submenu" style="display:none;" id="'+target.replace("#","")+'-js"></ul>');
                        $(target+' a').each(function(index){
                            var link_href = $(this).attr('href');
                            var link_title = $(this).html();
                            var add_class =$(this).attr("add-classes");
                            console.log("add_class: "+add_class);
                            console.log("link_href: "+link_href);
                            var app_link = '<li class="'+add_class+'"><a href="'+link_href+'">'+link_title+'</a></li>';
                            console.log(app_link);
                            $(target+'-js').append(app_link);
                        });
                        $(target+'-js').slideDown('500');

                    } else {
                        $(target+'-js').slideUp('500',function(){$(this).remove();});
                        window.location=$(this).attr("href");
                    }
                } 
            }
        });
        


    }


    // var $filter = $(".filter-results");
    // $(window).scroll(function(){
    //     if ( $(this).scrollTop() > 230 ){
    //         $filter.addClass("filterfixed");
    //     } else if($(this).scrollTop() <= 230 && $filter.hasClass("filterfixed")) {
    //         $filter.removeClass("filterfixed");
    //     }
    // });//scroll
    
    $('.minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });
    
    // $('.product-cart > a').tooltip();
    $('.fancybox').fancybox({
         helpers: {
            overlay: {
                locked: false
            }
        },
    });

    // $('.product-cart > a').on('shown.bs.tooltip',function(event){
    //     $(this).mousemove(function(e){
    //         var pos = $(this).offset();
    //         var Xouter = pos.left; // положения по оси X
    //         var Youter = pos.top; // положения по оси Y
    //         var X = e.pageX - Xouter;
    //         var Y = e.pageY - Youter;
    //        $('.tooltip').css({"top":Y+25,"left":X+12}); 
    //     });
    // });

    var owl = $('.about-slide');
    owl.owlCarousel({
        loop: true,
        items: 1,
        thumbs: true,
        thumbImage: true,
        thumbContainerClass: 'owl-thumbs',
        thumbItemClass: 'owl-thumb-item'
    });

    $('.criterion a').on('click',function(index){
        var target = ($(this).attr('href'));
        $('.filters .collapse').not(target).collapse('hide');
    });
    
    $('.slider').owlCarousel({
        autoplay: true,
        autoplayTimeout: 5000,
        loop:true,
        margin:10,
        nav:true,
        dots:false,
        items:1,
        navText:[" "," "],
    });
    $('.partners').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:false,
        navText:[" "," "],
        responsive:{
            0:{
                items:2,
            },
            480:{
                items:4,
            },
            768:{
                items:5,
            },
            992:{
                items:6,
            },
            1100:{
                items:7,
            },
            1300:{
                items:8,
            }
        }
    });

  $('.insta-block').on('didLoadInstagram', didLoadInstagram);
  $('.insta-block').instagram({
    hash: 'keymanby',
  });

    $(".insta-block .fancybox").fancybox({  
        openEffect: "elastic",
        closeEffect: "elastic",
        fitToVief:false,
        helpers: {
            overlay: {
                locked: false
            }
        },
        minWidth: 285,
        padding: 0,
        afterLoad: function() {
            var author = $(this.element).data('author');
            var authorPhoto = $(this.element).data('authorphoto');
            var authorName = $(this.element).data('authorname');  
            var linkPhoto =  $(this.element).data('href');
            this.title = '<div class="media instatitle"><a class="pull-left" href="'+linkPhoto+'"><img class="media-object" src="'+authorPhoto+'" alt="'+author+'"></a><div class="media-body"><a href="'+linkPhoto+'"><h4 class="media-heading"><b>'+author+'</b><br><span>'+authorName+'</span></h4></a>'+this.title+'</div></div>';
        },
        helpers:  {
            title : {
                type : 'inner'
            },
        },
    });
    resizevideo();
    centerCol();
    
    
    
});

$(window).resize(function(){
    centerCol();
});

$(function(){
    var wrapper = $( ".file_upload" ),
        inp = wrapper.find( "input" ),
        btn = wrapper.find( ".button" ),
        lbl = wrapper.find( "mark" );

    // Crutches for the :focus style:
    inp.focus(function(){
        wrapper.addClass( "focus" );
    }).blur(function(){
        wrapper.removeClass( "focus" );
    });

    var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

    inp.change(function(){
        var file_name;
        if( file_api && inp[ 0 ].files[ 0 ] )
            file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace( "C:\\fakepath\\", '' );

        if( ! file_name.length )
            return;

        if( lbl.is( ":visible" ) ){
            lbl.text( file_name );
            btn.text( "Выбрать" );
        }else
            btn.text( file_name );
    }).change();

});
$( window ).resize(function(){
    $( ".file_upload input" ).triggerHandler( "change" );
});


