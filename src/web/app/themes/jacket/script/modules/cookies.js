export default class AnchorlinkMenu {
  constructor() {
    window.cookieconsent.initialise({
      palette: {
        popup: {
          background: "#782c34",
        },
        button: {
          background: "#eec94d",
        },
      },
      theme: "classic",
      position: "bottom-right",
      content: {
        message:
          "We gebruiken cookies om er zeker van te zijn dat u onze website zo goed mogelijk beleeft. Door verder gebruik te maken van deze website gaat u hiermee akkoord.",
        dismiss: "OK",
        link: "Lees meer",
        href: "https://www.betuwsedeuren.nl/privacy-verklaring/",
      },
    });
  }
}
