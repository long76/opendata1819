<?
if(isset($_POST['ogrn'],$_POST['prof_name'],$_POST['spec_name'],$_POST['name_org'],$_POST['inn_org'])) {
	//Send_Answer(true,"Пустые поля!");
	//foreach ($_POST as  $value)
		//if(sizeof(strval($value))<3)
           //Send_Answer(true,"Пустые поля!");
    $orgdata=json_decode(file_get_contents("https://ru.rus.company/интеграция/компании/?инн=".$_POST['inn_org']),true);
	if(!sizeof($orgdata) || strcmp(strval($orgdata[0]["ogrn"]),strval($_POST['ogrn'])))
          Send_Answer(true,"Ошибка ОГРН/ИНН!");
	$cens=explode(", ", file_get_contents("cens.txt"));
	foreach ($cens as $value) {
		if(preg_match( "/[ ]*".$value."[ ]*/ui" , $_POST['prof_name']))
			Send_Answer(true,"Нецензурная лексика в названии профессии!");
		else if(preg_match( "/[ ]*".$value."[ ]*/ui" , $_POST['spec_name']))
			Send_Answer(true,"Нецензурная лексика в специализации!");
	}
	$cur_page=0;
	$data=json_decode(file_get_contents("http://opendata.trudvsem.ru/api/v1/vacancies/company/inn/".$_POST['inn_org']."?offset=".$cur_page."&limit=100"),true);
	while(sizeof($data["results"]))
	{
		foreach ($data["results"]["vacancies"] as $vacancy)
			foreach ($vacancy as $value)
				if(!strcmp($value["company"]["ogrn"],$_POST["ogrn"]))
					if(!strcmp($value["company"]["inn"],$_POST["inn_org"]))
						if(!strcmp($value["job-name"],$_POST["prof_name"]))
							if(!strcmp($value["category"]["specialisation"],$_POST["spec_name"]))
								Send_Answer(true,"Дубликат вакансии!");
							$cur_page++;
		$data=json_decode(file_get_contents("http://opendata.trudvsem.ru/api/v1/vacancies/company/inn/".$_POST['inn_org']."?offset=".$cur_page."&limit=100"),true);
	}
	$orfdata=json_decode(file_get_contents("http://speller.yandex.net/services/spellservice.json/checkText?text=".urlencode($_POST['prof_name']."+ +".$_POST['spec_name'])),true);
    if(sizeof($orfdata) && preg_match("/".$orfdata[0]["word"]."/ui",$_POST['name_org'])==0)
    	Send_Answer(true,"Ошибки орфографии!");
Send_Answer(false,"");
}
function Send_Answer($bad,$info)
{
	if($bad)
		echo "Модерация не пройдена!".$info;
	else
		echo "Модерация пройдена!";		
	exit();
}
?>