<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
        }
        .scrollbar-hidden{
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'background-primary': '#fff',
                        'button-secondary': '#ffd327',
                        'font-primary': '#fff',
                        'font-secondary': '#71717a',
                        'font-navbar': '#3f3f46',
                        'box-navbar': '#f4f4f5',
                        'navbar-primary': '#232323',
                    }
                }
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
    <script>
        function getProductById(product_id){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `/api/product?product=${product_id}`,
                    type: 'GET',
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(error) {
                        console.log(error);
                        reject(error);
                    }
                });
            });
        }
        function updateTotalBill() {
            const total_bill = $('#purchase_total')
            const totalInput = $('#totalInput')
            const table = $('#purchase_details_table tbody')

            let temp_total_bill = 0;
            table.find('tr').each(function () {
                const total = parseFloat($(this).find('td').eq(5).text());
                if (!isNaN(total)) {
                    temp_total_bill += total;
                }
            });
            totalInput.val(temp_total_bill.toFixed(2));
            total_bill.text(temp_total_bill.toFixed(2));
        }
        function loadSalesDetails(){
            const table = $('#purchase_details_table tbody')
            const btnSendPurchase = $('#btnSendPurchase')
            let productDetails = []

            btnSendPurchase.on('click', function(){
                const fieldsRequired = [
                    'client',
                ]
                $('input[name="getProductId"]').prop('disabled', true);
                // $('input[name="getQuantity"]').prop('disabled', true);
                $('input[name="getObservation"]').prop('disabled', true);

                let validate = true;

                fieldsRequired.forEach(field => {
                    if($(`input[name="${field}"]`).val() === ''){
                        validate = false;
                        return;
                    }
                })

                if(!validate){
                    showAlert('Debe completar todos los campos', 'error');
                    return;
                }

                if(productDetails.length === 0){
                    showAlert('Debe agregar al menos un producto', 'error');
                    return;
                }

                btnSendPurchase.closest('form').submit();
            })

            $('#sale_btn').on('click', async function(){
                const product = $('#selected_product_code')
                const quantity = $('#purchase_quantity')
                const observations = $('#purchase_observations')
                const selectProductComponent = $('#selectedProduct')
                const inputProduct = $('#purchase_product_id')

                if(product.val() === '' || quantity.val() === ''){
                    alert('Debe completar todos los campos');
                    return;
                }

                const dataProduct = await getProductById(product.val());
                const total = parseFloat(quantity.val()) * parseFloat(dataProduct.price);

                const dataDetails = {
                    product: product.val(),
                    quantity: quantity.val(),
                    unitPrice: dataProduct.price,
                    total: total,
                    observations: observations.val()
                }

                productDetails.push(dataDetails);

                const row = `
                    <tr class="border-b-2 border-zinc-200">
                        <td class="p-2">${dataProduct.code}</td>
                        <td class="p-2">${dataProduct.name}</td>
                        <td class="p-2">${quantity.val()}</td>
                        <td class="p-2">${dataProduct.unit_of_measurement}</td>
                        <td class="p-2">${dataProduct.price}</td>
                        <td class="p-2">${total}</td>
                        <td class="p-2">
                            <button class="eliminar-detalle bg-red-500 p-2 font-semibold uppercase rounded text-white">Eliminar</button>
                        </td>
                    </tr>
                `
                $('#saleDetailsInput').val(JSON.stringify(productDetails));
                table.append(row)
                updateTotalBill()
                product.val('')
                quantity.val('')
                observations.val('')
                selectProductComponent.text('');
                selectProductComponent.addClass = 'hidden';
                inputProduct.val('')
                inputProduct.removeClass('hidden');
                $('#changeProductButton').click()
                $('#closeModal').click()
            })

            table.on('click', '.eliminar-detalle', function () {
                const index = $(this).closest('tr').index();
                productDetails.splice(index, 1);
                $('#purchaseDetailsInput').val(JSON.stringify(productDetails));
                $(this).closest('tr').remove();
                updateTotalBill();
            });
        }
        function loadPurchaseDetails(){
            const table = $('#purchase_details_table tbody')
            const btnSendPurchase = $('#btnSendPurchase')
            let productDetails = []

            btnSendPurchase.on('click', function(){
                const fieldsRequired = [
                    'number_bill',
                    'date_bill',
                    'provider',
                ]
                $('input[name="getProductId"]').prop('disabled', true);
                $('input[name="getQuantity"]').prop('disabled', true);
                $('input[name="getUnitPrice"]').prop('disabled', true);
                $('input[name="getObservation"]').prop('disabled', true);

                let validate = true;

                fieldsRequired.forEach(field => {
                    if($(`input[name="${field}"]`).val() === ''){
                        validate = false;
                        return;
                    }
                })

                if(!validate){
                    showAlert('Debe completar todos los campos', 'error');
                    return;
                }

                if(productDetails.length === 0){
                    showAlert('Debe agregar al menos un producto', 'error');
                    return;
                }

                btnSendPurchase.closest('form').submit();
            })

            $('#purchase_btn').on('click', async function(){
                const product = $('#selected_product_code')
                const quantity = $('#purchase_quantity')
                const unitPrice = $('#purchase_unit_price')
                const observations = $('#purchase_observations')
                const selectProductComponent = $('#selectedProduct')
                const inputProduct = $('#purchase_product_id')
                const total = parseFloat(quantity.val()) * parseFloat(unitPrice.val())

                if(product.val() === '' || quantity.val() === '' || unitPrice.val() === ''){
                    alert('Debe completar todos los campos');
                    return;
                }

                const dataDetails = {
                    product: product.val(),
                    quantity: quantity.val(),
                    unitPrice: unitPrice.val(),
                    total: total,
                    observations: observations.val()
                }

                productDetails.push(dataDetails);

                const dataProduct = await getProductById(product.val());

                const row = `
                    <tr class="border-b-[1px] border-zinc-200 font-semibold">
                        <td class="p-2">${dataProduct.code}</td>
                        <td class="p-2">${dataProduct.name}</td>
                        <td class="p-2">${quantity.val()}</td>
                        <td class="p-2">${dataProduct.unit_of_measurement}</td>
                        <td class="p-2">${unitPrice.val()}</td>
                        <td class="p-2">${total}</td>
                        <td class="p-2">
                            <button class="eliminar-detalle bg-red-500 py-1 px-2 font-semibold uppercase rounded text-white">Eliminar</button>
                        </td>
                    </tr>
                `
                $('#purchaseDetailsInput').val(JSON.stringify(productDetails));
                table.append(row)
                updateTotalBill()
                product.val('')
                quantity.val('')
                unitPrice.val('')
                observations.val('')
                selectProductComponent.text('');
                selectProductComponent.addClass = 'hidden';
                inputProduct.val('')
                inputProduct.removeClass('hidden');
                $('#changeProductButton').click()
                $('#closeModal').click()
            })

            table.on('click', '.eliminar-detalle', function () {
                const index = $(this).closest('tr').index();
                productDetails.splice(index, 1);
                $('#purchaseDetailsInput').val(JSON.stringify(productDetails));
                $(this).closest('tr').remove();
                updateTotalBill();
            });
        }
        function generateRandomPassword(length) {
            let result = '';
            let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let charactersLength = characters.length;
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#passwordNewUser').val(result);
        }

        function copyToClipboard(element) {
            $(`#${element}`).select();
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
            showAlert('Contraseña copiada al portapapeles', 'success');
        }

        function showAlert(message, type = 'info') {
            const alertBox = document.getElementById('alert');
            const alertMessage = document.getElementById('alert-message');

            alertMessage.textContent = message;

            switch(type) {
                case 'success':
                    alertBox.classList.remove('bg-blue-500', 'bg-red-500', 'bg-yellow-500');
                    alertBox.classList.add('bg-green-500');
                    break;
                case 'error':
                    alertBox.classList.remove('bg-blue-500', 'bg-green-500', 'bg-yellow-500');
                    alertBox.classList.add('bg-red-500');
                    break;
                case 'warning':
                    alertBox.classList.remove('bg-blue-500', 'bg-green-500', 'bg-red-500');
                    alertBox.classList.add('bg-yellow-500');
                    break;
                default:
                    alertBox.classList.remove('bg-green-500', 'bg-red-500', 'bg-yellow-500');
                    alertBox.classList.add('bg-blue-500');
            }

            alertBox.classList.remove('hidden');

            setTimeout(() => {
                closeAlert();
            }, 3000);
        }

        function showUnitsOfMeasurement(edit = false) {
            let typeOfMeasurement = $('#type_of_measurement').val();
            let typeOfMeasurementEdit = $('#type_of_measurement_edit').val();
            const unitOfMeasurementComponent = edit ? $('.unit_of_measurement_edit') : $('#unit_of_measurement');
            console.log([
                unitOfMeasurementComponent,
                typeOfMeasurement,
                typeOfMeasurementEdit,
                edit
            ]);
            if(typeOfMeasurement || typeOfMeasurementEdit){
                $.ajax({
                    url: `/api/unitsOfMeasurement/${typeOfMeasurement || typeOfMeasurementEdit}`,
                    type: 'GET',
                    success: function(response) {
                        unitOfMeasurementComponent.empty();
                        unitOfMeasurementComponent.append('<option value="">Seleccione una unidad de medida</option>');
                        $.each(response, function(code, name) {
                            unitOfMeasurementComponent.append('<option value="' + code + '">' + name + '</option>');
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                unitOfMeasurementComponent.empty();
                unitOfMeasurementComponent.append('<option value="">Seleccione una unidad de medida</option>');
            }
        }

        function closeAlert() {
            const alertBox = document.getElementById('alert');
            alertBox.classList.add('hidden');
        }
    </script>
    <title>Sistema Control de Inventario</title>
</head>
<body class="[&>input]:h-8 [&>input]:text-xs [&>select]:text-xs [&>textarea]:text-xs">
    <div id="alert" class="fixed z-50 top-4 right-4 bg-blue-500 text-white p-4 rounded-lg shadow-lg flex items-center justify-between hidden">
        <span id="alert-message" class="text-sm"></span>
        <button class="ml-4 text-white focus:outline-none" onclick="closeAlert()">
            &times;
        </button>
    </div>
    @if(session('message'))
        <script>
            showAlert('{{ session('message') }}', '{{ session('type') }}');
        </script>
    @endif
    @yield('layoutContent')
</body>
</html>
