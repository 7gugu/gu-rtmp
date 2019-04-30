function alert_success(content){
	$("#alert").html("<div class=\"am-alert am-alert-success\" data-am-alert><button type=\"button\" class=\"am-close\">&times;</button><p><span class=\"am-icon-fw am-icon-check\" aria-hidden=\"true\"></span> "+content+"</p></div>");
}
function alert_info(content){
	$("#alert").html("<div class=\"am-alert am-alert-info\" role=\"alert\" data-am-alert><button type=\"button\" class=\"am-close\">&times;</button><p><span class=\"am-icon-fw am-icon-spinner am-icon-pulse \"></span> "+content+"</p></div>");
}
function alert_warning(content){
	$("#alert").html("<div class=\"am-alert am-alert-warning\" data-am-alert><button type=\"button\" class=\"am-close\">&times;</button><p><span class=\"am-icon-fw am-icon-exclamation\"></span> "+content+"</p></div>");
}
function alert_danger(content){
	$("#alert").html("<div class=\"am-alert am-alert-danger\" data-am-alert><button type=\"button\" class=\"am-close\">&times;</button><p><span class=\"am-icon-fw am-icon-close \"></span> "+content+"</p></div>");
}
function remove_alert(){
	$("#alert").html("");
}