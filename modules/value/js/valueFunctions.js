import { get } from "../../../utils/fetchLib";

function showClients(companyStatus, salesRepID) {
  get(
    `modules/value/display_companies.php?companyStatus=${companyStatus}&salesRepID=${salesRepID}`
  ).then((res) => {
    document.getElementById("reportArea").innerHTML = res;
    contactsTable = $("#clients").dataTable({
      bJQueryUI: true,
      bStateSave: true,
      iDisplayLength: 25,
      sPaginationType: "full_numbers",
      oLanguage: {
        sLengthMenu: lLengthMenu,
        sZeroRecords: lZeroRecords,
        sInfo: lInfo,
        sInfoEmpty: lInfoEmpty,
        sInfoFiltered: lInfoFiltered,
        sSearch: lSearch,
        oPaginate: {
          sFirst: lFirst,
          sPrevious: lPrevious,
          sNext: lNext,
          sLast: lLast,
        },
      },
    });
  });
}

function displayCompanyMain(regNumber) {
  document.getElementById("reportArea").innerHTML = get(
    `modules/value/display_company_main.php?regNumber=${regNumber}`
  );
}

function getAccounts(regNumber, companyName, companyCity) {
  document.getElementById("AccountArea").innerHTML = get(
    `modules/value/get_accounts.php?regNumber=${regNumber}&companyName=${companyName}&companyCity=${companyCity}`
  );
}
