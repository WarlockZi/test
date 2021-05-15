<div class="block" id = "question-<?= $row['qid'] ?>">

  <input class = "sort-q" type = "text"  data-q-sort="<?= $row['qid'] ?>" size = "1" value = "<?= $row['sort'] ?>">
  <input type ="button" class = "delete-question" data-id = "<?= $row['qid'] ?>" value = "X">

  <div class="e-block-q " id="<?= $row['qid'] ?>q">
    <div class="left-sidebar">
      <textarea data-question-id="<?= $row['qid'] ?>" cols="20" rows="3" name="<?= $row['qid'] ?>q"><?= $row['question'] ?></textarea>
      <div class="key_words">
        <? foreach ($row['key_words'] as $key => $value): ?>
        <input class = "input_key" type="text" value="<?= htmlspecialchars(trim($value))?>">
         <? endforeach; ?>         
        <div class = "button_key">добавить слово</div>
      </div>
    </div>  

    <div class="right-sidebar">

      <!--      <nav class="navi">      
              <a class="navi__item add-answer" data-id = "<?= $row['qid'] ?>"> Добавить ответ </a>
            </nav>-->

      <div data-prefix = "q" id = "<?= $row['qid'] ?>" class = "holder">Перетащить картинку.
        <p id="upload" class="hidden"><br><input type="file"></p>

        <!--<p><progress class="hidden" id="uploadprogress" max="100" value="0">0</progress></p>-->
        <?= $picQ ?>
        <div class="pic-del" data-q = <?= $row['qid'] ?>>  X  </div>	
      </div> 
    </div>
  </div>