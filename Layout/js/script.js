$(document).ready(function() {

	"use strict";
	
	// SideBar
	$('#category-menu').click(function() {
		$('.ui.sidebar').sidebar('toggle');
	});

	// semantic modal sign in
	$('#signin-modal').click(function () {
		$('.small.modal.sign-in-modal').modal('show');
	});
	// semantic modal sign up
	$('#regest-modal').click(function () {
		$('.ui.modal.sign-up-modal').modal('show');
	});

	// Accourdion
	$('.ui.accordion').accordion();

	// hover dropdown
	$('.dropdown-btn').mouseenter(function (){
		$('.sub-menu').css('display','block');
	});
	$('.dropdown-btn').mouseleave(function (){
		$('.sub-menu').css('display','none');
	});
	
	// HEADER owl carousel
	$('.header-carousel').owlCarousel({
	    rtl:false,
	    loop:true,
	    margin:0,
	    nav:false,
		autoplay:true,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:1
	        }
	    }
	});

	// OFFERS owl carousel
	$('.offers-carousel').owlCarousel({
	    rtl:false,
	    loop:true,
	    margin:11,
	    nav:false,
		autoplay:true,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:4
	        }
	    }
	});

	//most recent carousel
	$('.most-recent-carousel').owlCarousel({
	    rtl:false,
	    loop:true,
	    margin:11,
	    nav:false,
		autoplay:true,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:4
	        }
	    }
	});
	
	//Triger MixIT Up
	
	$('#Container').mixItUp(); 
	
	// add class selected
	
	$(".row .ul li").click(function() {
		$(this).addClass("selected").siblings().removeClass('selected');
	});

	$(".confirm").click(function() {
		return confirm('are you sure you want to do this process');
	});

	// start trigger the select box it
	function user_info(str/*some thing will send here*/) {
	    if (str.length == 0) {
	        document.getElementById("txtHint").innerHTML = "";
	        return;
	    } else {
	        var xmlhttp = new XMLHttpRequest();
		
		
        	xmlhttp.onreadystatechange = function() {	
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }	//the way to request		//if page can make any thing to it during the function [true] or not[false]
	        xmlhttp.open("GET", "getSubCat.php?q=1", true);
	        xmlhttp.send();
    	}	
	}
	//end trigger the select box it

 });
