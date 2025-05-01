let cart = [];

function addToCart(name, price) {
  const existing = cart.find(item => item.name === name);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ name, price, quantity: 1 });
  }
  updateCartCount();
}

function updateCartCount() {
  document.getElementById("cart-count").textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
}

function openCart() {
  document.getElementById("cart-modal").style.display = "block";
  renderCartItems();
}

function closeCart() {
  document.getElementById("cart-modal").style.display = "none";
}

function renderCartItems() {
  const container = document.getElementById("cart-items");
  container.innerHTML = "";

  let total = 0;

  cart.forEach((item, index) => {
    total += item.price * item.quantity;
    const div = document.createElement("div");
    div.innerHTML = `
      <strong>${item.name}</strong> - 
      <input type="number" min="1" value="${item.quantity}" onchange="changeQuantity(${index}, this.value)">
      x ${item.price} грн = ${item.price * item.quantity} грн 
      <button onclick="removeItem(${index})">❌</button>
    `;
    container.appendChild(div);
  });

  document.getElementById("total").textContent = total;
}

function removeItem(index) {
  cart.splice(index, 1);
  renderCartItems();
  updateCartCount();
}

function changeQuantity(index, newQty) {
  cart[index].quantity = parseInt(newQty);
  renderCartItems();
  updateCartCount();
}

document.getElementById("open-cart").addEventListener("click", openCart);
