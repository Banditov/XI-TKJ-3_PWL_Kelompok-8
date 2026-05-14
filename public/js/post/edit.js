document.addEventListener('DOMContentLoaded', () => {
    console.log('Edit.js loaded');

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
        const top = document.getElementById('colorTop');
        const bottom = document.getElementById('colorBottom');
        if (top && bottom) {
            const topVal = cleanColor(top.value);
            const bottomVal = cleanColor(bottom.value);
            const preview = document.querySelector('.color-preview');
            if (preview) {
                preview.style.background = `linear-gradient(to bottom, #${topVal}, #${bottomVal})`;
            }
        }
    }

    // Colour preview
    const colorTop = document.getElementById('colorTop');
    const colorBottom = document.getElementById('colorBottom');
    const colorTopDiv = document.querySelector('.color-top');
    const colorBottomDiv = document.querySelector('.color-bottom');

    if (colorTop) {
        colorTop.addEventListener('input', function() {
            if (colorTopDiv) colorTopDiv.style.backgroundColor = '#' + cleanColor(this.value);
            updatePreview();
        });
    }

    if (colorBottom) {
        colorBottom.addEventListener('input', function() {
            if (colorBottomDiv) colorBottomDiv.style.backgroundColor = '#' + cleanColor(this.value);
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

    // Add tag
    const addTagBtn = document.getElementById('addTagBtn');
    const tagPreview = document.getElementById('tagPreview');
    const postForm = document.getElementById('postForm');
    const tagNameInput = document.getElementById('tagName');

    if (addTagBtn) {
        addTagBtn.addEventListener('click', () => {
            const name = tagNameInput ? tagNameInput.value.trim() : '';
            const colorTopVal = colorTop ? cleanColor(colorTop.value) : 'ffffff';
            const colorBotVal = colorBottom ? cleanColor(colorBottom.value) : 'ffffff';
            const iconName = iconInput ? iconInput.value : 'tag';
            const iconSvg = iconPreview ? iconPreview.innerHTML : '';

            if (!name) {
                alert('Please enter a tag name');
                if (tagNameInput) tagNameInput.focus();
                return;
            }

            const textColor = getTextColor(colorTopVal, colorBotVal);

            const hiddenContainer = document.createElement('div');
            hiddenContainer.classList.add('tag-hidden-inputs');
            hiddenContainer.innerHTML = `
                <input type="hidden" name="tag_name[]" value="${escapeHtml(name)}">
                <input type="hidden" name="tag_color_top[]" value="${colorTopVal}">
                <input type="hidden" name="tag_color_bottom[]" value="${colorBotVal}">
                <input type="hidden" name="tag_icon[]" value="${iconName}">
            `;
            if (postForm) postForm.appendChild(hiddenContainer);

            const tag = document.createElement('div');
            tag.className = 'tag-preview-item px-4 py-2 rounded-full drop-shadow-lg flex gap-2 items-center justify-center';
            tag.style.background = `linear-gradient(to bottom, #${colorTopVal}, #${colorBotVal})`;
            tag.style.color = textColor;
            tag.innerHTML = `
                <div class="w-6 h-6">${iconSvg}</div>
                <span>${escapeHtml(name)}</span>
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
            if (colorTop) colorTop.value = '';
            if (colorBottom) colorBottom.value = '';
            if (colorTopDiv) colorTopDiv.style.backgroundColor = '';
            if (colorBottomDiv) colorBottomDiv.style.backgroundColor = '';
            if (document.querySelector('.color-preview')) {
                document.querySelector('.color-preview').style.background = '';
            }
            if (iconInput) iconInput.value = 'tag';
            if (iconPreview) iconPreview.innerHTML = defaultIconSvg;
        });
    }

    // Remove tag
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

    // Remove media
    document.querySelectorAll('.remove-media').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const mediaDiv = this.closest('.media-item');
            if (mediaDiv) {
                mediaDiv.remove();
            }
        });
    });

    // Link & Image modal
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

    // Image upload
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
                    return;
                }

                const hiddenImg = document.createElement('input');
                hiddenImg.type = 'hidden';
                hiddenImg.name = 'imgs[]';
                hiddenImg.value = data.filename;
                hiddenImg.id = 'img_' + data.filename;
                if (postForm) postForm.appendChild(hiddenImg);

                const imgRow = document.createElement('div');
                imgRow.className = 'media-item flex items-center gap-3 text-[#545F71]';
                imgRow.innerHTML = `
                    <img src="/assets/image/post/${data.filename}" class="w-12 h-12 object-cover rounded-lg">
                    <p class="flex-1 truncate">${escapeHtml(data.filename)}</p>
                    <button type="button" class="remove-media text-red-400 font-bold hover:text-red-600">&times;</button>
                `;
                imgRow.querySelector('.remove-media').addEventListener('click', () => {
                    imgRow.remove();
                    document.getElementById('img_' + data.filename)?.remove();
                });
                if (mediaPreview) mediaPreview.appendChild(imgRow);

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

            } catch (err) {
                if (imageUploadArea) {
                    imageUploadArea.innerHTML = '<p class="text-red-500">Upload failed</p>';
                    imageUploadArea.classList.remove('pointer-events-none');
                }
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

            const hiddenUrl = document.createElement('input');
            hiddenUrl.type = 'hidden';
            hiddenUrl.name = 'link_url[]';
            hiddenUrl.value = url;

            const hiddenText = document.createElement('input');
            hiddenText.type = 'hidden';
            hiddenText.name = 'link_text[]';
            hiddenText.value = display;

            const linkContainer = document.createElement('div');
            linkContainer.classList.add('link-hidden-inputs');
            linkContainer.appendChild(hiddenUrl);
            linkContainer.appendChild(hiddenText);
            if (postForm) postForm.appendChild(linkContainer);

            const linkRow = document.createElement('div');
            linkRow.className = 'media-item flex items-center gap-3 text-[#545F71]';
            linkRow.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 015.656 0l4-4a4 4 0 01-5.656-5.656l-1.1 1.1"/>
                </svg>
                <a href="${escapeHtml(url)}" target="_blank" class="flex-1 truncate hover:underline">${escapeHtml(display)}</a>
                <button type="button" class="remove-media text-red-400 font-bold hover:text-red-600">&times;</button>
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

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    updatePreview();

    const deletePostBtn = document.getElementById('deletePostBtn');
    if (deletePostBtn) {
        deletePostBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (confirm('Are you sure you want to delete this post? This action cannot be undone and will delete all comments, replies, images, and links associated with this post.')) {
                const postId = window.location.pathname.split('/')[2];
                
                fetch(`/posts/${postId}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        window.location.href = '/posts';
                    }
                }).catch(error => {
                    console.error('Delete error:', error);
                    window.location.href = '/posts';
                });
            }
        });
    }
});