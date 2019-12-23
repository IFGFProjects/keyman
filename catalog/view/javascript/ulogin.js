if ( (typeof jQuery === 'undefined') && !window.jQuery ) {
	document.write(unescape("%3Cscript type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js'%3E%3C/script%3E%3Cscript type='text/javascript'%3EjQuery.noConflict();%3C/script%3E"));
} else {
	if((typeof jQuery === 'undefined') && window.jQuery) {
		jQuery = window.jQuery;
	} else if((typeof jQuery !== 'undefined') && !window.jQuery) {
		window.jQuery = jQuery;
	}
}


function getURLVar(key) {
	var value = [];
	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}


function uloginCallback(token){
	jQuery("body").css("cursor", "progress");
	jQuery.ajax({
		url: '/index.php?route=module/ulogin/login',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
			token: token,
			isAjax: true
		},
		success: function (response) {
			switch (response.type) {
				case 'error':
					uloginMessage(response.title, response.msg, response.type);
					break;
				case 'success':
					if (jQuery('.ulogin_profile').length > 0){
						adduLoginNetworkBlock(response.networks, response.title, response.msg);
					} else if (getURLVar('route') == 'account/logout') {
						location.replace('/index.php?route=account/account');
					} else {
						location.reload();
					}
					break;
			}

			if (response.script) {
				var token = response.script['token'],
					identity = response.script['identity'];
				if  (token && identity) {
					uLogin.mergeAccounts(token, identity);
				} else if (token) {
					uLogin.mergeAccounts(token);
				}
			}
		},
		error: function (error) {
			if (getURLVar('route') == 'account/logout') {
				location.replace('/index.php?route=account/account');
			} else {
				location.reload();
			}
		}
	});
}

function uloginMessage(title, msg, type) {
	if (title == '' && msg == '') { return; }
	var ulogin_messages_box = jQuery('#ulogin-message-box');
	if (ulogin_messages_box.length == 0) { return; }

	var mess = (title != '') ? '<strong>' + title + '</strong><br/>' : '';
	mess += (msg != '') ? msg : '';

	var class_msg = '.ulogin-message-';
	if (type == 'success') {
		class_msg += 'success';
	} else {
		class_msg += 'warning';
	}

	var alert = ulogin_messages_box.find(class_msg);
	alert.find('.ulogin-message').html(mess);
	alert.show();

	setTimeout(function () {
		alert.hide();
	}, 5000);
}

function uloginDeleteAccount(network){
	jQuery.ajax({
		url: '/index.php?route=module/ulogin/delete',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
			network: network,
			isAjax: true
		},
		error: function (data, textStatus, errorThrown) {
			alert('Не удалось выполнить запрос');
		},
		success: function (data) {
			switch (data.type) {
				case 'error':
					uloginMessage(data.title, data.msg, 'error');
					break;
				case 'success':
					var accounts = jQuery('.ulogin_accounts'),
						nw = accounts.find('[data-ulogin-network='+network+']');
					if (nw.length > 0) nw.hide();

					if (accounts.find('.ulogin_provider:visible').length == 0) {
						var delete_accounts = jQuery('.ulogin_profile').find('.delete_accounts');
						if (delete_accounts.length > 0) delete_accounts.hide();
					}

					uloginMessage(data.title, data.msg, 'success');
					break;
			}
		}
	});
}


function adduLoginNetworkBlock(networks, title, msg) {
	var uAccounts = jQuery('.ulogin_accounts');

	uAccounts.each(function(){
		for (var uid in networks) {
			var network = networks[uid],
				uNetwork = jQuery(this).find('[data-ulogin-network='+network+']');

			if (uNetwork.length == 0) {
				var onclick = '';
				if (jQuery(this).hasClass('can_delete')) {
					onclick = ' onclick="uloginDeleteAccount(\'' + network + '\')"';
				}
				jQuery(this).append(
					'<div data-ulogin-network="' + network + '" class="ulogin_provider big_provider ' + network + '_big"' + onclick + '></div>'
				);
				uloginMessage(title, msg, 'success');
			} else {
				if (uNetwork.is(':hidden')) {
					uloginMessage(title, msg, 'success');
				}
				uNetwork.show();
			}
		}

		var delete_accounts = jQuery('.ulogin_profile').find('.delete_accounts');
		if (delete_accounts.length > 0) delete_accounts.show();

	});
}