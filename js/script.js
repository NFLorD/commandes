// LIENS vers les COMMANDES
const links = document.querySelectorAll(":scope td>a");
const sInput = document.getElementById("secretInput");
const sForm = document.getElementById("hiddenForm");

links.forEach(link =>
  link.addEventListener("click", function(e) {
    e.preventDefault();
    sInput.value = link.textContent;
    sForm.submit();
  })
);

// NEXT -- PREVIOUS PAGE
const next = document.getElementById("next");
const previous = document.getElementById("previous");

next.addEventListener("click", function(e) {
  e.preventDefault();
});

previous.addEventListener("click", function(e) {
  e.preventDefault();
});

// TRIER PAR
const orderForm = document.getElementById("orderForm");
const orderSelector = document.getElementById("orderSelector");
const orderDirection = document.getElementById("orderDirection");
const resultsSelector = document.getElementsByName("numberOfResults");

// COLONNE
orderSelector.addEventListener("change", function() {
  orderForm.submit();
});

// DIRECTION
orderDirection.addEventListener("change", function() {
  orderForm.submit();
});

// NOMBRE DE RESULTATS
resultsSelector.forEach(radioBtn =>
  radioBtn.addEventListener("click", function() {
    orderForm.submit();
  })
);

// PAGINATION
const pageForm = document.getElementById("page");
const pageNumbers = document.querySelectorAll(".page");
const pageInput = document.getElementById("pageInput");
pageNumbers.forEach(num =>
  num.addEventListener("click", function(e) {
    e.preventDefault();
    pageInput.value = num.textContent;
    pageForm.submit();
  })
);
