<div class="col-md-12"> 
  <div class="panel panel-primary">
        <div class="panel-heading" href="#register">
          <h3 class="panel-title">Registrera</h3>
        </div>
        <div id="register">
        <form action="/register/send" method="POST">
            <div class="form-group">
           <fieldset>
                        <label for="Username">Användarnamn </label><br/>                   
                        <input type="text" name="username" class="form-control" placeholder="Namnet du loggar in med" id="Username" required><br/>
                
                        <label for="Password">Lösenord </label><br/> 
                        <input type="password" name="password" class="form-control" placeholder="Password" id="Password" required>     <br/>       
                  
                        <label for="Email"> E-mail</label>
                  
                        <input type="email" name="email" class="form-control" placeholder="Email" id="Email" required><br/>
                
                        <label for="Alias"> Alias </label>
                  
                        <input type="text" name="alias" class="form-control" placeholder="Namnet andra ser" id="Alias" required><br/>
                    
                        <label for="Firstname">Förnamn </label>
                  
                        <input type="text" name="firstname" class="form-control" placeholder="Förnamn" id="Firstname" required><br/>
                  
                        <label for="Surname">Efternamn </label>
                  
                        <input type="text" name="surname" class="form-control" placeholder="Efternamn" id="Surname" required><br/>
               
                        <label for="Date">Födelsedatum </label>
                  
                        <input type="date" name="birthday" class="form-control" placeholder="åååå-mm-dd" min="1899-11-28" max="<?php echo date('Y-m-d'); ?>" id="Date" required><br/>
              
                        <a href="/register/terms">Användarvillkor</a>
                  
                        <input type="checkbox" name="terms" id="terms"><br/>
                 
                <div class="g-recaptcha" id="g-recaptcha-register" data-sitekey="6Lf6aQgUAAAAAMp-uBJa-Fg6m-tGx04qfUyTYdoN"></div><br/>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" name="submit" value="Registrera">
                </div>
            </div>
            </fieldset>
        </form>
        <script src='https://www.google.com/recaptcha/api.js'></script>