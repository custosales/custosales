window.onload = function () {

    div2.innerHTML = "";
    div1.innerHTML = '<label for="sokefelt">Søk i enhetsregisteret: </label> ' +
        '<input type="text" id="sokefelt" placeholder="Søk etter navn eller orgnummer">' +
        ' <button id="send" class="btn btn-success">Søk</button>';
    document.getElementById("sokefelt").focus();

    document.getElementById("sokefelt").addEventListener("keyup", function (event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            if (document.getElementById("sokefelt").value == "") {
                alert("Tast inn firmanavn eller orgnummer ")
                document.getElementById("sokefelt").focus();
            } else {
                document.getElementById("send").click();
            }
        }
    });

    document.getElementById("send").addEventListener('click', function () {

        let query = "https://hotell.difi.no/api/json/brreg/enhetsregisteret?query=" + document.getElementById("sokefelt").value;
        // console.log(query);
        div2.innerHTML = "<table id='tabell' class='tabell'></table>";
        fetch(query)
            .then(resp => resp.json())
            .then(data => {
                let enheter = data.entries;
                //   console.log(enheter);
                let th = tabell.insertRow();
                let navn = th.insertCell(0);
                navn.innerHTML = "Navn";
                navn.className = "th";
                let orgnr = th.insertCell(1);
                orgnr.innerHTML = "Orgnummer";
                orgnr.className = "th";

                return enheter.map(a => {
                    let tr = tabell.insertRow();
                    let navnData = tr.insertCell(0);
                    navnData.innerHTML = a.navn;
                    let orgnrData = tr.insertCell(1);
                    orgnrData.innerHTML = a.orgnr;
                });


            })


    })

        .catch(function () {
            console.error("Noe gikk galt")
        });
}
