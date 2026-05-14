document.addEventListener('DOMContentLoaded', () => {
    function cleanColor(value) {
        return value.replace('#', '');
    }

    function expandHex(hex) {
        if (hex.length === 3) {
            return hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        }
        return hex;
    }

    function getTextColor(hexTop, hexBottom) {
        hexTop    = expandHex(hexTop    || 'ffffff');
        hexBottom = expandHex(hexBottom || 'ffffff');

        const r = (parseInt(hexTop.slice(0,2), 16) + parseInt(hexBottom.slice(0,2), 16)) / 2;
        const g = (parseInt(hexTop.slice(2,4), 16) + parseInt(hexBottom.slice(2,4), 16)) / 2;
        const b = (parseInt(hexTop.slice(4,6), 16) + parseInt(hexBottom.slice(4,6), 16)) / 2;

        const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        return luminance > 0.7 ? '#1f2937' : '#ffffff';
    }

    function updatePreview() {
        const top    = cleanColor(document.getElementById('colorTop').value);
        const bottom = cleanColor(document.getElementById('colorBottom').value);
        document.querySelector('.color-preview').style.background =
            `linear-gradient(to bottom, #${top}, #${bottom})`;
    }

    document.getElementById('colorTop').addEventListener('input', function() {
        document.querySelector('.color-top').style.backgroundColor = '#' + cleanColor(this.value);
        updatePreview();
    });

    document.getElementById('colorBottom').addEventListener('input', function() {
        document.querySelector('.color-bottom').style.backgroundColor = '#' + cleanColor(this.value);
        updatePreview();
    });

    // Icon picker
    const iconPicker  = document.getElementById('iconPicker');
    const iconBtn     = document.getElementById('iconBtn');
    const iconInput   = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    const defaultIconSvg = iconPreview.innerHTML;

    iconBtn.addEventListener('click', () => iconPicker.classList.remove('hidden'));

    document.querySelectorAll('.close-icon-picker').forEach(el => {
        el.addEventListener('click', () => iconPicker.classList.add('hidden'));
    });

    document.querySelectorAll('.iconOption').forEach(option => {
        option.addEventListener('click', function() {
            iconInput.value = this.dataset.icon;
            iconPreview.innerHTML = this.querySelector('svg').outerHTML;
            iconPicker.classList.add('hidden');
        });
    });

    // Tag
    const addTagBtn  = document.getElementById('addTagBtn');
    const tagPreview = document.getElementById('tagPreview');
    const postForm   = document.getElementById('postForm');

    addTagBtn.addEventListener('click', () => {
        const name     = document.getElementById('tagName').value.trim();
        const colorTop = cleanColor(document.getElementById('colorTop').value) || 'ffffff';
        const colorBot = cleanColor(document.getElementById('colorBottom').value) || 'ffffff';
        const iconName = iconInput.value;
        const iconSvg  = iconPreview.innerHTML;

        if (!name) return;

        const textColor = getTextColor(colorTop, colorBot);

        const hiddenContainer = document.createElement('div');
        hiddenContainer.classList.add('tag-hidden-inputs');
        hiddenContainer.innerHTML = `
            <input type="hidden" name="tag_name[]"     value="${name}">
            <input type="hidden" name="color_top[]"    value="${colorTop}">
            <input type="hidden" name="color_bottom[]" value="${colorBot}">
            <input type="hidden" name="icon[]"         value="${iconName}">
        `;
        postForm.appendChild(hiddenContainer);

        const tag = document.createElement('div');
        tag.className = 'px-4 py-2 rounded-full drop-shadow-lg flex gap-2 items-center justify-center';
        tag.style.background = `linear-gradient(to bottom, #${colorTop}, #${colorBot})`;
        tag.style.color = textColor;
        tag.innerHTML = `
            <div class="w-6 h-6">${iconSvg}</div>
            <p>${name}</p>
            <button type="button" class="ml-1 font-bold hover:opacity-60">✕</button>
        `;

        tag.querySelector('button').addEventListener('click', () => {
            tag.remove();
            hiddenContainer.remove();
            if (tagPreview.children.length === 0) tagPreview.classList.add('hidden');
        });

        tagPreview.classList.remove('hidden');
        tagPreview.appendChild(tag);

        document.getElementById('tagName').value     = '';
        document.getElementById('colorTop').value    = '';
        document.getElementById('colorBottom').value = '';
        document.querySelector('.color-top').style.backgroundColor    = '';
        document.querySelector('.color-bottom').style.backgroundColor = '';
        document.querySelector('.color-preview').style.background     = '';
        iconInput.value       = 'tag';
        iconPreview.innerHTML = defaultIconSvg;
    });

    // Link & Image modal
    const addLinkImgModal = document.getElementById('addLinkImg');
    const mediaPreview    = document.getElementById('mediaPreview');

    document.getElementById('openAddLinkImg').addEventListener('click', () => {
        addLinkImgModal.classList.remove('hidden');
    });

    document.querySelectorAll('.close-media-picker').forEach(el => {
        el.addEventListener('click', () => addLinkImgModal.classList.add('hidden'));
    });

    // Image
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageFileInput  = document.getElementById('imageFileInput');

    imageUploadArea.addEventListener('click', () => imageFileInput.click());

    imageFileInput.addEventListener('change', async function() {
        const file = this.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        imageUploadArea.innerHTML = '<p class="text-gray-400">Uploading...</p>';
        imageUploadArea.classList.add('pointer-events-none');

        try {
            const res  = await fetch('/upload/image', { method: 'POST', body: formData });
            const data = await res.json();

            if (data.error) {
                imageUploadArea.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                imageUploadArea.classList.remove('pointer-events-none');
                return;
            }

            const hiddenImg = document.createElement('input');
            hiddenImg.type  = 'hidden';
            hiddenImg.name  = 'imgs[]';
            hiddenImg.value = data.filename;
            hiddenImg.id    = 'img_' + data.filename;
            postForm.appendChild(hiddenImg);

            const imgRow = document.createElement('div');
            imgRow.className = 'flex items-center gap-3 text-[#545F71]';
            imgRow.innerHTML = `
                <img src="/assets/image/post/${data.filename}" class="w-12 h-12 object-cover rounded-lg">
                <p class="flex-1 truncate">${data.filename}</p>
                <button type="button" class="text-red-400 font-bold hover:text-red-600">✕</button>
            `;
            imgRow.querySelector('button').addEventListener('click', () => {
                imgRow.remove();
                document.getElementById('img_' + data.filename)?.remove();
            });
            mediaPreview.appendChild(imgRow);

            imageUploadArea.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <p>Add Image</p>
            `;
            imageUploadArea.classList.remove('pointer-events-none');
            imageFileInput.value = '';

        } catch (err) {
            imageUploadArea.innerHTML = '<p class="text-red-500">Upload failed</p>';
            imageUploadArea.classList.remove('pointer-events-none');
        }
    });

    // Link
    document.getElementById('addLinkBtn').addEventListener('click', () => {
        const url  = document.getElementById('linkUrl').value.trim();
        const text = document.getElementById('linkText').value.trim();

        if (!url) return;

        const display = text || url;
        const hiddenUrl  = document.createElement('input');
        hiddenUrl.type   = 'hidden';
        hiddenUrl.name   = 'link_url[]';
        hiddenUrl.value  = url;

        const hiddenText  = document.createElement('input');
        hiddenText.type   = 'hidden';
        hiddenText.name   = 'link_text[]';
        hiddenText.value  = display;

        const linkContainer = document.createElement('div');
        linkContainer.classList.add('link-hidden-inputs');
        linkContainer.appendChild(hiddenUrl);
        linkContainer.appendChild(hiddenText);
        postForm.appendChild(linkContainer);

        const linkRow = document.createElement('div');
        linkRow.className = 'flex items-center gap-3 text-[#545F71]';
        linkRow.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 015.656 0l4-4a4 4 0 01-5.656-5.656l-1.1 1.1"/>
            </svg>
            <a href="${url}" target="_blank" class="flex-1 truncate hover:underline">${display}</a>
            <button type="button" class="text-red-400 font-bold hover:text-red-600">✕</button>
        `;
        linkRow.querySelector('button').addEventListener('click', () => {
            linkRow.remove();
            linkContainer.remove();
        });
        mediaPreview.appendChild(linkRow);

        document.getElementById('linkUrl').value  = '';
        document.getElementById('linkText').value = '';
        addLinkImgModal.classList.add('hidden');
    });
});