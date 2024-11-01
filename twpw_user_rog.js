
(function($){
	function sortNumber(a,b) {
		return a - b;
	}
			
	function equalHeight(strElementsToHeight) {
		var heights = new Array();
		$(strElementsToHeight).each(function(){
			$(this).css('height', 'auto');
			heights.push($(this).height());
		});        
		heights = heights.sort(sortNumber).reverse();
		$(strElementsToHeight).each(function(){
			$(this).css('height', heights[0]);
		});        
	}

	function maxHeight(strElementsToHeight) {
		var heights = new Array();
		$(strElementsToHeight).each(function(){
			$(this).css('height', 'auto');
			heights.push($(this).height());
		});        
		heights = heights.sort(sortNumber).reverse();
		$(strElementsToHeight).each(function(){
			$(this).css('min-height', heights[0]);
		});        
	}
	$(document).ready(function() {
		$('.tabs').tabs();
		
		
		//equalHeight('#tabs ul li');
		maxHeight('.twpw_rog_coloum');
	});
})(jQuery)
