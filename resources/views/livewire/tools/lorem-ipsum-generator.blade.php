<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-lg font-bold mb-4">Lorem Ipsum Generator</h2>

    <div class="mb-4 flex items-center justify-between space-x-4">
        <div class="flex items-center gap-1.5">
            <!-- Input for number of paragraphs -->
            <label for="paragraphs" class="sr-only">Number of Paragraphs</label>
            <input
                type="number"
                id="paragraphs"
                wire:model="paragraphs"
                min="1"
                class="block px-4 py-2 w-full bg-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Number of Paragraphs">
            <button
                wire:click="generateLoremIpsum"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Generate
            </button>
        </div>
        @if ($loremIpsumText)
        <button
            onclick="copyToClipboard()"
            class="px-4 py-2 bg-green-500 text-black rounded-lg hover:bg-green-600">
            Copy
        </button>
        @endif
    </div>

    @if ($loremIpsumText)
        <div class="mt-6">
            <h3 class="text-md font-bold">Hasil:</h3>
            <pre id="loremText" class="mt-2 p-4 bg-gray-100 rounded-lg" style="white-space: pre-wrap; word-wrap: break-word;">{!! $loremIpsumText !!}</pre>
        </div>
    @endif
</div>

<!-- Script for copying text to clipboard -->
<script>
    function copyToClipboard() {
        const textElement = document.getElementById('loremText');
        const text = textElement.innerText;

        if (navigator.clipboard && window.isSecureContext) {
            // navigator.clipboard API method
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert('Teks berhasil disalin!');
                })
                .catch(err => {
                    console.error('Gagal menyalin teks: ', err);
                });
        } else {
            // Fallback method using execCommand
            const textArea = document.createElement('textarea');
            textArea.value = text;
            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                const msg = successful ? 'Teks berhasil disalin!' : 'Gagal menyalin teks';
                alert(msg);
            } catch (err) {
                console.error('Gagal menyalin teks: ', err);
            }

            document.body.removeChild(textArea);
        }
    }
</script>
