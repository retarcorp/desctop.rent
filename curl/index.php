<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>CURL-console</title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
    
    <main>
        <h1>Super-Duper CURL-console</h1>
        
        <form id='form'>
        	<input type='text' placeholder='Path' id='path' value='<?=$_SERVER['SERVER_NAME'] . '/api/';?>'>
        	<input type='text' placeholder='Method' id='method'>
        	<input type='text' placeholder='Body' id='body'>
        	<input type='text' placeholder='Cookie' id='cookies'>
        	<input type='text' placeholder='Headers' id='headers'>
        	<input type='button' id='send' value='Send'>
        </form>
        
        <div class='res'>
            <h2>Results</h2>
            <pre id='results'>
                
            </pre>
        </div>
        
        <div class='spinner' id='spinner'>
            <img src='spinner.gif'>
        </div>
        
    </main>
    
    <script src='main.js'></script>
    
</body>
</html>