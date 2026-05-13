document.addEventListener('DOMContentLoaded', () => {
    // Color preview
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
        return luminance > 0.5 ? '#1f2937' : '#ffffff';
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

    iconBtn.addEventListener('click', () => {
        iconPicker.classList.remove('hidden');
    });

    document.querySelector('.close-picker').addEventListener('click', () => {
        iconPicker.classList.add('hidden');
    });

    document.querySelectorAll('.iconOption').forEach(option => {
        option.addEventListener('click', function() {
            const iconName = this.dataset.icon;
            iconInput.value = iconName;
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

        tagPreview.classList.remove('hidden');

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
            if (tagPreview.children.length === 0) {
                tagPreview.classList.add('hidden');
            }
        });

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
});