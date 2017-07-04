$(document).ready(function(){
	var search = document.getElementById('page-search');
	var search_box = document.getElementById('search-top');
	var content = document.getElementById('page-body');
	var search_list = document.getElementById('product-list');
	var cancle_btn = document.querySelector('.search-cancle');
	var search_title = document.getElementById('search-title');
	search.onclick = function(){
		search_box.style.display = 'block';
		content.style.display = 'none';
		search_title.style.display = 'none';
       $('.index_foot').hide();
        search_list.style.display = 'block';
	}
	cancle_btn.onclick = function(){
        $('.index_foot').show();
		search_box.style.display = 'none';
		content.style.display = 'block';
		search_list.style.display = 'none';
		search_title.style.display = 'block';
        search_list.innerHTML ='';
        $('#input-search').val('');
	}
})