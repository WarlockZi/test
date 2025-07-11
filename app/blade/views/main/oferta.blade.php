@section('title', $meta->title)
@section('description', $meta->description)
@section('keywords', $meta->keywords)

@extends('layouts.main.main')

@section('content')
<div class="oferta">


    <h1>Оферта</h1>
    <p>Публичная оферта (условия о продаже товаров) </p>

    <p>Настоящая публичная оферта (Условия о продаже Товара) (<b>далее - Оферта</b>)
        адресована физическим лицам (Пользователям сайта и/или Покупателям) и является
        официальным публичным предложением <b>ООО «Витекс»</b> заключить Договор на покупку
        Товара, размещенного на сайте vitexopt.ru. Договор считается заключенным с момента
        совершения физическим лицом действий, предусмотренных офертой, и означающих безоговорочное
        принятие физическим лицом всех условий, указанных в оферте. Оферта доступна для ознакомления
        на официальном интернет-сайте по адресу: https://vitexopt.ru/main/oferta</p>
    <ul class="d-psvd-lst">
        <li>
            <p class="d-x-large topmargin1">1. ТЕРМИНЫ И ОПРЕДЕЛЕНИЯ</p>
            <?

            use app\controller\Address;

            $adress = Address::postCodeDecorator(Address::$factAddress);
            ?>


            <dd>Продавец</dd>
            <dt>- <b>Общество с ограниченной ответственностью
                    «Витекс»</b> (ИНН/КПП 3525402690/352501001, место нахождения: <?= $adress ?>).
            </dt>
            <dd>Пользователь</dd>
            <dt>- физическое лицо, имеющее доступ к Сайту
                https://vitexopt.ru, посредством сети Интернет и использующее Сайт
                и желающий разместить Заказы в Интернет-магазине <b>vitexopt.ru</b>;
            </dt>
            <dd>Покупатель</dd>
            <dt>– физическое лицо - Пользователь, принявший
                условия оферты и разместивший (оформивший) Заказ в Интернет-магазине vitexopt.ru;
            </dt>
            <dd>Интернет-магазин</dd>
            <dt>- Интернет-сайт, принадлежащий Продавцу,
                размещенный в сети интернет по адресу https://vitexopt.ru, где представлены
                Товары, предлагаемые Продавцом для приобретения, а также условия и
                порядок заказа, оплаты и доставки Товара Покупателям.
            </dt>
            <dd>Сайт</dd>
            <dt>- https://vitexopt.ru (далее – Сайт).</dt>
            <dd>Товар</dd>
            <dt>– спецодежда (обувь, одежда), средства индивидуальной
                защиты и иные товары, представленные к продаже на Сайте Продавца.
            </dt>
            <dd>Заказ</dd>
            <dt>- запрос Покупателя на приобретение и доставку Товаров,
                размещенных на Сайте Продавца по указанному Покупателем адресу в порядке и
                на условиях настоящей Оферты.
            </dt>
            <dd>Акцепт</dd>
            <dt>- ответ физического лица, которому адресована оферта,
                о ее принятии. Акцепт должен быть полным и безоговорочным.
            </dt>
            <dd>Персональные информация (данные)</dd>
            <dt>– информация, которую Пользователь
                /Покупатель предоставляет о себе самостоятельно при регистрации (создании
                учётной записи) и/или оформлении Заказа на Сайте и/или в процессе использования
                Сервисов, включая, но не ограничиваясь, персональные данные пользователя.
            </dt>
        </li>
        <li>
            <p class="d-x-large topmargin1">2. ОБЩИЕ ПОЛОЖЕНИЯ</p>
            <ul>
                <li>2.2. Условия Оферты, информация о Товаре, представленная на Сайте
                    Продавца, являются публичной Офертой в соответствии со ст.435 и ч.2
                    ст.437 Гражданского кодекса РФ.
                </li>
                <li>2.3. Оферта определяет порядок и условия оформления заказа, цену,
                    характеристики товара, порядок и способы оплаты и доставки Товара
                    Покупателю.
                </li>
                <li>2.4. Оферта и все приложения к ней опубликованы на Сайте. Условия
                    продажи Товаров содержат пункты с активными гиперссылками на конкретные
                    тематические разделы с подробной информацией о Товарах, цене, условиях
                    оплаты и доставки Товара, которые являются неотъемлемой частью Оферты.
                </li>
                <li>2.5. К отношениям между Покупателем и Продавцом применяются положения
                    Главы 30 ГК РФ, Закона РФ «О защите прав потребителей» от 07.02.92
                    № 2300-1, Правил продажи товаров дистанционным способом (утв.
                    Постановлением Правительства РФ от 27.09.07 № 612) и иных
                    нормативных правовых актов, регулирующих продажу товаров дистанционным
                    способом.
                </li>
                <li>2.6. Договор между Покупателем и Продавцом (Сторонами) заключается
                    путем акцепта Покупателем Оферты, которая считается акцептованной
                    (принятой Покупателем следующими способами:
                    <ul>
                        <li>- с момента регистрации Покупателя (Посетителя) на Сайте
                            (при оформлении заказа).
                        </li>
                        <li>- с момента оформления Покупателем Заказа без авторизации на Сайте</li>
                        <li>- с момента принятия Продавцом Заказа Покупателя по телефонам,
                            указанным на сайте.
                        </li>
                    </ul>
                </li>
                <li>2.7. Покупатель соглашается с Условиями Оферты нажатием кнопки
                    "Подтвердить заказ" при оформлении Заказа на Сайте либо путем дачи
                    согласия оператору при оформлении Заказа по телефону. Совершение
                    указанных действий является подтверждением на заключение договора
                    между Покупателем и Продавцом.
                </li>
                <li>2.8. Договор розничной купли-продажи считается исполненным с момента
                    доставки (выдачи) Продавцом Покупателю Товара в указанном Покупателем
                    месте доставки, а также выдачи Покупателю кассового или товарного чека,
                    подтверждающего оплату Товара (при оплате Товара Покупателем в месте
                    доставки).
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">3. ПРЕДМЕТ ОФЕРТЫ</p>
            <ul>
                <li>3.1. Продавец на основании заказа Покупателя передает Покупателю
                    Товар в соответствии с условиями и по ценам, указанными в Оферте, в
                    том числе в приложениях к ней.
                </li>
                <li>3.2. Предметом настоящей Оферты является предоставление
                    возможности любому дееспособному физическому лицу – Покупателю/Пользователю
                    Сайта приобретать для личных, семейных, домашних и иных нужд, не
                    связанных с осуществлением предпринимательской деятельности, Товары,
                    представленные в каталоге Интернет-магазина https://vitexopt.ru.
                </li>
                <li>3.3. Оферта распространяется на все виды Товаров и услуг,
                    представленных на Сайте, в том числе в каталоге Интернет-магазина.
                </li>
                <li>3.4. Товар представлен на Сайте через фото-образцы. Каждый
                    фото-образец сопровождается текстовой информацией: наименованием,
                    ценой, описанием характеристик Товара, видео.
                </li>
                <li>3.5. Все информационные материалы, представленные в интернет - магазине,
                    носят справочный характер. В случае возникновения у Покупателя
                    вопросов, касающихся наличия, свойств и характеристик Товара,
                    в том числе цвета Товара, Покупатель может связаться с оператором
                    интернет-магазина любым способом, указанным на Сайте для уточнения
                    любых характеристик Товара, в том числе о наличии Товара на складе.
                </li>
                <li>3.6. Качество Товара соответствует всем требованиям ГОСТ,
                    Техническим регламентам Таможенного союза, что подтверждается
                    соответствующими документами.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">4. РЕГИСТРАЦИЯ НА САЙТЕ</p>
            <ul>
                <li>4.1. Для оформления Заказа Покупателю необходимо зарегистрироваться
                    на Сайте. Регистрация на Сайте осуществляется с помощью окна
                    «Регистрация».
                </li>
                <li>4.2. Покупатель также может оформить заказ без регистрации на
                    Сайте или оформить заказ через оператора (менеджера) интернет-магазина
                    по телефону, указанному на Сайте.
                </li>
                <li>4.3. Продавец не несет ответственности за точность и правильность
                    информации, предоставляемой Покупателем/Пользователем при регистрации.
                </li>
                <li>4.4. Покупатель/Пользователь обязуется не сообщать третьим лицам
                    логин и пароль, указанные им при регистрации. В случае возникновения
                    у Покупателя подозрений относительно безопасности его логина/пароля
                    или возможности их несанкционированного использования третьими лицами,
                    Покупатель обязуется незамедлительно уведомить об этом Продавца,
                    направив соответствующее уведомление по адресу: info@vitexopt.ru.
                </li>
                <li>4.5. Продавец не несет ответственности за точность и правильность
                    информации, предоставляемой Покупателем при регистрации.
                </li>
                <li>4.6. Регистрируясь на Сайте, Покупатель соглашается с получением
                    сообщений сервисного характера, направляемых на адрес электронной почты,
                    указанный при регистрации, а также посредством смс-сообщений и через
                    Службу по работе с Покупателями, о состоянии заказа.
                </li>
                <li>4.7. Покупатель, сообщая Продавцу, в том числе посредством
                    регистрации на сайте и/или по телефону, свои персональные данные
                    (в том числе e-mail, ФИО, телефон, адрес), Покупатель дает свое
                    безотзывное, свободное и полное согласие на обработку своих
                    персональных данных Продавцом в соответствии со ст. 9 Федерального
                    закона «О персональных данных» в порядке и для целей, указанных в
                    Разделе 10 Оферты.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">5. ПОРЯДОК ОФОРМЛЕНИЯ ТОВАРА</p>
            <ul>
                <li>5.1. Указанная на Сайте информация по наличию Товара носит
                    справочный характер и отображает возможное наличие Товара на
                    складе Продавца в момент оформления, подтверждения, начала
                    комплектования Заказа, в связи с чем, не порождает юридических
                    последствий для любой из Сторон.
                </li>
                <li>5.2. В случае отсутствия заказанных Покупателем Товаров на
                    складе Продавца, последний уведомляет об отсутствии заказанного
                    Товара Покупателя и исключает указанный Товар из Заказа с обязательным
                    уведомлением об этом Покупателя, путем направления Покупателю
                    соответствующего уведомления по email, указанному Покупателем
                    при регистрации либо по телефону, сообщенного Продавцу (оператору
                    интернет-магазина).
                </li>
                <li>5.3. В случае аннулирования полностью либо в части оплаченного
                    Заказа стоимость аннулированного Заказа возвращается Покупателю
                    способом, которым Товар был оплачен.
                </li>
                <li>5.4. Заказ оформляется Покупателем в порядке и согласно условиям,
                    размещенным на Сайте по адресу https://vitexopt.ru/cart в
                    разделе «Оформление Заказа»
                </li>
                <li>5.5. Покупатель, оформляя Заказ, несет ответственность за
                    достоверность предоставляемой информации о себе, а также подтверждает,
                    что с условиями Оферты ознакомлен, понимает ее содержание и согласен.
                </li>
                <li>5.6. После оформления заказа Продавец подтверждает заказ
                    Покупателя путем отправления на e-mail Покупателя информации,
                    подтверждающий принятие заказа (наличие Товара на складе), с
                    указанием наименования, цены выбранного товара, времени необходимого
                    для доставки товара и общей суммы заказа или менеджер интернет-магазина
                    связывается с Покупателем по телефону.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">6. ДОСТАВКА ТОВАРА</p>
            <ul>
                <li>6.1. Способы, цены, а также сроки доставки Товара указаны на Сайте
                    в Разделе «Доставка Товара»
                    (https://vitexopt.ru/service/delivery).
                    Конкретные сроки и время доставки, маршрут доставки
                    уточняются Покупателем с менеджером интернет-магазина при
                    подтверждении заказа по электронной почте и/или по телефону,
                    указанным Покупателем.
                </li>
                <li>6.2. При доставке Заказ вручается Покупателю (Получателю Товара)
                    или третьему лицу (при наличии у третьего лица документов,
                    уполномочивающих его на получение Товара за лицо, указанное в
                    Заказе Покупателя).
                </li>
                <li>6.3. Во избежание случаев мошенничества и для выполнения взятых
                    на себя обязательств, указанных в оферте, при вручении оплаченного
                    Заказа лицо (представитель Продавца), осуществляющее доставку Заказа,
                    вправе потребовать документ, удостоверяющий личность Покупателя
                    (Получателя), а также указать тип и номер предоставленного Получателем
                    документа на квитанции к Заказу.
                </li>
                <li>6.4. Риск случайной гибели или случайного повреждения Товара, а
                    также право собственности на товар, переходит к Покупателю с момента
                    передачи ему Заказа и проставления Получателем Заказа подписи в
                    документах, подтверждающих доставку Заказа.
                </li>
                <li>6.5. В случае недоставки Заказа Продавец возмещает Покупателю
                    стоимость оплаченного Покупателем Заказа и доставки в полном объеме.
                </li>
                <li>6.6. Стоимость доставки Заказа рассчитывается исходя из веса
                    Товара, региона и способа доставки.
                </li>
                <li>6.7. Качество Товара (внешний вид), количество Товара, а также
                    комплектность всего Заказа должны быть проверены Покупателем
                    (Получателем) в момент доставки Товара.
                </li>
                <li>6.8. При доставке Товара Покупатель ставит свою подпись и ее
                    расшифровку в квитанции о доставке в графе: «Заказ принял, комплектность
                    полная, претензий к количеству и внешнему виду товара не имею».
                    После получения Заказа претензии по качеству Товара, количеству
                    и комплектности не принимаются.
                </li>
                <li>6.9. Покупатель может получить заказ в любом отделении почты России.
                    Стоимость доставки рассчитывается во время оформления заказа.
                    При получении Заказа в отделении Почта России Получатель обязан осмотреть
                    внешнюю упаковку почтового отправления Товара на наличие признаков
                    повреждений и/или целостности упаковки. О выявленных нарушениях/повреждениях
                    внешней упаковки Покупатель в письменной форме должен составить акт
                    с указанием выявленных повреждений (дефектов) и вправе произвести вскрытие
                    почтового отправления в присутствии работников Почты России для
                    проверки Товара на соответствие заявленному количеству, ассортименту
                    и комплектности Товара.
                </li>
                <li>6.10. В случае наличия претензий к доставленному Товару (недовложения,
                    несоответствие Товара описи вложений, брак) по требованию Покупателя
                    (Получателя) Товара работниками Почты России составляется Акт о
                    выявленных несоответствиях. Если Получателем не были заявлены претензии,
                    то Продавец считается исполнившим свою обязанность по передаче
                    Товара Покупателю.
                </li>
                <li>6.11. Обязанность Продавца передать товар Покупателю считается
                    исполненной в момент вручения курьером (представителем Продавца)
                    Товара Покупателю (или его Представителю) или с момента передачи
                    товара Покупателю в Отделении Почты России.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">7. ОПЛАТА ТОВАРА</p>
            <ul>
                <li>7.1. Способы и порядок оплаты товара указаны на сайте в разделе
                    «Оплата». При необходимости порядок и условия оплаты заказанного
                    товара оговариваются Покупателем с менеджером интернет-магазина.
                    Покупатель оплачивает заказ любым способом, выбранным им в
                    интернет-магазине.
                </li>
                <li>7.2. Цена Товара указывается на Сайте в рублях. Цена Товара не
                    включает в себя стоимость доставки. Расчеты производятся в рублях РФ.
                </li>
                <li>7.3. Стоимость доставки указывается отдельной строкой и зависит
                    от региона доставки и иных факторов, устанавливаемых компанией
                    (организацией), предоставляющей курьерские услуги.
                </li>
                <li>7.4. Особенности оплаты Товара с помощью банковских карт
                    и c помощью других способов оплаты через систему приема платежей
                    RBK Money (rbkmoney.ru). В соответствии с положением ЦБ РФ
                    «Об эмиссии банковских карт и об операциях, совершаемых с
                    использованием платежных карт» от 24.12.2004 № 266-П операции
                    по банковским картам совершаются держателем карты либо
                    уполномоченным им лицом.
                </li>
                <li>7.5. Авторизация операций по банковским картам, через платежные
                    терминалы, салоны связи, с помощью электронных денег осуществляется
                    Небанковской Кредитной Организацией «Электронный платежный сервис»
                    (далее - НКО) в соответствии с соглашениями, заключенными между
                    Продавцом и НКО. Если у НКО есть основания полагать, что операция
                    носит мошеннический характер, то НКО вправе отказать в осуществлении
                    данной операции.
                </li>
                <li>7.6. Во избежание случаев различного рода неправомерного
                    использования банковских карт при оплате все Заказы, оформленные
                    на Сайте и предоплаченные банковской картой, проверяются Продавцом.
                    В целях проверки личности владельца и его правомочности на
                    использование карты Продавец вправе потребовать от Покупателя,
                    оформившего такой заказ, предъявления документа, удостоверяющего
                    личность.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">8. ВОЗВРАТ ТОВАРА И ДЕНЕЖНЫХ СРЕДСТВ</p>
            <ul>
                <li>8.1. Возврат Товара осуществляется в соответствии с условиями
                    возврата, указанными на Сайте по адресу
                    https://vitexopt.ru/service/return_change/ и
                    действующим законодательством.
                </li>
                <li>8.2. Возврат Товара надлежащего качества</li>
                <ul>
                    <li>8.2.1. Покупатель вправе отказаться от Товара в любое
                        время до его передачи, а после передачи - в течение 7 (семь)
                        дней. Возврат такого Товара возможен в случае, если сохранены
                        его товарный вид, потребительские свойства и документ, подтверждающий
                        факт и условия покупки товара. Отсутствие у Покупателя документа,
                        подтверждающего факт и условия покупки товара, не лишает его
                        возможности ссылаться на другие доказательства приобретения товара
                        у Продавца.<br>
                        Покупатель не вправе отказаться от товара надлежащего качества,
                        имеющего индивидуально-определенные свойства, если указанный товар
                        может быть использован исключительно приобретающим его потребителем.
                        Не подлежат возврату Товары, перечень которых содержится в Перечне
                        непродовольственных товаров надлежащего качества, не подлежащих
                        возврату или обмену на аналогичный товар других размера, формы,
                        фасона, расцветки или комплектации, утвержденного Постановлением
                        Правительства РФ от 19.01.1998 г. № 55.
                    </li>
                    <li>8.2.2. При отказе Покупателя от Товара надлежащего качества
                        Продавец возвращает Покупателю стоимость возвращенного Товара не
                        позднее чем через 10 дней со дня предъявления Покупателем требования
                        об этом, при этом стоимость доставки такого товара покупателю
                        Продавцом не возмещается.
                    </li>
                </ul>
                <li>8.3. Возврат Товара ненадлежащего качества.</li>
                <ul>
                    <li>8.3.1. Если Покупателю был передан Товар, недостатки которого
                        не были оговорены Продавцом, Покупатель вправе потребовать: замены
                        на товар этой же марки/ другой марки, соразмерного уменьшения
                        цены товара, устранения недостатков товара или отказаться от
                        исполнения договора розничной купли продажи.
                    </li>
                    <li>8.3.2. Требования о возврате уплаченной за товар денежной суммы
                        подлежат удовлетворению в течение 10 календарных дней со дня
                        предъявления соответствующего требования.
                    </li>
                    <li>8.3.3. Возврат денежных средств осуществляется посредством
                        возврата стоимости оплаченного Товара на банковскую карту или
                        почтовым переводом по выбору Покупателя. Способ должен быть
                        указан в соответствующем поле заявления на возврат Товара.
                    </li>
                </ul>
                <li>8.4. В случае возврата доставленного посредством Почты России
                    Товара в связи с наличием претензий к Товару Получатель обязан
                    приложить к Отправлению, содержащему возвращаемый Товар, следующие
                    документы: заявление на возврат денежных средств; копию акта о
                    выявленных несоответствиях; копию квитанции об оплате; копию описи
                    Отправления; бланк возврата.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">9. ОТВЕТСТВЕННОСТЬ</p>
            <ul>
                <li>9.1.Покупатель несет ответственность за предоставление неверных
                    сведений о Товаре, повлекшее за собой невозможность надлежащего
                    исполнения Продавцом своих обязательств перед Покупателем.
                </li>
                <li>9.2. Продавец не несет ответственности за ущерб, причиненный
                    Покупателю вследствие ненадлежащего использования Товаров,
                    приобретенных в Интернет-магазине.
                </li>
                <li>9.3. Продавец не несет ответственности за содержание и
                    функционирование внешних сайтов.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">10. КОНФИДИЦИАЛЬНОСТЬ</p>
            <ul>
                <li>10.1. Персональные данные Пользователя/Покупателя обрабатывается
                    в соответствии с ФЗ «О персональных данных» № 152-ФЗ.
                </li>
                <li>10.2. При регистрации на Сайте Пользователь/Покупатель
                    предоставляет следующую информацию: Ф.И.О., номер телефона,
                    адрес электронной почты, дату рождения, пол, адрес доставки
                    товара.
                </li>
                <li>10.3. Предоставляя свои персональные данные Продавцу,
                    Покупатель соглашается на их обработку Продавцом в целях
                    выполнения Продавцом обязательств перед Покупателем в рамках
                    оферты, продвижения Продавцом товаров и услуг, проведения
                    электронных и sms опросов, контроля результатов рекламных
                    акций, клиентской поддержки, организации доставки товара Покупателю,
                    проведения розыгрышей призов среди Покупателей, анализа покупательских
                    особенностей, оценки качества оказываемых услуг Покупателю и
                    работы сайта.
                </li>
                <li>10.4. Под обработкой персональных данных понимаются любые действия
                    и/или операции, совершаемые с использованием средств автоматизации
                    или без использования таких средств с персональными данными, включая
                    сбор, запись, систематизацию, накопление, хранение, уточнение
                    (изменение) извлечение, использование, передачу (в т.ч. третьим
                    лицам, связанных с исполнением Продавцом обязательств перед
                    Покупателем), обезличивание, блокирование, удаление, уничтожение
                    персональных данных.
                </li>
                <li>10.5. Продавец имеет право отправлять информационные, в том числе
                    рекламные сообщения, на электронную почту и телефон Покупателя с
                    его согласия, выраженного посредством совершения им действий,
                    однозначно идентифицирующих этого абонента и позволяющих достоверно
                    установить его волеизъявление на получение сообщения.
                </li>
                <li>10.6. Покупатель вправе отказаться от получения рекламной и другой
                    информации в любое время, посредством направления соответствующего
                    требования на email Продавца: info@vitexopt.ru.
                </li>
                <li>10.7. Отзыв согласия на обработку персональных данных
                    осуществляется Покупателем, путем направления Продавцу
                    соответствующего письменного требования Почтой России заказным
                    письмом с уведомлением о вручении.
                </li>
                <li>10.7. Продавец получает информацию об ip-адресе посетителя Сайта
                    vitexopt.ru. Данная информация не используется для
                    установления личности посетителя.
                </li>
                <li>10.8. Продавец обязуется не разглашать полученную от
                    Покупателя/Пользователя информацию. Не считается нарушением
                    предоставление Продавцом информации агентам и третьим лицам,
                    действующим во исполнение обязательств Продавца перед
                    Покупателем.
                </li>
                <li>10.9 Продавец вправе использовать технологию "cookies".
                    "Cookies" не содержат конфиденциальную информацию и не передаются
                    третьим лицам.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">11. ЗАКЛЮЧИТЕЛЬНЫЕ ПОЛОЖЕНИЯ</p>
            <ul>
                <li>11.1. Условия оферты могут быть изменены Продавцом в
                    одностороннем порядке в любое время без уведомления об этом
                    Покупателя, в том числе цена Товара, условия и порядок оплаты
                    и доставки Товара.
                </li>
                <li>11.2. Интернет-магазин и предоставляемые сервисы могут временно
                    частично или полностью недоступны по причине проведения
                    профилактических иных, а также по причинам технического характера.
                    Техническая служба Продавца имеет право периодически проводить
                    необходимые работы с предварительным уведомлением Покупателей или
                    без такового.
                </li>
                <li>11.3. В случае возникновения вопросов и претензий со стороны
                    Покупателя вправе обратиться к Продавцу по телефону или иным
                    доступным способом.
                </li>
                <li>11.4. Все возникающие споры Стороны будут стремиться разрешать
                    путем переговоров, а при недостижении соглашения спор будет передан
                    на рассмотрение суда.
                </li>
            </ul>
        </li>
        <li>
            <p class="d-x-large topmargin1">12. РЕКВИЗИТЫ ПРОДАВЦА</p>

            <p class="topmargin1">ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ
                "Витекс"</p>
            <p>ИНН:352507425251 КПП 352501001 ОГРН 1173525018292</p>

            <? $adress = Address::postCodeDecorator(Address::$factAddress); ?>

            <p>Адрес фактический: <?= $adress ?></p>
            <p>Адрес для почты: <?= $adress ?></p>
            <p>р/с 40702810322400003250 </p>
            <p>в Филиал ПАО "Банк УРАЛСИБ" г. Санкт-Петербург </p>
            <p>БИК 044030706</p>
            <p>к/с 30101810800000000706 </p>

            <p class="topmargin1">ОКВЭД 46.42.11</p>
            <p>ОКПО 15857290</p>
            <p>ОКАТО 19401000000</p>
            <p>ОКТМО 19701000001</p>
            <p>ОКОГУ 4210014</p>
            <p>ОКОПФ 12300</p>
            <p>ОКФС 16</p>

            <p class="topmargin1">Директор Вороник Виталий Викторович</p>

        </li>
    </ul>
    <p class="d-xxx-large topmargin2">Политика в отношении обработки
        персональных данных.</p>
    <p>
        Настоящий документ (далее «Политика») описывает условия обработки
        персональных данных (далее «ПДн»), передаваемых Вами в качестве субъекта
        персональных данных (далее «Субъект ПДн») в адрес ООО
        «Витекс» в качестве оператора персональных данных
        (далее «Оператор ПД»). </p>
    <p>Положения Политики действуют только при посещении Субъектом ПДн
        интернет-сайта Оператора ПДн vitexopt.ru..</p>
    <ul class="d-psvd-lst">
        <li><p class="d-x-large topmargin1">1. Обработка и защита персональных
                данных.
            </p></li>
        <li>1.1. Оператор ПДн может осуществлять сбор, систематизацию,
            накопление, хранение, уточнение (обновление, изменение), извлечение,
            использование, блокирование, удаление персональных данных Субъекта ПДн
            в соответствии с действующим законодательством РФ: ст. 24 Конституции
            Российской Федерации, ст. 6 Федерального закона №152-ФЗ «О персональных
            данных» и Гражданским кодексом Российской Федерации в рамках
            правоотношений с Оператором, урегулированных частью второй Гражданского
            Кодекса Российской Федерации от 26 января 1996 г. № 14-ФЗ
        </li>
        <li>1.2. Обработка и хранение персональных данных осуществляются в
            электронном виде с использованием средств автоматизации, так и
            неавтоматизированным способами, с обеспечением конфиденциальности и
            соблюдением положений о защите персональных данных, предусмотренных
            законодательством РФ. Оператор обрабатывает ПДн Субъекта в целях
            соблюдения норм законодательства РФ, а также с целью информирования
            о новых товарах, специальных акциях и предложениях; заключение и
            исполнение условий договора.
        </li>
        <li>1.3. Условия передачи персональных данных:
            <ul>
                <li>- Субъект ПД должен подтвердить свое согласие на обработку
                    персональных данных, передаваемых через любые веб-формы на сайте
                    Оператора ПДн, либо путем заполнения специального поля перед
                    отправкой персональных данных, либо самим фактом отправки данных,
                    если специальное поле отсутствует. Перед отправкой своих
                    персональных данных Субъект ПДн должен ознакомиться с содержанием
                    Политики.
                </li>
                <li>Оператор ПДн размещает в веб-формах на своем сайте ссылку на текст
                    Политики, для того чтобы Субъект ПД имел возможность ознакомиться
                    с содержанием Политики перед отправкой своих персональных данных.
                </li>
                <li>- Субъект ПД дает согласие на обработку Оператором ПДн своих
                    персональных данных, не являющихся специальными или биометрическими,
                    в том числе фамилия, имя, отчество, дата рождения, пол, номера
                    контактных телефонов, адрес проживания, адреса электронной почты,
                    сведения о местоположении, тип и версия операционной системы, тип
                    и версия браузера, тип устройства и разрешение его экрана, источник
                    перехода на сайт, включая адрес сайта-источника и текст размещенного
                    на нем рекламного объявления, язык операционной системы и браузера,
                    список посещенных страниц и выполненных на них действий, IP-адрес.
                </li>
                <li>- Оператор ПДн не обрабатывает персональные данные специальной
                    категории, в том числе данные о политических, религиозных и иных
                    убеждениях, о членстве в общественных объединениях и профсоюзной
                    деятельности, о частной жизни Субъекта ПДн.
                </li>
            </ul>
        </li>
        <li>1.4. Согласие на обработку персональных данных действует бессрочно
            с момента предоставления данных Субъектом ПДн Оператору ПДн и может
            быть отозвано путем подачи заявления Оператору ПДн с указанием сведений,
            определенных ст. 14Федерального закона «О персональных данных». Отзыв
            согласия на обработку персональных данных может быть осуществлен путем
            направления Субъектом ПДн соответствующего заявления Оператору ПДн в
            свободной письменной форме по адресу www.specodegda.ru.
        </li>
        <li>1.5. Оператор назначает ответственного за организацию обработки
            персональных данных для выполнения обязанностей, предусмотренных ФЗ
            «О персональных данных» и принятыми в соответствии с ним нормативными
            правовыми актами, применяет комплекс правовых, организационных и
            технических мер по обеспечению безопасности персональных данных для
            обеспечения конфиденциальности персональных данных и их защиты от
            неправомерных действий.
        </li>
        <li><p class="d-x-large topmargin1">2. Передача персональных данных.
            </p></li>
        <li>2.1 Оператор ПДн предоставляет доступ к персональным
            данным только Субъекту ПД либо его законному представителю в
            соответствии с требованием законодательства РФ.
        </li>
        <li>2.2 Оператор ПДн не передает персональные данные, полученные от
            Субъекта ПД, третьим лицам, за исключением случаев, связанных с
            исполнением Оператором обязательств перед Субъектом ПДн по отношениям
            купли-продажи, а также предусмотренных действующим законодательством РФ.
        </li>
        <li><p class="d-x-large topmargin1">3. Права Субъекта ПДн.</p></li>
        <li>3.1. Субъект ПД или его законный представитель вправе требовать
            уточнения персональных данных в случае, если они изменились или если
            при их предоставлении были допущены неточности.
        </li>
        <li>3.2. Субъект ПД или его законный представитель вправе требовать
            блокировки или уничтожения предоставленных персональных данных в случае
            отказа от дальнейшего обслуживания Оператором ПД и посещения его интернет-сайта.
        </li>
    </ul>


</div>

@endsection