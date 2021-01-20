<?php
$user = 'root';
$pass = '';
$db = 'sna';

$conn = new mysqli('localhost', $user, $pass, $db);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die('connection Failed : ' . $conn->connect_error);
}
?>
<br><br><br>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-3">
                <br>
                &nbsp;<label for="cin">CIN</label>
                <input class="form-control form-control-lg" name="cin" id="cin" type="text" placeholder="01234567">
            </div>
            
        <div id="result"></div>

<script>
$(document).ready(function(){
    load_data('0000000');
	function load_data(query)
	{
		$.ajax({
			url:"../php/ajax/fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}

    $('#cin').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data('0000000');			
		}
	});

	
});
</script>