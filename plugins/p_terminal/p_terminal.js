function open_terminal(){
	$("#terminal_body").slideDown();
	$("#open_terminal").hide();
	$("#close_terminal").show();
}

function close_terminal(){
	$("#terminal_body").hide();
	$("#close_terminal").hide();
	$("#open_terminal").show();
}