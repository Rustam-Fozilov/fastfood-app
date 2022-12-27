let productsInCart = [

];

function setProductsInCart(products) {
    productsInCart = products;
}

function setProductsInCartQuantity(productId, quantity) {
    productsInCart.forEach(product => {
        if (product.id === productId) {
            product.quantity = quantity;
        }
    });
}

export { productsInCart, setProductsInCart, setProductsInCartQuantity };
