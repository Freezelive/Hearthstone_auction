      var x = document.cookie;
      if (!x.includes("user"))
        window.location = "./Login.html";

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}