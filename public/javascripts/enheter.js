(function onload() {
  const companyTable = document.querySelector("#tabell");
  const form = document.querySelector('form');
  const tableBody = document.querySelector("#tabell > tbody");
  const searchField = document.querySelector('input[type=search]');
  const previousPageButton = document.querySelector('#prev');
  const nextPageButton = document.querySelector('#next');


  const baseURL = "https://hotell.difi.no/api/json/brreg/enhetsregisteret";
  let queryPage = 1;

  const addResultRows = ({entries, page, pages}) => {
    const rows = entries.map(({ navn, orgnr }) => {
      const row = document.createElement("tr");
      const navnCell = document.createElement("td");
      const orgnrCell = document.createElement("td");

      navnCell.innerText = navn;
      orgnrCell.innerText = orgnr;

      row.append(navnCell, orgnrCell);
      return row;
    });
    return rows;
  };

  const handleOnSubmit = async (event) => {
    companyTable.hidden = true;
    tableBody.innerHTML = "";
    event.preventDefault();
    const url = `${baseURL}?query=${searchField.value}&page=${queryPage}`;
    try {
      const request = await fetch(url);
      const { entries, page, pages } = await request.json();
      const resultRows = addResultRows({entries, page, pages});
      resultRows.forEach(row => tableBody.append(row))
      companyTable.hidden = false;
      nextPageButton.disabled = page === pages;
      previousPageButton.disabled = page < pages;
    } catch (error) {
      console.error(error);
    }
  };

  const nextPage = (event) => {
    queryPage += 1;
    handleOnSubmit(event);
  };

  const previousPage = (event) => {
    queryPage -= 1;
    handleOnSubmit(event);
  }

  nextPageButton.onclick = nextPage;
  previousPageButton.onclick = previousPage;

  form.onsubmit = handleOnSubmit;
  
})();
