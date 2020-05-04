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



<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">AeRO APAN</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="../" class="pure-menu-link">Home</a></li>
                <li class="pure-menu-item"><a href="../welcome/update" class="pure-menu-link">Update</a></li>

            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>AeRO APAN COVID19 Response</h1>
            <h2>An eResearch response for Southeast Asia</h2>
        </div>

        <div class="content">


            <h2 class="content-subhead">Convert JSON to SQL</h2>
            <p>
            

                <form class="pure-form pure-form-stacked" method="post">
                	<dl>
                	
                	<dt>Original JSON:</dt><dd><textarea name="original_json" placeholder="enter JSON here"></textarea> </dd>
                
                	<input name="convert_json_to_SQL" type="submit"/>
                	</dl>	
                
                </form>
            </p>
            
            

        </div>
    </div>
</div>

</body>


