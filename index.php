<?php
    include 'header.php';
?>
    <!-- -------------------------LEVO----------------------- -->
<div class="container">
    <div class="levo">
        <!-- ------MAP-------- -->
        <div class="map animate__animated animate__jackInTheBox" >
            <img id="map-slika-slovenije" src="media/slovenia-map3-mini.png" alt="slovenia-map2-mini" usemap="#workmap">
            <map id="map_id" name="workmap" >
                <!-- Pomurska -->
                <div id="pomurska">
                    <area shape="rect" alt="" coords="796,0,959,106" >
                    <area shape="rect" alt="" coords="824,107,987,133" >
                    <area shape="rect" alt="" coords="849,134,1011,160" >
                </div>
                <img src="media/pomurska.png" alt="pomurska" id="pomurska_sijaj">
                <!-- Podravska -->
                <div id="podravska" >
                    <area shape="rect" alt="" coords="659,53,795,213" >
                    <area shape="rect" alt="" coords="684,214,848,243" >
                    <area shape="rect" alt="" coords="796,107,823,213" >
                    <area shape="rect" alt="" coords="824,134,848,213" >
                    <area shape="rect" alt="" coords="849,161,930,213" >
                    <area shape="rect" alt="" coords="629,105,658,187" >
                    <area shape="rect" alt="" coords="767,244,793,270" >
                </div>
                <img src="media/podravska.png" alt="pomurska" id="podravska_sijaj">
                <!-- Koroška -->
                <div id="koroska">
                    <area shape="rect" alt="" coords="438,105,628,187" >
                    <area shape="rect" alt="" coords="528,81,658,104" >
                </div>
                <!-- Savinjska -->
                <div id="savinjska">
                    <area shape="rect" alt="" coords="383,162,437,212" >
                    <area shape="rect" alt="" coords="411,213,683,242" >
                    <area shape="rect" alt="" coords="438,188,658,212" >
                    <area shape="rect" alt="" coords="466,243,766,270" >
                    <area shape="rect" alt="" coords="548,271,713,298" >
                    <area shape="rect" alt="" coords="576,299,726,326" >
                </div>
                <!-- Zasavska -->
                <div id="zasavska">
                    <area shape="rect" alt="" coords="466,271,547,298">
                    <area shape="rect" alt="" coords="438,299,575,326">
                    <area shape="rect" alt="" coords="491,327,547,354">
                </div>
                <!-- Posavska -->
                <div id="posavska">
                    <area shape="rect" alt="" coords="548,327,739,354">
                    <area shape="rect" alt="" coords="576,355,739,382">
                    <area shape="rect" alt="" coords="631,383,739,433">
                </div>
                <!-- jugo-vzhodna-slo -->
                <div id="jugo-vzhodna-slo">
                    <area shape="rect" alt="" coords="466,383,630,573">
                    <area shape="rect" alt="" coords="491,355,575,382">
                    <area shape="rect" alt="" coords="357,439,465,573">
                </div>
                <!-- Primorsko-notranjska -->
                <div id="primorsko-notranjska">
                    <area shape="rect" alt="" coords="219,409,356,573">
                </div>
                <!-- Goriska -->
                <div id="goriska">
                    <area shape="rect" alt="" coords="23,327,218,438">
                    <area shape="rect" alt="" coords="50,271,187,326">
                    <area shape="rect" alt="" coords="0,220,111,270">
                    <area shape="rect" alt="" coords="26,190,134,219">
                    <area shape="rect" alt="" coords="50,160,78,189">
                </div>
                <!-- obalno-kraska -->
                <div id="obalno-kraska">
                    <area shape="rect" alt="" coords="50,439,218,599">
                </div>
                <!-- gorenjska -->
                <div id="gorenjska">
                    <area shape="rect" alt="" coords="188,164,298,326">
                    <area shape="rect" alt="" coords="135,136,187,270">
                    <area shape="rect" alt="" coords="112,220,134,270">
                    <area shape="rect" alt="" coords="79,136,134,189">
                    <area shape="rect" alt="" coords="219,327,243,354">
                    <area shape="rect" alt="" coords="299,192,382,270">
                    <area shape="rect" alt="" coords="299,271,329,299">
                </div>
                <!-- osrednje-slovenska -->
                <div id="osrednje-slovenska">
                    <area shape="rect" alt="" coords="383,213,410,242">
                    <area shape="rect" alt="" coords="383,243,465,270">
                    <area shape="rect" alt="" coords="330,272,465,299">
                    <area shape="rect" alt="" coords="299,300,438,326">
                    <area shape="rect" alt="" coords="244,327,490,354">
                    <area shape="rect" alt="" coords="219,355,490,382">
                    <area shape="rect" alt="" coords="219,383,465,408">
                    <area shape="rect" alt="" coords="357,409,465,438">
                </div>
        </map>
        </div>
    </div>

    <!-- -------------------------DESNO-------------------------->

    <div class="desno">
        <div class="content-desno">
        <div class="login_register_regija">
            <h2>Tvoja regija</h2>
            <p id="desc">Slovenija</p>
        </div>
        <!-- ///////////////// -->
        <div id="form_div">
            <div class="user_boxa" id="register-box">
                <progress id="psbar" value="0" max="3"></progress>
                <form id="regi_form" action="includes/signup.inc.php" method="post">
                    <!-- -------------------------reg_box1-------------------------->
                    <div id="reg_box1" style=" display: block;">
                        <div class="inputBx">
                            <input class="checking_email" id="email" type="email" name="email" placeholder="*email...">
                            <div class="error_email error_reg"></div>
                        </div>
                        <div class="inputBx inputBx_submit">
                            <button type="button" id="reg_box1_btn" class="login_button" onclick="RegSwitchBox(); progress_bar();">Naprej</button>
                        </div>
                    </div>
                    <!-- -------------------------reg_box2-------------------------->
                    <div id="reg_box2" style="display: none;">
                        <div class="inputBx">
                            <input class="checking_username" type="text" name="username" placeholder="*uporabniško ime...">
                            <div class="error_username error_reg"></div>
                        </div>
                        <div class="inputBx">
                            <input type="password" name="pwd" placeholder="*geslo...">
                        </div>
                    </div>
                    <!-- -------------------------reg_box3-------------------------->
                    <div id="reg_box3" style="display: none;">
                        <div class="inputBx">
                            <input type="password" name="pwdrepeat" placeholder="*ponovi geslo...">
                        </div>
                        <div class="inputBx inputBx_submit">
                            <button id="register_sub_btn" type="button" class="login_button" onclick="RegSwitchBox(); progress_bar2();">Naprej</button>
                        </div>
                    </div>
                    <!-- -------------------------reg_box4-------------------------->
                    <div id="reg_box4" style="display: none;">
                        <div class="inputBx">
                            <input type="text" name="firstname" placeholder="ime...">
                        </div>
                        <div class="inputBx">
                            <input type="text" name="lastname" placeholder="priimek...">
                        </div>
                        <div class="inputBx">
                            <input type="text" placeholder="datum rojstva..." name="datumroj" id="tempdate" onclick="dateswitch()">
                        </div>
                        <div class="inputBx_submit lastbuttons">
                            <button id="final_sub_back_btn" onclick="nazaj()" type="button">Nazaj</button>
                        </div>
                        <div class="inputBx_submit lastbuttons">
                            <button id="final_sub_reg_btn" type="button" onclick="regsubmit(); return false;">Vpiši se</button>
                        </div>
                    </div>
                    <!-- -------------------------ze imas racun ?-------------------------->
					<p class="switchbox_link">Že imaš racun? <a href="#" onclick="switchbox()">Prijavi se...</a></p>
				</form>
            </div>
            <div style="display: none;" id="reg_loader"></div>
            <div style="display: none;" id="reg_loader2"></div>
            <br>
            <br>
            <div class="user_boxa" id="login-box">
                <form action="includes/login.inc.php" method="post" id="login_form">
                    <div class="inputBx">
                        <input type="text" name="email" placeholder="username/email...">
                    </div>
                    <div class="inputBx">
                        <input type="password" name="pass" placeholder="geslo...">
                    </div>
                    <div class="inputBx inputBx_submit">
                        <button type="submit" name="submit_login" class="login_button">Login</button>
                    </div>
                </form>
                <div id="login_text_bottom">
                    <p id="regi_forgot_pwd">Si pozabil <a href="#">geslo?</a></p>
                    <p class="switchbox_link">A še nimaš racuna? <a href="#" onclick="switchbox()">Registriraj se...</a></p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- -------------------------javascript-------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="js/main.js"></script>
<script src="js/user_check.js"></script>
<script src="js/imageMapResizer.min.js"></script>
<script>$('map').imageMapResize();</script>
<!-- -------    ------------------footer-------------------------->
<?php
    include 'footer.php';
?>