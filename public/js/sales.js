document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('purchase_product_id');
    const datalist = document.getElementById('products');
    const changeProductButton = document.getElementById('changeProductButton');

    const getPrice = (productName) => {
        return new Promise((resolve, reject) => {
            fetch(`/api/product/price?name=${productName}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => resolve(data))
                .catch(error => reject(error));
        });
    }

    input.addEventListener('keydown', async function (e) {
        if (e.key === 'Enter') {
            const inputValue = input.value;
            const options = Array.from(datalist.options);
            const match = options.find(option => option.value === inputValue);
            if (match) {
                const productName = match.label || match.text;
                const resultDiv = document.getElementById('selectedProduct');
                const {price, stock} = await getPrice(productName);
                if (resultDiv) {
                    resultDiv.innerText = `${productName} - Precio de venta: ${price} - Stock: ${stock}`;
                    changeProductButton.classList.remove('hidden');
                }
                input.classList.add('hidden')
                const hiddenInput = document.getElementById('selected_product_code');
                if (hiddenInput) {
                    hiddenInput.value = inputValue;
                }
                e.preventDefault();
            } else {
                alert('Producto no encontrado');
            }
        }
    });

    changeProductButton.addEventListener('click', function () {
        input.classList.remove('hidden');
        input.value = '';
        const resultDiv = document.getElementById('selectedProduct');
        if (resultDiv) {
            resultDiv.innerText = '';
        }
        changeProductButton.classList.add('hidden');
        const hiddenInput = document.getElementById('selected_product_code');
        if (hiddenInput) {
            hiddenInput.value = '';
        }
    });
});
