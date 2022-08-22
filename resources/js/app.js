import * as bootstrap from "bootstrap";
import axios from "axios";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const cartDelete = () => {
    document
        .querySelectorAll(".delete--cart--item") //paimam class prie el kuri norim trinti
        .forEach((button) => {
            //surastus el suforeach ir imam button
            button.addEventListener("click", () => {
                //ant jo uzdedam event = click
                const id = button.dataset.itemId; // kai ji paspaudziam paimam to button id (paimam is data-item-id be bruksneliu tokiu budu gaunam {$hotel->id})
                axios
                    .delete(mySmallCart + "?id=" + id) //axios kelias kuris eina i cart prilipina prie jo ? ir paima id
                    .then((_) => {
                        cartUpdate();
                    });
            });
        });
};

//step 2

const cartUpdate = () => {
    //
    axios.get(mySmallCart).then((res) => {
        // kreipiames i serveri, gaunam html pagal tuo metu existuojancia session
        document.querySelector(".small--cart").innerHTML = res.data.html; //ir ta html insertinam i jai priskirta vieta. Html neturi jokiu event. Ant jo mygtukai neveikia.
        cartDelete(); //uzloadina deleta kuris pereina per visa doka ir sudelioja visus eventus, ka turi daryti kiekvienas mygtukas. Kiekvienas mygtukas kreipiasi i serveri ir jam pasako ka delete. kai gaunam ats is serverio dar karta kviecia cartupdate, kuris update html ir update mygtuka.
    });
};

//step 1
window.addEventListener("load", () => {
    // uzloadina psl,kviecia cartupdate.
    cartUpdate();
});

if (document.querySelector(".magic--link")) {
    const selector = document.querySelector("[name=country_id]"); // iesko country
    const magicLink = document.querySelector(".magic--link"); //iesko country pagal id prie linko
    const linkText = magicLink.querySelector("span"); //pasetinam linka is <span>

    const doLink = () => {
        magicLink.setAttribute("href", showUrl + "/" + selector.value);
        linkText.innerText = selector.options[selector.selectedIndex].text; //pakeicia text pagal id
    };
    selector.addEventListener("change", () => {
        doLink();
    });

    window.addEventListener("load", () => {
        doLink();
        // palaiko kas pries tai buvo selected
    });
}

if (document.querySelector(".add--cart")) {
    //jeigu yra toks linkas/button, process
    document
        .querySelectorAll(".add--cart") //surandam visus buttons
        .forEach((button) => {
            button.addEventListener("click", () => {
                //kai randam button, uzdedam eventa su pavadinimu click, ir kai jis pasispaudzia siunciam rqst

                const row = button.closest(".row");
                const count = row.querySelector("[name=hotels_count]").value;
                const hotelId = row.querySelector("[name=hotel_id]").value;
                //ieskom pagal name

                // arba
                //ieskom pagal type
                // const hotelId = row.querySelector('[type=hidden]').value;

                axios
                    .post(addToCartUrl, { count, hotelId }) //ir siunciam
                    .then((res) => {
                        cartUpdate();
                    });
            });
            // console.log(button.closest(".row")); //suranda artimiausia teva. To siekiam norint issiuti info irasyta tame hidden type input. Realiai ieskom kur tie imput yra padeti.
        });
}
