$(document).ready(function () {

    $('.checking_email').keyup(function (e) {
        var email = $('.checking_email').val();

        $.post('includes/usercheck.inc.php', {email_id: email},
            function(response){
                //odstrani email iz response
                var formatted = response.replace(email, "");
                $('.error_email').text(formatted);

                if(formatted == " email je že uporabljen*") {
                    $('#reg_box1_btn').attr("disabled", true);
                    $('#reg_box1_btn').css('opacity', 0.5);

                    $('#register_sub_btn').attr("disabled", true);
                    $('#register_sub_btn').css('opacity', 0.5);
                }
                else {
                    $('#reg_box1_btn').attr("disabled", false);
                    $('#reg_box1_btn').css('opacity', 1);

                    $('#register_sub_btn').attr("disabled", false);
                    $('#register_sub_btn').css('opacity', 1);
                }
            });
    });
});
$(document).ready(function () {

    $('.checking_username').keyup(function (e) {
        var username = $('.checking_username').val();

        $.post('includes/usercheck2.inc.php', {username_id: username},
            function(response){
                //odstrani username iz response
                var formatted = response.replace(username, "");
                $('.error_username').text(formatted);

                if(formatted == " uporabniško ime je že uporabljeno*") {
                    $('#register_sub_btn').attr("disabled", true);
                    $('#register_sub_btn').css('opacity', 0.5);
                }
                else {
                    $('#register_sub_btn').attr("disabled", false);
                    $('#register_sub_btn').css('opacity', 1);
                }
            });
    });
});