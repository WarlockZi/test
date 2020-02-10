<div class="block" id = "question-<?= $row['qid'] ?>">

  <input class = "sort-q" type = "text"  data-q-sort="<?= $row['qid'] ?>" size = "1" value = "<?= $row['sort'] ?>">
  <div class="e-block-q " id="<?= $row['qid'] ?>q">
    <div class="left-sidebar">
      <textarea data-question-id="<?= $row['qid'] ?>" cols="20" rows="3" name="<?= $row['qid'] ?>q"><?= $row['qustion'] ?></textarea>
    </div>  

    <div class="right-sidebar">

      <nav class="navi">      
        <a class="navi__item add-answer" data-id = "<?= $row['qid'] ?>"> Добавить ответ </a>
      </nav>

      <div data-prefix = "q" id = "<?= $row['qid'] ?>" class = "holder">Перетащить картинку.
        <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
        <p class="filereader">FileAPI&FileReaderAPI Обратитесь к ВВ.</p>
        <p class="formdata">FormData Обратитесь к ВВ.</p>
        <p class="progress">upload progr isn\'t  Обратитесь к ВВ.</p>                         
        <!--<p><progress class="hidden" id="uploadprogress" max="100" value="0">0</progress></p>-->
        <?= $picQ ?>
        <div class="pic-del" data-q = <?= $row['qid'] ?>>  X  </div>	
      </div> 


    </div>
  </div>