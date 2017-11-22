var $ = jQuery;
var linksCategory = '<div class="category"><span icon="" class="fa fa-circle-thin" title="Change icon"></span><input class="cat" type="text" placeholder="Category Name"><span class="button add icon-plus" title="Add"></span><span class="button up icon-chevron-up" title="Move Up"></span></div>';
var linksLink = '<div class="link"><input class="name" type="text" placeholder="Link Name"><input class="href" type="text" placeholder="Link URL"><span class="button add icon-plus" title="Add"></span><span class="button up icon-chevron-up" title="Move Up"></span><span class="button poptoggle icon-new-tab on" title="Toggle: Popout to a New Tab"></span></div>';
var iconCat = {};
function updateLinks() {
	$('#links .wrap').html('<h3>Please wait...</h3><div class="center"><div class="icon-refresh"></div></div>');
	$.post('index.php?option=com_cpquicklinks&api', {'get':''}, function(data) {
		$('#links .wrap').html('');
		if($.isEmptyObject(data)) {
			data = {'':{'':''}};
		}
		$.each(data, function(cat) {
			var links = this.links;
			if($.isEmptyObject(links)) {
				links = {'':''};
			}
			var category = $(linksCategory);
			$(category).find('input.cat').val(cat);
			$(category).find('span.fa').attr('class', 'fa '+this.icon).attr('icon', this.icon);
			$('#links .wrap').append(category);
			$.each(links, function(name) {
				var link = $(linksLink);
				$(link).find('input.name').val(name);
				$(link).find('input.href').val(this['href']);
				if(!this['popout']) {
					$(link).find('.button.poptoggle').removeClass('on');
				}
				$(category).append(link);
			});
		});
	}, 'json');
}
$(document).ready(function() {
	$.getJSON('./components/com_cpquicklinks/src/fa.json', function(data) {
		$.each(data, function(icon_name) {
			$('<div class="fa '+icon_name+'">'+icon_name+'</div>').appendTo('#fashade .fawrap .icons');
		});
	});
	$('#links').on('click', '.category .fa', function() {
		iconCat = $(this).parent();
		$('#fashade').show().find('input').val('').trigger('keyup').focus();
	});
	$('body').mousedown(function() {
		$('#fashade').hide();
	});
	$('#fashade').mousedown(function(e) {
		if(!$(e.target).hasClass('fa')) {
			e.stopPropagation();
		} else {
			var icon = $(e.target).text();
			if(icon == '') {
				iconCat.find('.fa').attr('class', 'fa fa-circle-thin');
			} else {
				iconCat.find('.fa').attr('class', 'fa '+icon).attr('icon', icon);
			}
		}
	});
	$('#fashade input').keyup(function() {
		var filter = $(this).val();
		$('#fashade .icons .fa').each(function() {
			if($(this).text().includes(filter)) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});
	$('#toolbar-popup-preview .icon-preview').addClass('icon-eye');
	$('#links').on('click', '.link .button.up', function() {
		$(this).parent('.link').insertBefore($(this).parent('.link').prev('.link'));
	});
	$('#links').on('click', '.link .button.add', function() {
	   $(this).parent('.link').after(linksLink);
	});
	$('#links').on('click', '.link .button.poptoggle', function() {
	   $(this).toggleClass('on');
	});
	$('#links').on('click', '.category > .button.up', function() {
		$(this).parent('.category').insertBefore($(this).parent('.category').prev('.category'));
	});
	$('#links').on('click', '.category > .button.add', function() {
		$(this).parent('.category').after($(linksCategory).append(linksLink));
	});
	$('#toolbar .button-cancel').attr('onclick', null).click(function() {
		updateLinks();
	});
	$('#toolbar .button-apply').attr('onclick', null).click(function() {
		var saveButton = $(this);
		var linkData = {};
		saveButton.text('Saving...');
		$.each($('#links .category'), function() {
			var key = $(this).find('input.cat').val();
			linkData[key] = {};
			linkData[key]['icon'] = $(this).find('span.fa').attr('icon');
			linkData[key]['links'] = {};
			$.each($(this).find('.link'), function() {
				var linkName = $(this).find('input.name').val();
				linkData[key]['links'][linkName] = {};
				linkData[key]['links'][linkName]['href'] = $(this).find('input.href').val();
				if($(this).find('.button.poptoggle').hasClass('on')) {
					linkData[key]['links'][linkName]['popout'] = true;
				} else {
					linkData[key]['links'][linkName]['popout'] = false;
				}
			});
		});
		console.log(JSON.stringify(linkData));
		$.post('index.php?option=com_cpquicklinks&api', {'save':JSON.stringify(linkData)}, function(error) {
			if(error !== '') {
				saveButton.text('Save aborted.');
				alert(error);
			} else {
				saveButton.text('Saved!');
				updateLinks();
			}
			setTimeout(function() {
				saveButton.html('<span class="icon-apply icon-white" aria-hidden="true"></span> Save');
			}, 2000);
		});
	});
	updateLinks();
});