function updateData(){

    jQuery.ajax({
        url: "./server/Auction.php",
        type: "POST",
        data: { name: getCookie("user") },
        success: function (response) {
            var string = JSON.parse(response);
            var rare = string['rare'];
            var common = string['common'];
            var legendary = string['legendary'];
            var epic = string['epic'];
            var maxbetOwner = string['maxBid'];
            var dust = string['dust'];
            var price = string['price'];

            var div = document.createElement("div");
            div.setAttribute("class", "card-deck mb-4 text-center");
            document.getElementById("main").appendChild(div);

            printBoxes("Dust remaining", dust, div);
            if (common != 0)
                printBoxes("Common", common, div);
            if (rare != 0)
                printBoxes("Rare", rare, div);
            if (epic != 0)
                printBoxes("Epic", epic, div);
            if (legendary != 0)
                printBoxes("Legendary", legendary, div);
            printBoxes("Current Price", price, div);
            if (!maxbetOwner.includes("none"))
                printBoxes("Current Owner", maxbetOwner, div);
        },
        error: function (response) {
            alert("NOT GUD");
        }
    });

    //setInterval(updateData(), 10000);
    //update();
}

function formsubmitBet(){
    
}