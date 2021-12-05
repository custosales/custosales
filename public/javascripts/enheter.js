window.onload = function onload() {
  const div1 = document.querySelector("#div1");
  const companyTable = document.querySelector("#div2");

  const createCompanyTable = (enheter) => {
    const table = document.createElement("table");
    const tableHeader = document.createElement("tr");
    const navn = document.createElement("th");
    const orgnr = document.createElement("th");

    table.id = "tabell";
    table.className = "tabell";

    navn.innerHTML = "Navn";
    navn.className = "th";

    orgnr.innerHTML = "Orgnummer";
    orgnr.className = "th";

    tableHeader.append(navn, orgnr);
    table.append(tableHeader);

    enheter.forEach((enhet) => {
      const row = document.createElement("tr");
      const navnCell = document.createElement("td");
      const orgnrCell = document.createElement("td");

      navnCell.innerText = enhet.navn;
      orgnrCell.innerText = enhet.orgnr;

      row.append(navnCell, orgnrCell);
      table.append(row);
    });

    companyTable.innerHTML = table.outerHTML;
  };

  const handleOnSend = async (event) => {
    const brregURL =
      "https://hotell.difi.no/api/json/brreg/enhetsregisteret?query=";
    const query = `${brregURL}${searchField.value}`;

    try {
      const request = await fetch(query);
      const { entries: enheter } = await request.json();
      createCompanyTable(enheter);
    } catch (error) {
      console.error(error);
    }
  };

  const createSearchSection = () => {
    const handleOnSearch = (event) => {
      if (event.key !== "Enter") return;
      event.preventDefault();

      if (!searchField.value) {
        alert("Tast inn firmanavn eller orgnummer ");
        searchField.focus();
        return;
      }
      sendBtn.click();
    };

    const sendButton = document.createElement("button");
    const searchField = document.createElement("input");
    const label = document.createElement("label");

    sendButton.className = "btn btn-success";
    sendButton.innerText = "Søk";
    sendButton.addEventListener("click", handleOnSend);

    searchField.type = "search";
    searchField.id = "sokefelt";
    searchField.placeholder = "Søk etter navn eller orgnummer";
    searchField.addEventListener("keyup", handleOnSearch);

    label.innerText = "Søk i enhetsregisteret:";
    label.htmlFor = "sokefelt";

    div1.append(label, searchField, sendButton);
  };

  div1.innerHTML = "";
  companyTable.innerHTML = "";

  createSearchSection();

  const searchField = document.querySelector("#sokefelt");

  searchField.focus();
};
