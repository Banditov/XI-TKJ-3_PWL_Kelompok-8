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
        return luminance > 0.8 ? '#1f2937' : '#ffffff';
    }

    function updatePreview() {
        const topElement = document.getElementById('colorTop');
        const bottomElement = document.getElementById('colorBottom');
        const previewElement = document.querySelector('.color-preview');
        
        if (topElement && bottomElement && previewElement) {
            const top = cleanColor(topElement.value);
            const bottom = cleanColor(bottomElement.value);
            previewElement.style.background = `linear-gradient(to bottom, #${top || 'CCCCCC'}, #${bottom || 'CCCCCC'})`;
        }
    }

    // Color inputs
    const colorTopInput = document.getElementById('colorTop');
    const colorBottomInput = document.getElementById('colorBottom');
    const colorTopDiv = document.querySelector('.color-top');
    const colorBottomDiv = document.querySelector('.color-bottom');

    if (colorTopInput) {
        colorTopInput.addEventListener('input', function() {
            if (colorTopDiv) {
                colorTopDiv.style.backgroundColor = '#' + cleanColor(this.value);
            }
            updatePreview();
        });
    }

    if (colorBottomInput) {
        colorBottomInput.addEventListener('input', function() {
            if (colorBottomDiv) {
                colorBottomDiv.style.backgroundColor = '#' + cleanColor(this.value);
            }
            updatePreview();
        });
    }

    // Icon picker
    const iconPicker = document.getElementById('iconPicker');
    const iconBtn = document.getElementById('iconBtn');
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    const defaultIconSvg = iconPreview ? iconPreview.innerHTML : '';

    if (iconBtn) {
        iconBtn.addEventListener('click', () => {
            if (iconPicker) iconPicker.classList.remove('hidden');
        });
    }

    document.querySelectorAll('.close-icon-picker').forEach(el => {
        el.addEventListener('click', () => {
            if (iconPicker) iconPicker.classList.add('hidden');
        });
    });

    document.querySelectorAll('.iconOption').forEach(option => {
        option.addEventListener('click', function() {
            if (iconInput) iconInput.value = this.dataset.icon;
            if (iconPreview) iconPreview.innerHTML = this.querySelector('svg').outerHTML;
            if (iconPicker) iconPicker.classList.add('hidden');
        });
    });

    // Tag
    const addTagBtn = document.getElementById('addTagBtn');
    const tagPreview = document.getElementById('tagPreview');
    const postForm = document.getElementById('postForm');

    if (addTagBtn) {
        addTagBtn.addEventListener('click', () => {
            const tagNameInput = document.getElementById('tagName');
            const name = tagNameInput ? tagNameInput.value.trim() : '';
            const colorTop = cleanColor(colorTopInput?.value || '') || 'CCCCCC';
            const colorBot = cleanColor(colorBottomInput?.value || '') || 'CCCCCC';
            const iconName = iconInput ? iconInput.value : 'tag';
            const iconSvg = iconPreview ? iconPreview.innerHTML : '';

            if (!name) {
                alert('Please enter a tag name');
                return;
            }

            const textColor = getTextColor(colorTop, colorBot);

            const hiddenContainer = document.createElement('div');
            hiddenContainer.classList.add('tag-hidden-inputs');
            hiddenContainer.innerHTML = `
                <input type="hidden" name="tag_name[]"           value="${escapeHtml(name)}">
                <input type="hidden" name="tag_color_top[]"      value="${colorTop}">
                <input type="hidden" name="tag_color_bottom[]"   value="${colorBot}">
                <input type="hidden" name="tag_icon[]"           value="${escapeHtml(iconName)}">
            `;
            postForm.appendChild(hiddenContainer);

            const tag = document.createElement('div');
            tag.className = 'tag-preview-item px-4 py-2 rounded-full drop-shadow-lg flex gap-2 items-center justify-center';
            tag.style.background = `linear-gradient(to bottom, #${colorTop}, #${colorBot})`;
            tag.style.color = textColor;
            tag.innerHTML = `
                <div class="w-6 h-6">${iconSvg}</div>
                <p>${escapeHtml(name)}</p>
                <button type="button" class="remove-tag ml-1 font-bold hover:opacity-60">✕</button>
            `;

            const removeBtn = tag.querySelector('.remove-tag');
            if (removeBtn) {
                removeBtn.addEventListener('click', () => {
                    tag.remove();
                    hiddenContainer.remove();
                    if (tagPreview && tagPreview.children.length === 0) {
                        tagPreview.classList.add('hidden');
                    }
                });
            }

            if (tagPreview) {
                tagPreview.classList.remove('hidden');
                tagPreview.appendChild(tag);
            }

            if (tagNameInput) tagNameInput.value = '';
            if (colorTopInput) colorTopInput.value = '';
            if (colorBottomInput) colorBottomInput.value = '';
            if (colorTopDiv) colorTopDiv.style.backgroundColor = '';
            if (colorBottomDiv) colorBottomDiv.style.backgroundColor = '';
            
            const colorPreview = document.querySelector('.color-preview');
            if (colorPreview) colorPreview.style.background = '';
            
            if (iconInput) iconInput.value = 'tag';
            if (iconPreview) iconPreview.innerHTML = defaultIconSvg;
        });
    }

    document.querySelectorAll('.remove-tag').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tagDiv = this.closest('.tag-preview-item');
            if (tagDiv) {
                const hiddenInputs = tagDiv.querySelectorAll('input[type="hidden"]');
                hiddenInputs.forEach(input => input.remove());
                tagDiv.remove();
            }
        });
    });

    document.querySelectorAll('.remove-media').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const mediaDiv = this.closest('.media-item');
            if (mediaDiv) {
                mediaDiv.remove();
            }
        });
    });

    const addLinkImgModal = document.getElementById('addLinkImg');
    const mediaPreview = document.getElementById('mediaPreview');
    const openAddLinkImg = document.getElementById('openAddLinkImg');

    if (openAddLinkImg) {
        openAddLinkImg.addEventListener('click', () => {
            if (addLinkImgModal) addLinkImgModal.classList.remove('hidden');
        });
    }

    document.querySelectorAll('.close-media-picker').forEach(el => {
        el.addEventListener('click', () => {
            if (addLinkImgModal) addLinkImgModal.classList.add('hidden');
        });
    });

    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageFileInput = document.getElementById('imageFileInput');

    if (imageUploadArea) {
        imageUploadArea.addEventListener('click', () => {
            if (imageFileInput) imageFileInput.click();
        });
    }

    if (imageFileInput) {
        imageFileInput.addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewRow = document.createElement('div');
                previewRow.className = 'media-item flex items-center gap-2 text-[#545F71] preview-item w-fit';
                previewRow.innerHTML = `
                    <span>●</span>
                    <img src="${e.target.result}" class="w-10 h-10 object-cover rounded cursor-pointer">
                    <span class="flex-1 truncate">${escapeHtml(file.name)}</span>
                    <span class="text-xs text-yellow-500">(uploading...)</span>
                    <button type="button" class="remove-media text-red-500 cursor-pointer hover:text-red-700 scale-200">&times;</button>
                `;

                previewRow.querySelector('.remove-media').addEventListener('click', () => {
                    previewRow.remove();
                });

                if (mediaPreview) mediaPreview.appendChild(previewRow);
            };
            reader.readAsDataURL(file);

            const formData = new FormData();
            formData.append('image', file);

            if (imageUploadArea) {
                imageUploadArea.innerHTML = '<p class="text-gray-400">Uploading...</p>';
                imageUploadArea.classList.add('pointer-events-none');
            }

            try {
                const res = await fetch('/upload/image', { method: 'POST', body: formData });
                const data = await res.json();

                if (data.error) {
                    if (imageUploadArea) {
                        imageUploadArea.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                        imageUploadArea.classList.remove('pointer-events-none');
                    }
                    const previewItem = document.querySelector('.preview-item');
                    if (previewItem) previewItem.remove();
                    return;
                }

                const previewItem = document.querySelector('.preview-item');
                if (previewItem) {
                    previewItem.innerHTML = `
                        <span>●</span>
                        <img src="/assets/image/post/${data.filename}" class="w-10 h-10 object-cover rounded cursor-pointer">
                        <span class="flex-1 truncate">${escapeHtml(data.filename)}</span>
                        <button type="button" class="remove-media text-red-500 cursor-pointer hover:text-red-700 scale-200">&times;</button>
                        <input type="hidden" name="imgs[]" value="${escapeHtml(data.filename)}">
                    `;
                    previewItem.classList.remove('preview-item');

                    previewItem.querySelector('.remove-media').addEventListener('click', () => {
                        previewItem.remove();
                    });

                    const img = previewItem.querySelector('img');
                    img.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        openImagePreview(img.src);
                    });
                }

                if (imageUploadArea) {
                    imageUploadArea.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <p>Add Image</p>
                    `;
                    imageUploadArea.classList.remove('pointer-events-none');
                }
                if (imageFileInput) imageFileInput.value = '';

                if (addLinkImgModal) addLinkImgModal.classList.add('hidden');

            } catch (err) {
                if (imageUploadArea) {
                    imageUploadArea.innerHTML = '<p class="text-red-500">Upload failed</p>';
                    imageUploadArea.classList.remove('pointer-events-none');
                }
                const previewItem = document.querySelector('.preview-item');
                if (previewItem) previewItem.remove();
            }
        });
    }

    // Add link
    const addLinkBtn = document.getElementById('addLinkBtn');
    const linkUrl = document.getElementById('linkUrl');
    const linkText = document.getElementById('linkText');

    if (addLinkBtn) {
        addLinkBtn.addEventListener('click', () => {
            const url = linkUrl ? linkUrl.value.trim() : '';
            const text = linkText ? linkText.value.trim() : '';

            if (!url) {
                alert('Please enter a URL');
                return;
            }

            const display = text || url;

            const linkContainer = document.createElement('div');
            linkContainer.classList.add('link-hidden-inputs');
            
            const hiddenUrl = document.createElement('input');
            hiddenUrl.type = 'hidden';
            hiddenUrl.name = 'link_url[]';
            hiddenUrl.value = url;

            const hiddenText = document.createElement('input');
            hiddenText.type = 'hidden';
            hiddenText.name = 'link_text[]';
            hiddenText.value = display;

            linkContainer.appendChild(hiddenUrl);
            linkContainer.appendChild(hiddenText);
            postForm.appendChild(linkContainer);

            const linkRow = document.createElement('div');
            linkRow.className = 'media-item flex items-center gap-2 text-[#545F71] w-fit';
            linkRow.innerHTML = `
                <span>●</span>
                <a href="${escapeHtml(url)}" target="_blank" class="flex-1 truncate hover:underline">${escapeHtml(display)}</a>
                <button type="button" class="remove-media text-red-500 cursor-pointer hover:text-red-700 scale-200">&times;</button>
            `;

            linkRow.querySelector('.remove-media').addEventListener('click', () => {
                linkRow.remove();
                linkContainer.remove();
            });

            if (mediaPreview) mediaPreview.appendChild(linkRow);

            if (linkUrl) linkUrl.value = '';
            if (linkText) linkText.value = '';
            if (addLinkImgModal) addLinkImgModal.classList.add('hidden');
        });
    }

    if (postForm) {
        postForm.addEventListener('submit', function(e) {
            const titleInput = document.querySelector('input[name="title"]');
            const title = titleInput ? titleInput.value.trim() : '';

            if (!title) {
                e.preventDefault();
                alert('Please enter a post title');
                if (titleInput) titleInput.focus();
                return false;
            }

            let description = '';
            if (typeof tinymce !== 'undefined' && tinymce.get('mytextarea')) {
                description = tinymce.get('mytextarea').getContent().trim();
            } else {
                const descTextarea = document.querySelector('textarea[name="description"]');
                if (descTextarea) {
                    description = descTextarea.value.trim();
                }
            }

            if (!description) {
                e.preventDefault();
                alert('Please enter a post description');
                if (typeof tinymce !== 'undefined' && tinymce.get('mytextarea')) {
                    tinymce.get('mytextarea').focus();
                }
                return false;
            }
            return true;
        });
    }

    function openImagePreview(src) {
        const overlay = document.getElementById('imgOverlay');
        const overlayImg = document.getElementById('overlayImg');

        if (!overlay) {
            const xIcon = document.getElementById('xIconSvg')?.innerHTML || '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';

            const newOverlay = document.createElement('div');
            newOverlay.id = 'imgOverlay';
            newOverlay.className = 'fixed inset-0 z-50 backdrop-blur-md bg-gray-900/70 items-center justify-center transition-opacity duration-200';
            newOverlay.style.display = 'none';
            newOverlay.style.opacity = '0';
            newOverlay.innerHTML = `
                <button id="overlayClose" class="absolute top-6 right-6 text-white font-bold hover:opacity-70 z-50">
                    ${xIcon}
                </button>
                <img id="overlayImg" src="" class="max-w-[90vw] max-h-[90vh] object-contain rounded-2xl drop-shadow-2xl">
            `;
            document.body.appendChild(newOverlay);

            const newOverlayImg = document.getElementById('overlayImg');
            const newOverlayClose = document.getElementById('overlayClose');

            newOverlayClose.addEventListener('click', () => {
                newOverlay.style.opacity = '0';
                setTimeout(() => {
                    newOverlay.style.display = 'none';
                    newOverlayImg.src = '';
                }, 200);
            });

            newOverlay.addEventListener('click', (e) => {
                if (e.target === newOverlay) {
                    newOverlay.style.opacity = '0';
                    setTimeout(() => {
                        newOverlay.style.display = 'none';
                        newOverlayImg.src = '';
                    }, 200);
                }
            });

            newOverlayImg.src = src;
            newOverlay.style.display = 'flex';
            requestAnimationFrame(() => { newOverlay.style.opacity = '1'; });
        } else {
            overlayImg.src = src;
            overlay.style.display = 'flex';
            requestAnimationFrame(() => { overlay.style.opacity = '1'; });
        }
    }

    function initImagePreviewOnMedia() {
        document.querySelectorAll('.media-item img').forEach(img => {
            if (!img.hasClickListener) {
                img.hasClickListener = true;
                img.style.cursor = 'pointer';
                img.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const src = img.getAttribute('src');
                    if (src) {
                        openImagePreview(src);
                    }
                });
            }
        });
    }

    initImagePreviewOnMedia();

    const observer = new MutationObserver(() => {
        initImagePreviewOnMedia();
    });
    observer.observe(mediaPreview, { childList: true, subtree: true });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});