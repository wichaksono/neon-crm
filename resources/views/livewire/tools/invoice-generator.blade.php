<div>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Invoice Form</h1>
        <form wire:submit.prevent="submitInvoice">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700">Invoice Number</label>
                    <input type="text" wire:model="invoice_number" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="INV-12345">
                </div>
                <div>
                    <label class="block text-gray-700">Date</label>
                    <input type="date" wire:model="invoice_date" class="w-full mt-2 p-2 border border-gray-300 rounded-md">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-gray-700">Upload Logo</label>
                <div class="mt-2 p-6 border-2 border-dashed border-gray-300 rounded-md flex justify-center items-center">
                    <input type="file" wire:model="logo" class="hidden" id="logo-upload">
                    <label for="logo-upload" class="cursor-pointer text-blue-500 hover:underline">
                        <i class="fas fa-cloud-upload-alt text-3xl"></i>
                        <p>Drag & Drop or Click to Upload</p>
                    </label>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-4">Seller Information</h2>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" wire:model="seller_name" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Seller Name">
                    <label class="block text-gray-700 mt-4">Address</label>
                    <input type="text" wire:model="seller_address" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Seller Address">
                    <label class="block text-gray-700 mt-4">Email</label>
                    <input type="email" wire:model="seller_email" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Seller Email">
                    <label class="block text-gray-700 mt-4">Phone</label>
                    <input type="text" wire:model="seller_phone" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Seller Phone">
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4">Buyer Information</h2>
                    <label class="block text-gray-700">Name</label>
                    <input type="text" wire:model="buyer_name" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Buyer Name">
                    <label class="block text-gray-700 mt-4">Address</label>
                    <input type="text" wire:model="buyer_address" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Buyer Address">
                    <label class="block text-gray-700 mt-4">Email</label>
                    <input type="email" wire:model="buyer_email" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Buyer Email">
                    <label class="block text-gray-700 mt-4">Phone</label>
                    <input type="text" wire:model="buyer_phone" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Buyer Phone">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-gray-700">Description</label>
                <textarea wire:model="description" class="w-full mt-2 p-2 border border-gray-300 rounded-md" rows="4" placeholder="Description of the services or products"></textarea>
            </div>
            <div class="mt-6">
                <label class="block text-gray-700">Items</label>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-2">
                    <div>
                        <label class="block text-gray-700">Item</label>
                        <input type="text" wire:model="item_name" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="Item Name">
                    </div>
                    <div>
                        <label class="block text-gray-700">Quantity</label>
                        <input type="number" wire:model="item_quantity" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="1">
                    </div>
                    <div>
                        <label class="block text-gray-700">Price</label>
                        <input type="text" wire:model="item_price" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="$0.00">
                    </div>
                    <div>
                        <label class="block text-gray-700">Total</label>
                        <input type="text" wire:model="item_total" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="$0.00" readonly>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="button" wire:click="addItem" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Add Item</button>
            </div>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700">Discount (%)</label>
                    <input type="number" wire:model="discount" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="0">
                </div>
                <div>
                    <label class="block text-gray-700">Tax (%)</label>
                    <input type="number" wire:model="tax" class="w-full mt-2 p-2 border border-gray-300 rounded-md" placeholder="0">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-gray-700">Notes</label>
                <textarea wire:model="notes" class="w-full mt-2 p-2 border border-gray-300 rounded-md" rows="4" placeholder="Additional notes"></textarea>
            </div>

            <!-- Tombol Print Invoice -->
            <div class="flex justify-end mb-4">
                <div onclick="showInvoicePopup()" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-500">Print Invoice</div>
            </div>
        </form>
    </div>

    <!-- Popup Invoice -->
    <div id="invoice-popup" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <img alt="Company logo placeholder image" height="100" src="https://storage.googleapis.com/a1aa/image/Hcge7mKKBV5KP8ma0_QvkTCaCzXxly2iA2Jgx2G0f3I.jpg" width="100"/>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold">Invoice</h2>
                    <p>Invoice Number: <span id="popup-invoice-number"></span></p>
                    <p>Date: <span id="popup-invoice-date"></span></p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-bold">Seller Information</h3>
                    <p id="popup-seller-name"></p>
                    <p id="popup-seller-address"></p>
                    <p id="popup-seller-email"></p>
                    <p id="popup-seller-phone"></p>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Buyer Information</h3>
                    <p id="popup-buyer-name"></p>
                    <p id="popup-buyer-address"></p>
                    <p id="popup-buyer-email"></p>
                    <p id="popup-buyer-phone"></p>
                </div>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-bold">Description</h3>
                <p id="popup-description"></p>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-bold">Items</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                    <tr>
                        <th class="border border-gray-300 p-2">Item</th>
                        <th class="border border-gray-300 p-2">Quantity</th>
                        <th class="border border-gray-300 p-2">Price</th>
                        <th class="border border-gray-300 p-2">Total</th>
                    </tr>
                    </thead>
                    <tbody id="popup-items">
                    <!-- Items will be dynamically added here -->
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-bold">Discount</h3>
                    <p id="popup-discount"></p>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Tax</h3>
                    <p id="popup-tax"></p>
                </div>
            </div>
            <div class="mb-6">
                <h3 class="text-lg font-bold">Notes</h3>
                <p id="popup-notes"></p>
            </div>
            <div class="text-right">
                <h3 class="text-lg font-bold">Total</h3>
                <p id="popup-total"></p>
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="printInvoice()" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-500">Print</button>
                <button onclick="closeInvoicePopup()" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md shadow hover:bg-gray-500">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showInvoicePopup() {
        document.getElementById('invoice-popup').classList.remove('hidden');

        // Menyalin nilai dari form ke popup
        document.getElementById('popup-invoice-number').innerText = document.querySelector('[wire\\:model="invoice_number"]').value;
        document.getElementById('popup-invoice-date').innerText = document.querySelector('[wire\\:model="invoice_date"]').value;
        document.getElementById('popup-seller-name').innerText = document.querySelector('[wire\\:model="seller_name"]').value;
        document.getElementById('popup-seller-address').innerText = document.querySelector('[wire\\:model="seller_address"]').value;
        document.getElementById('popup-seller-email').innerText = document.querySelector('[wire\\:model="seller_email"]').value;
        document.getElementById('popup-seller-phone').innerText = document.querySelector('[wire\\:model="seller_phone"]').value;
        document.getElementById('popup-buyer-name').innerText = document.querySelector('[wire\\:model="buyer_name"]').value;
        document.getElementById('popup-buyer-address').innerText = document.querySelector('[wire\\:model="buyer_address"]').value;
        document.getElementById('popup-buyer-email').innerText = document.querySelector('[wire\\:model="buyer_email"]').value;
        document.getElementById('popup-buyer-phone').innerText = document.querySelector('[wire\\:model="buyer_phone"]').value;
        document.getElementById('popup-description').innerText = document.querySelector('[wire\\:model="description"]').value;
        document.getElementById('popup-discount').innerText = document.querySelector('[wire\\:model="discount"]').value + '%';
        document.getElementById('popup-tax').innerText = document.querySelector('[wire\\:model="tax"]').value + '%';
        document.getElementById('popup-notes').innerText = document.querySelector('[wire\\:model="notes"]').value;
        document.getElementById('popup-total').innerText = '$' + calculateTotal();

        // Menyalin daftar item
        let itemsTable = document.getElementById('popup-items');
        itemsTable.innerHTML = '';
        @this.items.forEach(item => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td class="border border-gray-300 p-2">${item.name}</td>
                <td class="border border-gray-300 p-2">${item.quantity}</td>
                <td class="border border-gray-300 p-2">${item.price}</td>
                <td class="border border-gray-300 p-2">${item.total}</td>
            `;
            itemsTable.appendChild(row);
        });
    }

    function closeInvoicePopup() {
        document.getElementById('invoice-popup').classList.add('hidden');
    }

    function printInvoice() {
        let printContents = document.getElementById('invoice-popup').innerHTML;
        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        closeInvoicePopup();
    }

    function calculateTotal() {
        let total = 0;
        @this.items.forEach(item => {
            total += item.total;
        });
        total = total - (total * (document.querySelector('[wire\\:model="discount"]').value / 100));
        total = total + (total * (document.querySelector('[wire\\:model="tax"]').value / 100));
        return total.toFixed(2);
    }

    document.addEventListener('livewire:load', function () {
        Livewire.on('showInvoicePopup', showInvoicePopup);
    });
</script>
