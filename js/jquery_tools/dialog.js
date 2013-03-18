$(document).ready(function() {
	var triggers = $(".modalInput").overlay({
	mask: {
		color: '#000',
		loadSpeed: 200,
		opacity: 0.8
	},
	closeOnClick: false
	});

	
	var theframe = $('<iframe frameborder="0" scrolling="auto"></iframe>');	
	$("a[rel]").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.8
		},
		closeOnClick: false,
		onBeforeLoad: function() {

			// grab wrapper element inside content
			var wrap = this.getOverlay().find(".contentWrap");
			
			// load the page specified in the trigger
			//wrap.load(this.getTrigger().attr("href"));
			
			var link = this.getTrigger().attr("href");
			var style = this.getTrigger().attr("rev");
			$(theframe).attr({ src: link, style: 'width:700px;' });
			wrap.html(theframe);
		},
		onClose: function() {
			$(theframe).attr({ src: 'about:blank' });
		}
	});
});