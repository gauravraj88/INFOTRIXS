$(document).ready(function () {
    $("#myForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        var data = {
            email: $("#email").val(),
            password: $("#password").val()
        };

        $.ajax({
            url: "http://localhost/ChatApp/PHP_BACKEND/Login.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (response) {
                if (response.status === "success") {
                    alert("Successfully signed in");
                    window.location.href = response.redirect;
                } else {
                    alert("Login failed: " + response.message);
                    console.log(response.message);
                    console.log(response.status);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error sending data to the server:", error);
                console.log("Status: " + status);
                console.log("Response Text: " + xhr.responseText);
                alert("Error occurred while signing in");
            }
        });
        // console.log(data);
        console.log(JSON.stringify(data));
    });
});