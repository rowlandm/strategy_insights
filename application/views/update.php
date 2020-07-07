<!DOCTYPE html>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../public/css/pure-min-v101.css" >
<link rel="stylesheet" href="../public/css/side-menu-styles.css">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
body {
  padding: 20px;
  
}
dt { width: 200px; float: left;}

textarea {

	width:600px;
	height: 100px;

}

#generic_comment {width: 600px};

div.category_title {

	width: 600px;
	padding: 10px;
	border: 1px solid black;
}

div.generic_comment_div {

	margin-top: 10px;
	border: 1px solid red;
	padding: 10px;
	display:none;

}

li.raw_comment {

	display:none;
}

#export_to_users,#export_to_word {
	display:none;
}
</style>






<script>
var user_data = {};
var comments_data = [];
var generic_comments = [];	


function setup_display_from_data(){

	anonymise = $("#anonymise").is(':checked');
	
	data_by_user = {};

	$("#category_list_div").html("");
	$("#export_to_word").html("");
	$("#export_to_users").html("");
	
	generic_comments = []; // reset generic_comments for autocomplete
	type_totals = {};

	// Calculate Category totals.
	data_by_categories ={};
	for (var counter = 0, len = comments_data.length; counter < len; counter++) {
		comment= comments_data[counter];
		
		if (data_by_categories.hasOwnProperty(comment.category)){ // existing category
		
			data_by_categories[comment.category]["total"] = data_by_categories[comment.category]["total"] + 1;
			
			// check for existing generic_comment in existing category
			if(data_by_categories[comment.category]["generic_comments"].hasOwnProperty(comment["generic_comment"])){
				data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]["total"] = data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]["total"] + 1;
				data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]["array_index_of_comments"].push(counter);
				
				
			} else { // new generic_comment in existing category
				data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]= {"total":1};
				data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]["array_index_of_comments"]= [counter];
				generic_comments.push(comment["generic_comment"]+'::'+comment["category"]);
				
			}
			
		} else { // completely new category
		
			data_by_categories[comment.category] = {"total":1,"generic_comments":{}};
			data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]] = {total:1};
			data_by_categories[comment.category]["generic_comments"][comment["generic_comment"]]["array_index_of_comments"]= [counter];
			generic_comments.push(comment["generic_comment"]+'::'+comment["category"]);
			
			
		}
		
		if (data_by_user.hasOwnProperty(comment["stakeholder_id"])){ // existing user_comments
			data_by_user[comment["stakeholder_id"]].push(counter);
		}else {
			data_by_user[comment["stakeholder_id"]]= [];
			data_by_user[comment["stakeholder_id"]].push(counter);
		}

		user = user_data[comment["stakeholder_id"]];

		if (type_totals.hasOwnProperty(user["type"])){
			type_totals[user["type"]]["number_of_comments_total"] = type_totals[user["type"]]["number_of_comments_total"] + 1;


			if (type_totals[user["type"]]["stakeholder_ids"].indexOf(comment["stakeholder_id"]) == -1){
		        	type_totals[user["type"]]["stakeholder_ids"].push(comment["stakeholder_id"]);
			}
		} else {
			type_totals[user["type"]] = {};
			type_totals[user["type"]]["number_of_comments_total"] = 1;
			type_totals[user["type"]]["stakeholder_ids"] = [comment["stakeholder_id"]];

		}
		
	}
	
	data_by_categories_keys_sorted = Object.keys(data_by_categories).sort(function(a,b){return data_by_categories[b].total-data_by_categories[a].total})
	


	// Display data
	for (var counter = 0, len = data_by_categories_keys_sorted.length; counter < len; counter++){
	
		category = data_by_categories_keys_sorted[counter];
		
		if (data_by_categories.hasOwnProperty(category)){
			category_details = data_by_categories[category];
			
			$("#category_list_div").append("<div class='category_title' id='"+category.split(' ').join('_')+"'>"+category+ " with " + category_details["total"]+" comment(s) </div>");
			
			$("#export_to_word").append("<div style='margin-top:40px;'>"+category+ " with " + category_details["total"]+" total comment(s)</div><ul>");
			
						
			generic_comments_temp = data_by_categories[category]["generic_comments"];
			
			generic_comments_keys_sorted = Object.keys(generic_comments_temp).sort(function(a,b){return generic_comments_temp[b].total-generic_comments_temp[a].total})
	
			
			for (var counter_generic_comments = 0, len_generic_comments = generic_comments_keys_sorted.length; counter_generic_comments < len_generic_comments; counter_generic_comments++){
			//for (var generic_comment in data_by_categories[category]["generic_comments"]) {
			
				generic_comment = generic_comments_keys_sorted[counter_generic_comments];
			
				$("#"+category.split(' ').join('_')+"").append("<div id='"+generic_comment.replace(/\,/g,'').split(' ').join('_')+"' class='generic_comment_div'>"+generic_comment+ ":" + data_by_categories[category]["generic_comments"][generic_comment]["total"]+"</li>");
				
				
				open_comments = "";
				if (anonymise == false){
				
					open_comments = open_comments + "<ul>";
					for (var array_index_of_comment in data_by_categories[category]["generic_comments"][generic_comment]["array_index_of_comments"]) {
				
						
				
						comments_data_index = data_by_categories[category]["generic_comments"][generic_comment]["array_index_of_comments"][array_index_of_comment];


						comment_uid = comments_data[comments_data_index]["stakeholder_id"];
						
						comment_user_name = user_data[comment_uid]["name"];
						comment_user_organisation = user_data[comment_uid]["organisation"];
						comment_citation = comments_data[comments_data_index]["comment_citation"];
						comment_citation_url = comments_data[comments_data_index]["comment_citation_url"];
						date_of_comment = comments_data[comments_data_index]["date_of_comment"];

						$("#"+generic_comment.replace(/\,/g,'').split(' ').join('_')).append("<li class='li_raw_comment'>" + comments_data[comments_data_index]["raw_comment"] +" ("+comment_user_name+":"+comment_user_organisation+":"+comment_citation+")</li>");


						open_comments = open_comments + "<li class='li_li_raw_comment'>" + comments_data[comments_data_index]["raw_comment"] +" ("+comment_user_name+":"+comment_user_organisation+":"+comment_citation+")</li>";

							
					}
					open_comments = open_comments + "</ul>";
				}
				$("#export_to_word").append("<li>"+generic_comment+ " ["+ data_by_categories[category]["generic_comments"][generic_comment]["total"]+" comment(s)]"+open_comments+"</li>");
				
				
			}
		
			$("#export_to_word").append("</ul>");
		}
	}
	
	for (uid in data_by_user){
	
		user = user_data[uid];
	
		temp_html = "";
		
		for (counter in data_by_user[uid]){
			comments_data_index = data_by_user[uid][counter];	

			comment = comments_data[comments_data_index];

			generic_comment = comment["generic_comment"];
			comment_category = comment["category"];

			raw_comment = comment["raw_comment"] ;
			comment_citation= comment["comment_citation"];
			date_of_comment = comment["date_of_comment"];
			temp_html = temp_html + "<li>"+raw_comment+"("+comment_category+":"+generic_comment+":"+comment_citation +":"+date_of_comment+")</li>";
		}
	
		$("#export_to_users").append("<div>"+user.name+"</div><ul>"+temp_html+"</ul>");
	}
	
	temp_html = "";
	for (type in type_totals){
		temp_html = temp_html + " Number of "+type +" comments:" + type_totals[type]["number_of_comments_total"] + " Number of individual "+type+"(s):" + type_totals[type]["stakeholder_ids"].length + "<br/>";
	}

	$("#type_totals").append(temp_html);
	
	$('div.category_title').click(function(){
		
		$(this).children("div.generic_comment_div").toggle();

	}); 

	

};


