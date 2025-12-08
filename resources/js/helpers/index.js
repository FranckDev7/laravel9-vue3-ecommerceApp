import axios from "axios";

/**
 * Intl : objet global natif fourni par JavaScript qui gère tout ce qui est internationalisation et contient
 * les constructeurs ci-après : (Intl.NumberFormat, Intl.DateTimeFormat, Intl.Collator, Intl.RelativeTimeFormat)
 * NumberFormat : classe de Intl qui sert à formater les nombres et prend deux arguments (code de langue + region)
 * et Un objet d’option
 * @param price
 */
export const formatPrice = (price) => {
    return new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR" }).format(price / 100)
}

export const saveOrder = async () => {
    await axios.post('/saveOrder');
}
