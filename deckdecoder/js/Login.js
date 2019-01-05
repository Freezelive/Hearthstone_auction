function CreateAdventurer(){
    var PlayerName=document.getElementById("inputName").value;

    jQuery.ajax({
        url: "./server/Login.php",
        data: { name: PlayerName },
        type: "POST",
        success: function (response) {
            if (response.includes("Great!"))
                window.location = "./index.html";

        },
        error: function (response) {
            alert("NOT GUD");
            alert(response);

        }
    });
}