// Thêm vào giỏ hàng
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-to-cart')) {
        fetch('ajax/cart.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + e.target.dataset.id + '&qty=1'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-count').innerText = data.cartCount;
                alert('Đã thêm vào giỏ!');
            }
        });
    }
});


// Hiển thị chi tiết sản phẩm
document.addEventListener('click', function(e) {
    // Hiện modal chi tiết
   if (e.target.classList.contains('show-detail')) {
    const id = e.target.getAttribute('data-id');
    fetch('ajax/product_detail.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            const modal = document.getElementById('product-detail-modal');
            modal.innerHTML = html;
            modal.style.display = 'block';
            document.body.classList.add('modal-open');
        });
    }
    if (e.target.classList.contains('close-detail-modal')) {
        const modal = document.getElementById('product-detail-modal');
        modal.innerHTML = '';
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
     // Hiện modal đánh giá
     if (e.target.classList.contains('show-reviews')) {
        const id = e.target.getAttribute('data-id');
        fetch('ajax/reviews.php?product_id=' + id)
            .then(res => res.text())
            .then(html => {
                const modal = document.getElementById('reviews-modal');
                modal.innerHTML = html;
                modal.style.display = 'block';
                document.body.classList.add('modal-open');
            });
    }
    if (e.target.classList.contains('close-reviews-modal')) {
        const modal = document.getElementById('reviews-modal');
        modal.innerHTML = '';
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
    }
});


// Live search
document.getElementById('live-search').addEventListener('input', function() {
    fetch('ajax/search.php?q=' + encodeURIComponent(this.value))
        .then(res => res.text())
        .then(html => document.getElementById('search-result').innerHTML = html);
});


// AJAX Poll
document.getElementById('poll-form').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    fetch('ajax/poll.php', {method: 'POST', body: formData})
        .then(res => res.text())
        .then(html => document.getElementById('poll-result').innerHTML = html);
});


// Đánh giá sản phẩm
document.addEventListener('submit', function(e) {
    if (e.target.id === 'review-form') {
        e.preventDefault();
        let formData = new FormData(e.target);
        fetch('ajax/review_upload.php', {method: 'POST', body: formData})
            .then(res => res.json())
            .then(data => {
                document.getElementById('review-message').innerText = data.message;
            });
    }
});

// lọc sản phẩm theo ngành hàng và thương hiệu
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category-select');
    const brandSelect = document.getElementById('brand-select');
    const productList = document.getElementById('product-list');
    const allProducts = Array.from(productList.getElementsByClassName('product-item'));

    // Lấy danh sách thương hiệu theo ngành hàng
    function getBrandsByCategory(category) {
        const brands = new Set();
        allProducts.forEach(item => {
            if (!category || item.dataset.category === category) {
                if (item.dataset.brand) brands.add(item.dataset.brand);
            }
        });
        return Array.from(brands);
    }

    // Cập nhật danh sách thương hiệu khi chọn ngành hàng
    categorySelect.addEventListener('change', function() {
        const category = categorySelect.value;
        const brands = getBrandsByCategory(category);
        brandSelect.innerHTML = '<option value="">Chọn thương hiệu</option>';
        brands.forEach(brand => {
            brandSelect.innerHTML += `<option value="${brand}">${brand}</option>`;
        });
        brandSelect.value = '';
        filterProducts();
    });

    // Lọc sản phẩm khi chọn thương hiệu
    brandSelect.addEventListener('change', filterProducts);

    function filterProducts() {
        const category = categorySelect.value;
        const brand = brandSelect.value;
        allProducts.forEach(item => {
            const matchCategory = !category || item.dataset.category === category;
            const matchBrand = !brand || item.dataset.brand === brand;
            item.style.display = (matchCategory && matchBrand) ? '' : 'none';
        });
    }

    // Xử lý nút "Tất cả"
    document.getElementById('filter-all').addEventListener('click', function() {
        categorySelect.value = '';
        brandSelect.innerHTML = '<option value="">Chọn thương hiệu</option>';
        allProducts.forEach(item => item.style.display = '');
    });
});