function export_updated_comments_data_json_trigger(){

	$('#export_updated_comments_data_json_button').click(function(){
		    
        $("#export_updated_comments_data_json").val(JSON.stringify(comments_data));

	    document.update.submit();

	});

}



function clear_data_and_save_trigger(){

	$('#clear_data_and_save_button').click(function(){
		
		
        if (window.confirm("This function is not available.")) {
            // disable for the aero_apan
            //$("#export_updated_comments_data_json").val("");
            //document.update.submit();
        }
		
	});

}



function import_updated_comments_data_json(){
	text_data = $("#import_comments_data_json").val();
	comments_data = JSON.parse(text_data);

	faculty_research_manager_text_data = $("#import_frm_comments_data_json").val();
	additional_comments_data = JSON.parse(faculty_research_manager_text_data);

	comments_data = comments_data.concat(additional_comments_data);

	setup_display_from_data();
}

function import_updated_comments_data_json_trigger(){
	

	$('#import_updated_comments_data_json_button').click(function(){
		import_updated_comments_data_json();
		
	});
	
	
}

function export_updated_users_data_json_trigger(){

	$('#export_updated_user_data_json_button').click(function(){
		$("#export_updated_user_data_json").val(JSON.stringify(user_data));
	});

}

function import_updated_users_data_json(){

	text_data = $("#import_user_data_json").val();
	user_data = JSON.parse(text_data);
	setup_display_from_data();
	return;

}

