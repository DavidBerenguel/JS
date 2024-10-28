document.addEventListener("DOMContentLoaded", () => {


    const body = document.querySelector("body");
    const h2 = document.querySelector("h2");
    const img = document.querySelector("img");


    const datetime = new Date();

    let h = datetime.getHours();

    const imgArray = [
        "https://www.google.com/imgres?q=imagem%20manha%20jpg&imgurl=https%3A%2F%2Fstatic8.depositphotos.com%2F1006362%2F893%2Fi%2F450%2Fdepositphotos_8931521-stock-photo-meadow.jpg&imgrefurl=https%3A%2F%2Fdepositphotos.com%2Fbr%2Fphotos%2Fmanh%25C3%25A3.html&docid=nRlr2LO9zsaKuM&tbnid=o1r6tahz0d0hQM&vet=12ahUKEwiPgNjwhO-FAxXh9AIHHddSDAwQM3oECFAQAA..i&w=600&h=490&hcb=2&ved=2ahUKEwiPgNjwhO-FAxXh9AIHHddSDAwQM3oECFAQAA", 
        "https://www.google.com/imgres?q=fim%20de%20tarde%20imagem&imgurl=https%3A%2F%2Fblogcarlossantos.com.br%2Fwp-content%2Fuploads%2F2022%2F02%2FFim-de-tarde-Guarulhos-SP-e1645968033666.jpeg&imgrefurl=https%3A%2F%2Fblogcarlossantos.com.br%2Ffim-de-tarde%2F&docid=ohf4FpQjBnHJUM&tbnid=yLdVZgqX-v5suM&vet=12ahUKEwjj6Kaagu-FAxVPRaQEHZuXD-0QM3oECGAQAA..i&w=640&h=480&hcb=2&ved=2ahUKEwjj6Kaagu-FAxVPRaQEHZuXD-0QM3oECGAQAA", 
        "https://www.google.com/imgres?q=tarde%20imagem&imgurl=https%3A%2F%2Fmedia-cdn.tripadvisor.com%2Fmedia%2Fphoto-s%2F0f%2F34%2F3b%2F10%2Ffim-de-tarde.jpg&imgrefurl=https%3A%2F%2Fwww.tripadvisor.es%2FLocationPhotoDirectLink-g2345186-i255081232-Lagoa_Da_Prata_State_of_Minas_Gerais.html&docid=v6wkOo8OWwNOmM&tbnid=h3UXvGVZT567DM&vet=12ahUKEwi946apg--FAxWwRaQEHSK5B48QM3oECGMQAA..i&w=532&h=450&hcb=2&ved=2ahUKEwi946apg--FAxWwRaQEHSK5B48QM3oECGMQAA"
    ];

    setInterval(function () {
        
        if ( h > 23 ) {
             
            h = 0;
             
        }
        if ( h >= 0 && h <= 9) {

            body.style.backgroundColor = "#ccbc8e";
            img.src = imgArray[0];
        }
        if ( h > 9 && h <= 14) {

            body.style.backgroundColor = "#A77760";
            img.src = imgArray[1];
        }
        if ( h > 14 && h <= 24) {

            body.style.backgroundColor = "#484A49";
            img.src = imgArray[2];
        }
        h2.textContent = "Agora são " + h + " horas.";

    }, 1000);
    
});