<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="jquery.js"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
    $("#check").click(function (){$("#status").html('');$.ajax({
  method: "POST",
  url: "check.php",
  data: { ogrn: $("input[name=ogrn]").val(), prof_name: $("input[name=prof_name]").val(),spec_name:$("input[name=spec_name]").val(), name_org:$("input[name=name_org]").val(),inn_org:$("input[name=inn_org]").val()},
  success: function(data){$("#status").html("<h2 class='alert alert-info'>"+data+"</h2>");}
});});
});
	</script>
	<style>
	form{
		width: 400px;
		margin: 20px;
	}
	#status{
		text-align: center;
	}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<form action="" onsubmit="void(0)">
		<h2>Проверка вакансии</h2>
<h3>ОГРН:</h3>
<input type="text" name="ogrn" class="form-control">
<h3>Название профессии:</h3>
<input type="text" name="prof_name" class="form-control">
<h3>Специализация:</h3>
<input type="text" name="spec_name" class="form-control">
<h3>Название организации:</h3>
<input type="text" name="name_org" class="form-control">
<h3>ИНН:</h3>
<input type="text" name="inn_org" class="form-control"><br>
<button id="check" type="button" class="btn btn-info btn-lg">Проверить</button>
<div id="status"></div>
</form>
</body>
</html>