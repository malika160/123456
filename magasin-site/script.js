const cart = [];

const cartCount = document.getElementById('cart-count');
const cartList = document.getElementById('cart-list');
const cartTotal = document.getElementById('cart-total');

document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', () => {
        const name = btn.getAttribute('data-name');
        const price = parseFloat(btn.getAttribute('data-price'));

        const existing = cart.find(item => item.name === name);
        if (existing) {
            existing.quantity++;
        } else {
            cart.push({name, price, quantity: 1});
        }
        updateCartUI();
    });
});

function updateCartUI() {
    cartList.innerHTML = '';
    let total = 0;
    let count = 0;
    cart.forEach((item, index) => {
        total += item.price * item.quantity;
        count += item.quantity;
        const li = document.createElement('li');
        li.innerHTML = `
            ${item.name} - ${item.price}€ x ${item.quantity} = ${(item.price * item.quantity).toFixed(2)}€
            <button onclick="removeItem(${index})">Supprimer</button>
        `;
        cartList.appendChild(li);
    });
    cartTotal.textContent = total.toFixed(2);
    cartCount.textContent = count;
}

function removeItem(index) {
    cart.splice(index, 1);
    updateCartUI();
}

updateCartUI();
