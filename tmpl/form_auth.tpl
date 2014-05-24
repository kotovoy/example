			%message%
            <form name="auth" action="%address%functions.php" method="post">
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                		<td>
                        	Логин:
                        </td>
                        <td>
                        <input type="text" name="login" /><br />
                  		</td>
                    </tr>
                    <tr>
                		<td>
                        	Пароль:
                        </td>
                        <td>    
                            <input type="password" name="password" /><br />
                  		</td>
                    </tr>
                    <tr>
                		<td colspan="2">
                        	<input type="submit" class="login_btn" name="auth" value="Войти" />
                 
                        	<a href="%address%?view=reg">Зарегистрироваться</a>
                        </td>
                    </tr>
              	</table>          
            </form>