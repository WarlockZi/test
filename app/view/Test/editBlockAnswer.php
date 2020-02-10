<div class="e-block-a animated bounceInRight" id = "<?= $row['id'] ?>">
  <div class = "left-sidebar">

    <textarea data-answer-id = "<?= $row['id'] ?>" cols = "20" rows = "2" name = "<?= $row['id'] ?>"><?= $row['answer'] ?></textarea>
    <div class="check_right_answer">
      <input id = "right_answer<?= $row['id'] ?>" type = "checkbox" class = "checkbox none" data-answer = "<?= $row['id'] ?>" <?= $correctAnswer ?>>
      <label for = "right_answer<?= $row['id'] ?>" >Верный ответ</label>
    </div>

  </div> 
  <div class = "right-sidebar">
    <nav class="navi">
      <p id = "d_a" class="navi__item" onClick = "edit('delete_a',<?= $row['id'] ?>,<?= $row['qid'] ?>)">Удалить ответ</p>
    </nav>

    <div data-prefix = "a" id = '<?= $row['id'] ?>' class = "holder">Перетащить картинку.
      <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
      <p class="filereader">FileAPI&FileReaderAPI Обратитесь к ВВ.</p>
      <p class="formdata">FormData Обратитесь к ВВ.</p>
      <p class="progress">upload progr isn\'t  Обратитесь к ВВ.</p>                         
      <!--<p><progress class="hidden" id="uploadprogress" max="100" value="0">0</progress></p>-->
      <?= $picA ?>
      <div class="pic-del" data-a = "<?= $row['id'] ?>">  X  </div>	
    </div> 

  </div>    
</div>
