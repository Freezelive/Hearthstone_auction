    var string = "";
    function formsubmit() {
        var blob = document.getElementById("DeckString").value;
        jQuery.ajax({
            url: "./server/DeckDecode.php",
            data: { deck: blob },
            type: "POST",
            success: function (response) {
                print_list(response);
            },
            error: function (response) {
                alert("NOT GUD");
                
            }
        });
    }
    function print_list(str) {
        hide('inputForm');
        var string = JSON.parse(str);
        var table = document.getElementById("table");
        var rare = 0;
        var common = 0;
        var legendary = 0;
        var free = 0;
        var epic=0;

        for (var i = 0; i < string.cards.length; i++) {
                
                var div = document.createElement("div");
                div.setAttribute("class", "row");
                div.setAttribute("onMouseOver",'show('+i+');');
                div.setAttribute("onMouseOut",'hide('+i+');');
                document.getElementById("table").appendChild(div);

                var cellName = document.createElement("div");
                cellName.setAttribute("class", "col-sm-4");
                cellName.innerHTML = string.cards[i].name;
                div.appendChild(cellName);

                var cellRarity = document.createElement("div");
                cellRarity.setAttribute("class", "col-sm-4");
                cellRarity.innerHTML = string.cards[i].rarity;
                div.appendChild(cellRarity);

                var cellCount = document.createElement("div");
                cellCount.setAttribute("class", "col-sm-4");
                cellCount.innerHTML = string.cards[i].count;
                div.appendChild(cellCount);

                var cellImg = document.createElement("div");
                cellImg.setAttribute("class", "col-sm-4");
                //Getting the image from the main server by using the link and the card ID
                var link = "http://media.services.zam.com/v1/media/byName/hs/cards/enus/" + string.cards[i].id + ".png";
                cellImg.innerHTML = "<img src=" + link + ' style="display:none;" id="'+i+'">';
                div.appendChild(cellImg);

                if (compareStrings(string.cards[i].rarity,"RARE"))
                    rare=rare+parseInt(string.cards[i].count);
                else
                    if (compareStrings(string.cards[i].rarity,"FREE"))
                        free=free+parseInt(string.cards[i].count);
                    else
                        if (compareStrings(string.cards[i].rarity,"COMMON"))
                            common=common+parseInt(string.cards[i].count);
                        else
                            if (compareStrings(string.cards[i].rarity,"EPIC"))
                                epic=epic+parseInt(string.cards[i].count);
                            else
                                legendary=legendary+parseInt(string.cards[i].count);
            }

            var div = document.createElement("div");
                div.setAttribute("class", "card-deck mb-4 text-center");
                document.getElementById("main").appendChild(div);

                printBoxes("free", free, div);
                printBoxes("common", common, div);
                printBoxes("rare", rare, div);
                printBoxes("epic", epic, div);
                printBoxes("legendary", legendary, div);

                show("verifbutt");


    }

    function printBoxes(type, count, div)
    {
        var cell = document.createElement("div");
        cell.setAttribute("class", "card mb-4 shadow-sm");
        
        var title = document.createElement("div");
        title.setAttribute("class", "card-header");
        title.innerHTML = "Total " + type;
        cell.appendChild(title);
        cell.id = type;

        var body = document.createElement("div");
        body.setAttribute("class", "card-body");
        body.innerHTML = count;
        
        cell.appendChild(body);

        div.appendChild(cell);


        cell.innerHTML = "Total "+type+": " + count;


    }
    function show(i) {
        document.getElementById(i).style.display = 'block';
    }
    function hide(i) {
        document.getElementById(i).style.display = 'none';
    }

    function compareStrings (string1, string2) {

        string1 = string1.toLowerCase();
        string2 = string2.toLowerCase();

        return string1 === string2;
}

    function Verify(){
        
        var nameCook = "Vlad";//GET AN ACTUAL NAME FROM LE COOKIE OR STH
        jQuery.ajax({
            url: "./server/Verify.php",
            data: { name: nameCook },
            method: "POST",
            success: function (response) {
                var string = JSON.parse(response);
                alert(string.Epic);
                if (Validate(parseInt(string.common), parseInt(string.rare), parseInt(string.Epic), parseInt(string.Legendary))) {
                    alert("OK!");
                }
                
                else
                    alert("NOT OK, M8");

            },
            error: function (response) {
                alert("NOT GUD");

            }
        });

    }

    function Validate(common,rare,epic,legendary)
    {
        var valid = true;
        if (common <= parseInt(document.getElementById("common").innerHTML.split(": ")[1])) {
            alert(document.getElementById("common"));
            valid = false;
        }
        else
            document.getElementById("common").style = "background:red;";
        if(rare<=parseInt(document.getElementById("rare").innerHTML.split(": ")[1]))
        {
            alert(document.getElementById("rare"));
            valid = false;
        }
        else
        if(epic<=parseInt(document.getElementById("epic").innerHTML.split(": ")[1]))
        {
            alert(document.getElementById("epic").innerHTML);
            valid = false;
        }
        else
        if(legendary<=parseInt(document.getElementById("legendary").innerHTML.split(": ")[1]))
        {
            alert(legendary);
            alert(document.getElementById("legendary").innerHTML);
            valid = false;
        }

        return valid;

    }