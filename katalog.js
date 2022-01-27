Vue.createApp({
    data() {
        return {
            img: "", //LinkGrafikdatei
            title: "", //Produkttitel
            price: 0, //PreisBrutto
            autorname: "", //Autorname
            lagerbestand: 0, //Lagerbestand
            books: [],
            search: "",
            bookstore: [],
            isShoppingCart: "opacity: 0;z-index:0;",
            isCatalog: "opacity: 1;z-index:1;",
        };
    },

    methods: {
        menuToCart() {
            this.isShoppingCart = "opacity: 1";
            this.isCatalog = "opacity: 0;z-index:0";
        },
        backToCatalog() {
            this.isShoppingCart = "opacity: 0z-index:0;";
            this.isCatalog = "opacity: 1;z-index:1;";
        },
        compareAmount(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id) {
                    if (parseInt(this.books[i].amount) > parseInt(this.books[i].Lagerbestand)) {
                        this.books[i].amount = this.books[i].Lagerbestand;

                    } else {}
                }
            }

        },
        addToCart(id) {
            for (var i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id) {
                    this.books[i].quantity = this.books[i].amount;
                    console.log("quantity2: " + this.books[i].quantity);
                }

            }
        },
        searchData() {
            if (this.search == "") this.bookstore = this.books;
            else {
                this.bookstore = this.books.filter(e => {
                    return e.Produkttitel.match(new RegExp(this.search, 'i'));
                })
            }

        },
        add(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id) {
                    if (parseInt(this.books[i].amount) < parseInt(this.books[i].Lagerbestand)) {
                        this.books[i].amount++;
                    } else {
                        alert("Es sind nicht mehr genügend Bücher auf Lager");
                    }
                }
            }
            /*   else {
                   alert("Es sind nicht mehr genügend Bücher auf Lager");
               } */
        },

        reduce(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id)
                    if (this.books[i].amount == 0) {} else {
                        this.books[i].amount--;
                    }
            }

        },
        add1(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id) {
                    if (parseInt(this.books[i].quantity) < parseInt(this.books[i].Lagerbestand)) {
                        this.books[i].quantity++;
                        this.books[i].amount = this.books[i].quantity

                    } else {
                        alert("Es sind nicht mehr genügend Bücher auf Lager");
                    }
                }
            }
        },

        reduce1(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id)
                    if (this.books[i].quantity == 0) {} else {
                        this.books[i].quantity--;
                        this.books[i].amount = this.books[i].quantity
                    }
            }

        },

        remove(id) {
            for (let i = 0; i < this.books.length; i++) {
                if (this.books[i].ProduktID == id) {
                    this.books[i].quantity = 0;
                    this.books[i].amount = 0;
                }

            }
        },

        fetchData() {
            fetch("https://iws107.informatik.htw-dresden.de/ewa/G05/admin/beleg/buchJSON.php")
                .then(response => response.json())
                .then((data) => {
                    this.books = data;
                    for (var i = 0; i < this.books.length; i++) {
                        this.books[i].amount = 0;
                        this.books[i].quantity = 0;

                    }
                    this.bookstore = this.books;

                })
        },
        fetchCheckOutData() {
            let checkoutBooks = [];
            let URL = 'https://iws107.informatik.htw-dresden.de/ewa/G05/admin/beleg/getDataBookToJson.php';
            console.log("check1:");
            for (let i = 0; i < this.books.length; i++) {
                console.log("vao for:");

                if (this.books[i].quantity > 0) {
                    let item = {};
                    item.name = this.books[i].Produkttitel;
                    item.description = this.books[i].Kurzinhalt;
                    item.images = this.books[i].LinkGrafikdatei;
                    item.amount = this.books[i].PreisBrutto * 100;
                    item.currency = 'eur';
                    item.quantity = this.books[i].quantity;
                    checkoutBooks.push(item);
                    console.log("in tung item:");
                    console.log(checkoutBooks);
                }
                console.log("list item: " + checkoutBooks);
            }
            /*             let test = {
                            "firstName": "Nhat",
                            "lastName": "Nguyen",
                            "age": "34"
                        };
                        console.log("aa:" + test);
                        console.log("bb:" + JSON.stringify(test)); */

            axios.post(URL, checkoutBooks)
                .then(function(response) {
                    console.log(response);
                })
                .catch(function(error) {
                    console.log(error);
                });


            /*  fetch(URL, {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                     },
                     body: JSON.stringify(checkoutBooks)
                 }).then((response) => response.json())
                 .then((data) => {
                     console.log(data);
                 })
                 .catch((data) => {
                     console.error(data);
                 }); */

        },

    },
    mounted() {
        this.fetchData();

    },
    computed: {
        total() {
            var priceSum;
            priceSum = 0;
            for (let i = 0; i < this.books.length; i++) {
                priceSum = priceSum + parseFloat(this.books[i].PreisBrutto) * parseFloat(this.books[i].quantity);
            }
            return priceSum;
        },
    }




}).mount('#app');