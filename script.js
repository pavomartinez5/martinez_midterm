const quote = document.querySelector(".quote");

generate = document.getElementById("generate");

category = document.getElementById("category");

likeQuote = document.getElementById("likeQuote");

likeList = document.getElementById("likeList");

window.addEventListener("load", () => {
  generateQuotes();
});

document.getElementById("generate").addEventListener("click", generateQuotes);

function generateQuotes() {
  let div = document.createElement("div");
  quote.innerHTML = `Loading New Quotes...<i class = "fa-solid fa-sync fa-spin"></i>`;
  generate.innerHTML = "Generating...";

  fetch("https://api.api-ninjas.com/v1/quotes", {
    headers: { "X-Api-Key": "L0zkvpVBwW6sO0OG9k2Zzg==eatzRR5IqOw2ZuRO" },
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      generate.innerHTML = "New Quote";

      quote.innerHTML = "";
      div.innerHTML += '<i class ="fa-solid fa-quote-left"></i> &nbsp;';
      div.innerHTML += data[0].quote;
      div.innerHTML += '&nbsp; <i class ="fa-solid fa-quote-right"></i>';

      div.innerHTML += `<div class="author"><span>__</span>${data[0].author}</div>`;
      quote.append(div);

      category.innerHTML = data[0].category;
    });
}

generateQuotes();
