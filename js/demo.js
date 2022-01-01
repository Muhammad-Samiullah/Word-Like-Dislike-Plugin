

jQuery('#text-input').on('input propertychange paste', function() {
jQuery.get(jQuery("#text-input").val(), function(data, status){
    alert("Data: " + data + "\nStatus: " + status);
  });
});







var oldVal = "";
jQuery("#textarea1").on("change keyup paste", function() {
    var currentVal = jQuery(this).val();
    if(currentVal == oldVal) {
        return; //check to prevent multiple simultaneous triggers
    }

    oldVal = currentVal;
CompleteFunction();
	
	
});


jQuery('input[type=checkbox]').change(function () {
CompleteFunction();
 });


function CompleteFunction(){

    var v = jQuery("#textarea1").val();
	v= v.replace(/[^a-zA-Z0-9]/g," ");
	v= v.replace(/\s\s+/g, ' ');
	v= v.toLowerCase();
	//console.log(v);
	
	var myArr = v.split(" ");

	if(v.length<1) {
	return;
	}



myArr.map(s => s.trim());
myArr.filter(s => s);


    jQuery("#result").html("");


    if(jQuery("#command1").prop('checked')) {
	myArr= myArr.sort();
	}
	
	
	if(jQuery("#command2").prop('checked')) {
	myArr= GetKeywords(myArr.join(" "));
	
	}
	
	if(jQuery("#command3").prop('checked')) {
	myArr= striker(myArr.join(" "));
	
	}
	
	
	
	if(jQuery("#command4").prop('checked')) {
	var uniqueNames = [];
	jQuery.each(myArr, function(i, el){
		if(jQuery.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
	});
	myArr = uniqueNames;
	}
	
	
	myArr.forEach(showResult);
	

	//$("#result").html(myArr.join(" "));

}







jQuery('body').on('click', '.btn-success', function() {
jQuery('#textarea3').val(jQuery('#textarea3').val() + jQuery(this).parent().text() + " \n"); 
});
jQuery('body').on('click', '.btn-danger', function() {
jQuery('#textarea4').val(jQuery('#textarea4').val() + jQuery(this).parent().text() + " \n"); 
});





function showResult(mArr){
	let userID = 1;
jQuery("#result").append(  "<div class='padd'><button type='button' data-word='"+mArr+"' class='btn btn-success' onclick='likeWord(this)'><i class='fa fa-thumbs-up' aria-hidden='true'></i></button> <button type='button' onclick='dislikeWord(this)' data-word='"+mArr+"' class='btn btn-danger'><i class='fa fa-thumbs-down' aria-hidden='true'></i></button> " + mArr + " </div>" );
}

function likeWord(element) {
	word = jQuery(element).attr("data-word");
	like_handler(word);
}

function dislikeWord(element) {
	word = jQuery(element).attr("data-word");
	dislike_handler(word);
}

function like_handler(word) {
	var action = 'like_handler';
    var form_data = {'word': word, 'action': action};
    jQuery(document).ready(function($) {
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
		    type:"POST",
		    dataType:'text',
		    data : form_data,
			success: function( response ) {
				console.log(response);
			},
			error: function( response ) {
				console.log(response);
			}
		});
	});
}

function dislike_handler(word) {
	var action = 'dislike_handler';
    var form_data = {'word': word, 'action': action};
    jQuery(document).ready(function($) {
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
		    type:"POST",
		    dataType:'text',
		    data : form_data,
			success: function( response ) {
				console.log(response);
			},
			error: function( response ) {
				console.log(response);
			}
		});
	});	
}


function striker(z){

var d = jQuery("#textarea2").val();
	d= d.replace(/[^a-zA-Z0-9]/g," ");
	d= d.replace(/\s\s+/g, ' ');
	d= d.toLowerCase();

var $hidder = d.split(" ");
var $original = z.split(" ");


for(m = 0; m<$original.length; m++){
if ($hidder.indexOf($original[m]) > -1){
$original[m] = "<span class='striker'>" + $original[m] + "</span>";
}
}

return $original; //.split();
}

function GetKeywords(s) {



var v = jQuery("#textarea2").val();
	v= v.replace(/[^a-zA-Z0-9]/g," ");
	v= v.replace(/\s\s+/g, ' ');
	v= v.toLowerCase();
	
var $commonWords = v.split(" ");
var $text = s;


var result = $text.split(' ');

// remove $commonWords
result = result.filter(function (word) {
    return $commonWords.indexOf(word) === -1;
});

result = result.filter(Boolean);


return result;
}


function getWordData() {
 	var action = 'data_getter_word_status';
    var form_data = {'action': action};
    jQuery(document).ready(function($) {
		$.ajax({
			url: frontend_ajax_object.ajaxurl,
		    type:"POST",
		    dataType:'text',
		    data : form_data,
			success: function( response ) {
				console.log(response);
			},
			error: function( response ) {
				console.log(response);
			}
		});
	});	
}

getWordData();

