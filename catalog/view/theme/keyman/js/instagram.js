/*! jQuery Instagram - v0.3.1 - 2014-06-19
* http://potomak.github.com/jquery-instagram
* Copyright (c) 2014 Giovanni Cappellotto; Licensed MIT */
(function($) {

  function composeRequest(options) {
    var url = 'https://api.instagram.com/v1/users/3001150917';
    var data = {};

    if (options.accessToken == null && options.clientId == null) {
      throw 'You must provide an access token or a client id';
    }

    data = $.extend(data, {
      access_token: options.accessToken || '',
      client_id: options.clientId || '',
      count: options.count || ''
    });

    if (options.url != null) {
      url = options.url;
    }
    else if (options.hash != null) {
      url += '/media/recent';
    }
    else if (options.search != null) {
      url += '/media/search';
      data = $.extend(data, options.search);
    }
    else if (options.userId != null) {
      if (options.accessToken == null) {
        throw 'You must provide an access token';
      }
      url += '/users/' + options.userId + '/media/recent';
    }
    else if (options.location != null) {
      url += '/locations/' + options.location.id + '/media/recent';
      delete options.location.id;
      data = $.extend(data, options.location);
    }
    else {
      url += '/media/popular';
    }
    url+='?access_token='+options.accessToken;
    // console.log(url);
    return {url: url, data: data};
  }

  $.fn.instagram = function(options) {
    var that = this;
    options = $.extend({}, $.fn.instagram.defaults, options);
    var request = composeRequest(options);
// console.debug(request);
    $.ajax({
      dataType: "jsonp",
      url: request.url,
      data: request.data,
      success: function(response) {
        that.trigger('didLoadInstagram', response);
      }
    });

    this.trigger('willLoadInstagram', options);
    
    return this;
  };

  $.fn.instagram.defaults = {
    // accessToken: '3001150917.d98c433.7f69068644794b049a3218feb6b6e33e',
    // accessToken: '3001150917.d98c433.270488af82ac451d81d206200bb09bf3',
    // accessToken: '3001150917.1677ed0.5bb5ecbe85ff4354aa057af44c414a7f',
    // accessToken: '3001150917.1677ed0.7fb4a388f8144cbebb434342bf843add',
    // accessToken: '3001150917.1677ed0.ef6385a2ebee4a2f99a1d31cbeaa159e',
    // accessToken: '3001150917.d98c433.428b3d0eea0f4789ab4d7d68882bcd5d',
    // accessToken: '3001150917.1677ed0.7f425756d9ac47d9bac08ada0a2c652f',
    // accessToken: '3001150917.d98c433.16a15625da9e47a3ab8ba15bbf9fa6df',
    accessToken: '3001150917.d98c433.7b9f75eaa9464ac9afc9c7101e9f1a3a',
    clientId: 'd98c433ffe0c41b08ae11dab385d7efa',
    count: null,
    url: null,
    hash: null,
    userId: 'keymanby',
    location: null,
    search: null
  };

}(jQuery));
