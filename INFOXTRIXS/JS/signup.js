$(document).ready(function () {

    var password;

    $("#myForm").submit(function (event) {
        event.preventDefault();
        var pass1 = $("#password_1").val();
        var pass2 = $("#password_2").val();

        if (pass1 === pass2) {
            password = pass1;

            var FormDeta = {
                email: $("#email").val(),
                name: $("#name").val(),
                surname: $("#surname").val(),
                date: $("#date").val(),
                gender: $("#gender").val(),
                password: password
            }

            $.ajax({
                url: "http://localhost/ChatApp/PHP_BACKEND/signin.php",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(FormDeta),
                success: function (response) {
                    alert("Successfully signed up");
                    window.location.href = response.redirect;
                },
                error: function (error) {

                    console.error("Error sending data to the server:", error);
                },
            });
        } else {
            alert("Both passwords must be the same");
            return;
        }
    });
});