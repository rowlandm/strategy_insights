<!DOCTYPE html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>System Strategic Planning</title>
<link rel="stylesheet" href="public/css/pure-min-v101.css" >
<link rel="stylesheet" href="public/css/side-menu-styles.css">


	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
<style>
body {
  padding: 20px;
  
}
dt { width: 200px; float: left;}
input[type=text] {

	width: 600px;

}

textarea {

	width:600px;
	height: 100px;

}

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

button { display:none};

#export_to_users,#export_to_word {
	display:none;
}
</style>






<script>
var user_data = {};
var comments_data = [];
var generic_comments = [];	


function setup_display_from_data(){

	anonymise = true;
	
	data_by_user = {};

	$("#category_list_div").html("");
	$("#export_to_word").html("");
	$("#export_to_users").html("");
	
	generic_comments = []; // reset generic_comments for autocomplete
	type_totals = {};
	country_totals = {};
	comment_citation_type_totals = {};

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
		
			
        if (comment_citation_type_totals.hasOwnProperty(comment["comment_citation_type"])){
			
            comment_citation_type_totals[comment["comment_citation_type"]]["number_of_comments_total"] = comment_citation_type_totals[comment["comment_citation_type"]]["number_of_comments_total"] + 1;
			
		} else {
			comment_citation_type_totals[comment["comment_citation_type"]] = {};
			comment_citation_type_totals[comment["comment_citation_type"]]["number_of_comments_total"] = 1;
			
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

        if (country_totals.hasOwnProperty(user["country"])){
			


		    if (country_totals[user["country"]]["stakeholder_ids"].indexOf(comment["stakeholder_id"]) == -1){
		        	country_totals[user["country"]]["stakeholder_ids"].push(comment["stakeholder_id"]);
		        	country_totals[user["country"]]["number_of_users_total"] = country_totals[user["country"]]["number_of_users_total"] + 1;
			}
		} else {
			country_totals[user["country"]] = {};
			country_totals[user["country"]]["number_of_users_total"] = 1;
			country_totals[user["country"]]["stakeholder_ids"] = [comment["stakeholder_id"]];

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


						comment_uid = comments_data[comments_data_index]["uid"];
						
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
		temp_html = temp_html + " Number of "+type +" comments: " + type_totals[type]["number_of_comments_total"] + "<br/>Number of individual "+type+"(s): " + type_totals[type]["stakeholder_ids"].length + "<br/>";
	}
	
	$("#type_totals").html(temp_html);
	
	
	temp_html = "";
	for (country in country_totals){
		temp_html = temp_html + " Number of providers of feedback from "+country +": " + country_totals[country]["number_of_users_total"] + "<br/>";
	}
	
	$("#country_totals").html(temp_html);
	
	
	temp_html = "";
	for (comment_citation_type in comment_citation_type_totals){
		temp_html = temp_html + " Number of comments from "+comment_citation_type +"(s): " + comment_citation_type_totals[comment_citation_type]["number_of_comments_total"] + "<br/>";
	}
	
	$("#comment_citation_type_totals").html(temp_html);
	
	
	
	$('div.category_title').click(function(){
		
		$(this).children("div.generic_comment_div").toggle();

	}); 

	

};

function submit_new_comment_trigger(){

	

	$('form').on("submit",function(event){
		event.preventDefault();
		initial_generic_comment = $("#generic_comment").val();
		raw_comment = $("#raw_comment").val();
		date_of_comment = $("#date_of_comment").val();
		comment_citation = $("#comment_citation").val();
		comment_citation_url = $("#comment_citation_url").val();
		user_id = $("#select_user").val();


		// split generic comment ie. generic_comment::category from autocomplete
		temp_comment = initial_generic_comment.split("::");
		generic_comment = temp_comment[0];
		category = temp_comment[1];
		
		var count_attibutes_in_user_data = 0;
		for (var property_key in user_data) {
			if (user_data.hasOwnProperty(property_key)) {
			   ++count_attibutes_in_user_data;
			}
		}

		//full_name = $("#full_name").val();
		//email = $("#email").val();
		//organisation = $("#organisation").val();
		//next_uid = count_attibutes_in_user_data + 1;
		
		
		new_comment = {"uid":user_id,"date_of_comment":"", "comment_citation":"", "comment_citation_url":"","raw_comment":raw_comment,"generic_comment":generic_comment,"category":category,"comment_citation":comment_citation,"comment_citation_url":comment_citation_url,"date_of_comment":date_of_comment};
		
		
		
		comments_data = comments_data.concat(new_comment);
		
		setup_display_from_data(comments_data,user_data);
		
		

	}); 
	
	

	
}

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


	for (var uid in user_data) {
	    name = user_data[uid]["name"] ;
	    organisation = user_data[uid]["organisation"] ;

		$("#select_user").append($('<option>',{
			value:uid,
			text:name + " : " + organisation
		}));
	}


	//setup_display_from_data();
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
	submit_new_comment_trigger();
	
	export_updated_users_data_json_trigger();
	import_updated_users_data_json_trigger();
	

	
	
	$("#export_to_word").show();
	$("#export_to_users").hide();  
	$("#category_list_div").hide(); 


	setup_autocomplete_generic_comment();
	setup_display_from_data();
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
                <li class="pure-menu-item"><a href="" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="strategy/update" class="pure-menu-link">Update</a></li>

				<?php 

					foreach ($strategies as &$strategy_object) {
						echo('<li class="pure-menu-item"><a href="strategy/change_strategy?strategy_id='.$strategy_object->id.'"
								class="pure-menu-link">Strategy '.$strategy_object->name.'</a></li>');

					}

				?>

            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>Systematic Strategic Planning</h1>
            <h2>Demo website for advocacy based Strategic Planning</h2>
        </div>

        <div class="content">
         
            <h2 class="content-subhead">Methodology behind this website</h2>
            <p>
                This is an example of the systematic way of providing advocacy in strategic planning.
                
                It is based off the presentation: 
                
                <a href="https://figshare.com/articles/Strategic_Planning_using_a_Change_Management_Lifecycle_Framework/12199856">"Strategic Planning using a Change Management Lifecycle Framework"</a>.
                <br/><br/>
                This presentation discusses how to provide feedback to the meso and micro levels systematically. It also highlights that providing stakeholders with an update on the feedback provided by others in an anonymous way helps build relationships and trust with the stakeholders.
                <br/><br/>
                With this information, we can share more widely with the community in an acceptable way that guards the privacy of our stakeholders who have provided feedback. 
                <br/><br/>
                A previous example of this methodology being used was the <a href="http://www.faver.edu.au/projects/how-to-best-engage-with-digital-humanities-research-in-victoria/">How to best engage with digital humanities research in Victoria?"</a> project run by the Federation for the Advancement of Victorian eResearch (FAVeR). This methodology resulted in a <a href="https://docs.google.com/document/d/1odDrLE89vRPintxHhCmP8VuRjYnQ1_ZFA179s7PmXn0/edit?usp=sharing">preliminary report of needs for digital humanities research in Victoria</a>. This report was then use to encourage researchers and funders to see the opportunities in the digital humanities community.
            </p>

        </div>
        <div class="content">
         
            <h2 class="content-subhead">Software behind this website</h2>
            <p>
                The software is open source and available via <a href="https://doi.org/10.6084/m9.figshare.12237410">Figshare</a> and <a href="https://github.com/rowlandm/strategy_insights">github</a>.
	    </p>
	</div>
    </div>
</div>

<script src="https://purecss.io/combo/1.18.13?/js/ui.js"></script>





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
    $temp_string .= "\"type\":\"researcher\","; // this needs to be added to the database.
    $temp_string .= "\"name\":\"\",";
    $temp_string .= "\"organisation\":\"".$stakeholder->country."\",";
    $temp_string .= "\"country\":\"".$stakeholder->country."\"";
    $temp_string .="},";
    $stakeholder_json_string .= $temp_string;
}
$stakeholder_json_string = substr($stakeholder_json_string, 0, -1); // remove last character

$stakeholder_json_string .= "}";
echo $stakeholder_json_string;
?>
</textarea>

<br/>
<br/>


</body>


