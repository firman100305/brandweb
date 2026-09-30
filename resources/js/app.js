const burger = document.querySelector('.burger');
const nav = document.getElementById('nav');
burger.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    burger.setAttribute('aria-expanded', open);
});
nav.addEventListener('click', () => {
    nav.classList.remove('open');
    burger.setAttribute('aria-expanded', 'false');
});

// Filter produk per genre (tombol filter dan link di daftar koleksi)
const cards = document.querySelectorAll('.card');
const buttons = document.querySelectorAll('.filters button');

function applyFilter(genre) {
    cards.forEach((c) => { c.hidden = genre !== 'all' && c.dataset.genre !== genre; });
    buttons.forEach((b) => b.setAttribute('aria-pressed', b.dataset.filter === genre));
}

document.querySelectorAll('[data-filter]').forEach((el) => {
    el.addEventListener('click', () => applyFilter(el.dataset.filter));
});

// Hitung keranjang (sementara di browser; sambungkan ke backend nanti)
const count = document.getElementById('cart-count');
let total = 0;
document.querySelectorAll('.add').forEach((btn) => {
    btn.addEventListener('click', () => { total += 1; count.textContent = total; });
});
