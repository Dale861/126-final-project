const iconCart = document.querySelector('.icon-cart');
const closeCart = document.querySelector('.close');
const body = document.querySelector('body');
const listProduct = document.querySelector('.listProduct');
const listCart = document.querySelector('.listCart');
const cartCount = document.querySelector('.cart-count');

let cart = {};

iconCart.addEventListener('click', () => {
  body.classList.toggle('showCart');
});

closeCart.addEventListener('click', () => {
  body.classList.toggle('showCart');
});

// Add to Cart Logic
listProduct.addEventListener('click', function (e) {
  if (e.target.classList.contains('add-to-cart')) {
    const item = e.target.closest('.item');
    const productName = item.querySelector('h2').textContent;
    const price = item.querySelector('.price').textContent;
    const imgSrc = item.querySelector('img').getAttribute('src');

    if (!cart[productName]) {
      cart[productName] = {
        name: productName,
        price: price,
        quantity: 1,
        img: imgSrc
      };
    } else {
      cart[productName].quantity++;
    }

    updateCartDisplay();
  }
});

// Update Cart DOM
function updateCartDisplay() {
  listCart.innerHTML = '';
  let totalCount = 0;

  for (let key in cart) {
    const item = cart[key];
    totalCount += item.quantity;

    const cartItem = document.createElement('div');
    cartItem.classList.add('item');
    cartItem.innerHTML = `
      <div class="image"><img src="${item.img}" alt="${item.name}"></div>
      <div class="name">${item.name}</div>
      <div class="totalPrice">${item.price}</div>
      <div class="quantity">
        <span class="minus" data-name="${item.name}">-</span>
        <span>${item.quantity}</span>
        <span class="plus" data-name="${item.name}">+</span>
      </div>
    `;

    listCart.appendChild(cartItem);
  }

  cartCount.textContent = totalCount;
}

// Handle + / - inside cart
listCart.addEventListener('click', function (e) {
  const name = e.target.getAttribute('data-name');

  if (e.target.classList.contains('plus')) {
    cart[name].quantity++;
  } else if (e.target.classList.contains('minus')) {
    cart[name].quantity--;
    if (cart[name].quantity <= 0) {
      delete cart[name];
    }
  }

  updateCartDisplay();
});
