<section>


                <?php if (isset($result)&& $result): ?>
                    <p>Сообщение отправлено! Мы ответим Вам на указанный email.</p>
					
					
                <?php else: ?>

                    <?php if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

						<form class="form-container" action="<?=PROJ?>/test/contacts" method="post">
							<div class = "form-title">Есть вопрос? Напишите нам</div>
                            <!--<input class = "form-input" type="email"  placeholder="Ваш е-mail" value = <?= $user['email']?>>-->
                            <textarea class = "form-input"  placeholder="Сообщение"></textarea>
                            <input type = "submit" class = "form-input submit" class="btn btn-default" value="Отправить">
							<input type="hidden"  value=<?=$token?>>
                        </form>
                <?php endif; ?>

</section>