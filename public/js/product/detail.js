function productDetail(product) {
    return {
        product: product,
        mainImage: product.image_url,
        quantity: 1,
        activeTab: 'description',

        changeMainImage(imageUrl) {
            this.mainImage = imageUrl;
        },

        incrementQuantity() {
            if (this.quantity < 99) this.quantity++;
        },

        decrementQuantity() {
            if (this.quantity > 1) this.quantity--;
        },

        updateQuantity() {
            if (this.quantity < 1) this.quantity = 1;
            if (this.quantity > 99) this.quantity = 99;
        },

        shareToFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
        },
        shareToTwitter() {
            const text = encodeURIComponent('Cek produk keren ini: ' + this.product.name);
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + text, '_blank');
        },
        shareToWhatsApp() {
            const text = encodeURIComponent('Lihat produk ini: ' + this.product.name + ' - ' + window.location.href);
            window.open('https://wa.me/?text=' + text, '_blank');
        },
        shareToCopyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link produk telah disalin ke clipboard!');
            });
        }
    }
}
