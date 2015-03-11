                    <div class="clear">
                        
                    </div>
                    
                    <div id="access">
                        
                        <?php
                           echo("Last Accessed : ");
                           $currentFile = $_SERVER['PHP_SELF'];
                           echo("<br/>Currently you are on : ");
                           echo ($currentFile);
                           echo("<br/>Your IP address : ".$_SERVER['REMOTE_ADDR']);
                           echo("<br/>Your Screen Resolution : <script type='text/javascript'>document.write(screen.width);document.write(' X ');document.write(screen.height);</script>");
                          
                           $str = $_SERVER['HTTP_USER_AGENT'];
                           echo("<br/>Your Browser Name : ");
                           if(@strpos($str,'Chrome')){
                                $browser = 'chrome';
                           }
                           else if(@strpos($str,'Safari')){
                                 $browser = 'safari';
                           }
                           else if(@strpos($str,'Firefox')){
                                 $browser = 'firefox';
                           }
                           else if(@strpos($str,'Presto')){
                                 $browser = 'opera';
                           }
                           else {
                                 $browser = 'Internet Explorer';
                           }
                          echo($browser);
                          echo("<br/>Your Browser Info : ".$str);
                        ?>
                    </div>

            </div>
        </div>
    </body>
</html>