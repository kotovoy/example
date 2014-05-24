 			<h4>Регистрация</h4>
            
            %message%
            
                           
                <div id="contact_form">

                <form method="post" name="reg" action="%address%functions.php">
                
                    <label for="login">Логин:</label> <input type="text" id="login" name="login" value="%login%" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="pass">Пароль:</label> <input type="password" id="pass" name="pass" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="pass2">Повторите пароль:</label> <input type="password" id="pass2" name="pass2" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="email">Email:</label> <input type="text" id="email" name="email" value="%email%" class="validate-email required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="name">Имя:</label> <input type="text" id="name" name="name" value="%name%" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="surname">Фамилия:</label> <input type="text" id="surname" name="surname" value="%surname%" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <label for="group">Группа:</label> <input type="text" id="group" name="group" value="%group%" class="required input_field" />
                    <div class="cleaner h10"></div>
                    
                    <img src="captcha.php" alt="Каптча" />
                    
                    <div class="cleaner h10"></div>
                    
                    <label for="captcha">Проверочный код:</label> <input type="text" id="captcha" name="captcha" class="required input_field" />
                    <div class="cleaner h10"></div>

                    
                    <input type="submit" class="submit_btn" name="reg" id="reg" value="Зарегестрироваться" />
                
                </form>
                
                </div> 