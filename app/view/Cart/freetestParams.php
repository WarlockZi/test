<div class = "overlay"></div>

<div class = "testParamsBorder none">
    <div class = "none testId" ><?=$test['id']?></div>     
	
	<div class = "table" >

    <div class = "table-left" > 
		<div class = "testParamsField" >Название:</div> 
		<div class = "testParamsField" >Принадлежит:</div> 
		<div class = "testParamsField" >Папка/Тест:</div>
		<div class = "testParamsField">Сортировка:</div>
		<div class = "testParamsField" >Вкл./Выкл.:</div> 
	</div>    
	
	
	<div class = "table-right" > 
		<input id = "saveTestName" class = "testParamsField" type = "text" value = "<?=$test['name']?>"></input>
		<select id = "selectParenTest" class = "testParamsField"><?=$depOptions?></select>
		<select id  = "isTest" class = "testParamsField">
			<option value = "0">Папка</option>
			<option value = "1" <?=$selected?>>Тест</option>
		</select>
		<div class = "sort testParamsField">
			<input type = "text" size = "1" value = <?=$test['sort']?>>
		</div>
		<div class="checkTestOnOff">
			<input id = "test-id<?=$test['id']?>" type = "checkbox" 
				class = "checkbox none" data-test-id = <?=$test['id']?> <?=$checked?>>
			<label for = "test-id<?=$test['id']?>" >
			</label>
		</div> 
	</div>
	
	</div>
	
	<div class = "buttons">
		<div id = "freetestParamsDEL" class="smallButton testParamsField">Удалить</div>
		<div id = "saveFreetestParamsOK" class="smallButton testParamsField">ОК</div>
		<div id = "saveTestParmsCansel" class="smallButton testParamsField"   >ОТМЕНА</div>		
	</div> 

    
</div>       
