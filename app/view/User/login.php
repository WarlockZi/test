<main>

	<?if(isset($_SESSION['msg']))echo $_SESSION['msg']?>
    <form  action = '#' method="post" class = "form-container">
        <h1 class = "form-title">Вход на сайт</h1>
			<input class = "form-input" type="email" placeholder="E-mail" value="<?= isset($_SESSION['reg']['email']) ? $_SESSION['reg']['email'] : ''; ?>"/>
			<input class = "form-input" type="password"  placeholder="Пароль" />
			<input class = "form-input submit" type="submit"  id = "login" value="Войти"/>
			<input type = "hidden" name="token" value = <?=$token?>>
        <ul class="bottom">
            <li>
                <a class = "register" href="<?= PROJ ?>/user/register">Регистрация</a>
            </li>
            <li>
                <a class = "forgot" href="<?= PROJ ?>/user/returnpass">Забыли пароль</a>
            </li>
        </ul>
	</form>


</main>
<style>

/*************************
*******     Forms  ******
**************************/

.form-container{
    display: flex;
    flex-flow: column wrap;
    padding: 35px 30px 15px 30px;
    background: #eee;
    width: 300px;
    margin: 3% auto;
    align-items: stretch;
}
.form-title{
    font-weight: bold;
    font-size: 120%;
    text-align: center;
    color: #949494;
    margin-bottom: 20px;
}

.form-input {
    background: #f7f7f7;
    border-radius: 0;
    border-bottom: 1px  solid #ccc;
    border-left:0;
    border-top: 0;
    border-right: 0;
    flex:1;
    margin: 10px 0;
    padding: 12px;
    width: 100%;
    box-sizing: border-box;
    color:#757575;
}



.submit
{
    padding: 14px;
    background: rgba(0,0,0,0.15);
    text-align: center;
    font-weight: 600;

}
.submit:hover{
    background: #adadad;
    color: #fff;
}


.bottom{
    display: flex;
    align-items: center;
}
.bottom li{
    flex: 1;
    text-align:  center;
    display:flex;
}

.bottom li a {
    color: #949494;
    flex-basis: 100%;
    padding: 10px 3px;
}
.bottom li a:hover {
    color: #fff;
    background-color: #ccc;
}

/*/////////////////// POP UP   ///////////////*/


.overlay{
    width:100%;
    height:100%;
    background-color:#000;
    z-index: 1000;
    position:fixed;
    top:0;
    left:0;
    opacity:0.5;


}


.messageBox{
    display: flex;
    flex-direction:column;
    width: 30%;
    min-width: 241px;
    position: fixed;
    top: 10vw;
    left: 30%;
    background-color: #eff4ee;
    z-index: 10001;
    line-height: 25px;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
}
.messageBox>div{
    padding: 10px;
}

.messageTitleBar{
    display: flex;
    text-transform:uppercase;

}
.messageTitle{
    flex:1;
    color: #80868e;
    padding-left: 20px;
    font-weight: 800;
}

.messageClose{
    display: flex;
    justify-content: center;
    flex: 1;
    transition: .5s;
    color: #494949;
    background: #ccc;
    text-transform: uppercase;
    font-weight: 800;
    cursor: pointer;
}
.messageClose:hover{
    background: #4cb000;
    transition:.3s;
    color: #000;
    font-weight: 800;
}

.msg div{
    color: #6e6e6e;
    font-size: 20px;
    padding: 0 30px;
}
.msg{
    min-height:100px;
    background: #fff;
}

.msg a{
    text-decoration: underline;
    color: #1d5bff;
    font-weight: 800;
    padding: 3px;
}


</style>