function import_updated_users_data_json_trigger(){

	$('#import_updated_user_data_json_button').click(function(){
		import_updated_users_data_json();
		
	});

}

function setup_autocomplete_generic_comment(){

	$( "#generic_comment" ).autocomplete({
      source: generic_comments
    });

}

$(document).ready(function(){
	
	   
	import_updated_users_data_json(); // this has to go first.
	import_updated_comments_data_json();
	
	export_updated_comments_data_json_trigger();
	import_updated_comments_data_json_trigger();
	clear_data_and_save_trigger();
	
	
	export_updated_users_data_json_trigger();
	import_updated_users_data_json_trigger();
	
	$("#anonymise").click(function(){
		setup_display_from_data();
		
	});
	
	$("#show_export_to_word").click(function(){ 
		$("#export_to_word").toggle(); 
		$("#category_list_div").toggle(); 
	});
	
	$("#show_export_to_users").click(function(){ 
		$("#export_to_users").toggle(); 
		$("#category_list_div").toggle(); 
	});
	
	setup_autocomplete_generic_comment();
});
</script>

<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">Insights</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="../" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="../strategy/update" class="pure-menu-link">Update</a></li>
                <li class="pure-menu-item"><a href="../strategy/change_strategy?strategy_id=1" class="pure-menu-link">Strategy 1</a></li>
                <li class="pure-menu-item"><a href="../strategy/change_strategy?strategy_id=2" class="pure-menu-link">Strategy 2</a></li>

            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Demo environment update</h1>
            <h2>Something to try</h2>
        </div>

        <div class="content">
         
            <h2 class="content-subhead">Update the Backend</h2>
            <p>
                This page allows you to add new researcher comments and code them.
             
            </p>

            <h2 class="content-subhead">Add New Researcher Comments</h2>
            <p>


                <form class="pure-form pure-form-stacked" method="post">
                	<dl>
                	<dt>User:</dt><dd><select name="stakeholder_id" id="select_user">
						<?php
							foreach ($stakeholders as $stakeholder) {
								if ($stakeholder->id == $previous_update['stakeholder_id']) { 
									$selected = "selected";
								} else { 
									$selected = "";
								}
								echo "<option ".$selected." value='" . $stakeholder->id . "'>" . $stakeholder->honorific." ". $stakeholder->first_name . " ". $stakeholder->second_name. " : ". $stakeholder->organisation . "</option>";
							}
						?>
					</select> </dd>
                	<dt>Date:</dt><dd><input type="text" name="date_of_comment" id="date_of_comment" placeholder="yyyy-mm-dd" value="<?php if (isset( $previous_update['date_of_comment'])){ echo($previous_update['date_of_comment']); } ?>"></input> </dd>
                	<dt>Comment citation type: </dt><dd><input type="text" id="comment_citation_type" name="comment_citation_type" placeholder="eg. Correspondence, Publication, Presentation, Newspaper Article" value="<?php if (isset( $previous_update['comment_citation_type'])){ echo($previous_update['comment_citation_type']); } ?>"></input> </dd>
                	<dt>Comment citation: </dt><dd><input type="text" id="comment_citation" name="comment_citation" placeholder="eg. Name of publication or document ID DD#029" value="<?php if (isset( $previous_update['comment_citation'])){ echo($previous_update['comment_citation']); } ?>"></input> </dd>
                	<dt>Comment citation URL:</dt><dd><input type="text" id="comment_citation_url" name="comment_citation_url" placeholder="http://google.com" value="<?php if (isset( $previous_update['comment_citation_url'])){ echo($previous_update['comment_citation_url']); } ?>"></input> </dd>
                
                	<dt>Raw Comment:</dt><dd><textarea id="raw_comment" name="raw_comment" placeholder="enter raw comment here"></textarea> </dd>
                
                	<dt>Generic Comment:</dt><dd><input type="text" id="generic_comment" name="generic_comment" placeholder="Start typing for autocomplete"></input> </dd>
                
                
                	<input id="add_new_comment" type="submit"/>
                	</dl>	
                
                </form>
            </p>
            
            <h2 class="content-subhead">Current Survey Synthesis of Needs</h2>
            <p>

                <h1>Display</h1>
                <div id="type_totals"></div>
                <button id="show_export_to_word">Export to Word</button></br></br>
                <button id="show_export_to_users">Export to Users (per User)</button></br></br>
                <input type="checkbox" id="anonymise" value="anonymise">Anonymise</br></br>
                <div id="category_list_div"></div>
                <div id="export_to_word"></div>
                <div id="export_to_users"></div>
                
                
                <form name="update" method="post">
                
                <textarea style="display:none;margin-top:30px;" name="updated_data" id="export_updated_comments_data_json"> </textarea>
                <br/><br/><button id="export_updated_comments_data_json_button">Save Changes </button>
                </form>
                <br/>
                <br/><br/>
                
                <button id="clear_data_and_save_button" disabled>Clear Data and Save</button></br>
                <br/><br/>
                <textarea id="import_comments_data_json" style="display:none">
                <?php
                echo $records;
                ?>
                </textarea>
                <textarea id="import_frm_comments_data_json" style="display:none">
                []
                </textarea>
                
                
                <textarea id="import_user_data_json" style="display:none">
                <?php 
                $stakeholder_json_string="{";
                foreach ($stakeholders as &$stakeholder) {
                    
                    $temp_string = "\"$stakeholder->id\":{";
                    $temp_string .= "\"uid\":".$stakeholder->id.",";
                    $temp_string .= "\"name\":\"".$stakeholder->honorific." ".$stakeholder->first_name." ".$stakeholder->second_name."\",";
                    $temp_string .= "\"organisation\":\"".$stakeholder->organisation."\"";
                    $temp_string .="},";
                    $stakeholder_json_string .= $temp_string;
                }
                $stakeholder_json_string = substr($stakeholder_json_string, 0, -1); // remove last character
                
                $stakeholder_json_string .= "}";
                echo $stakeholder_json_string;
                ?>
                </textarea>            
            </p>

        </div>
    </div>
</div>

<script src="https://purecss.io/combo/1.18.13?/js/ui.js"></script>










</body>


