function cleanColor(value) {
    return value.replace('#', '');
}

function updatePreview(index) {
    const top    = cleanColor(document.querySelectorAll('input[name="color_top[]"]')[index].value);
    const bottom = cleanColor(document.querySelectorAll('input[name="color_bottom[]"]')[index].value);
    document.querySelectorAll('.color-preview')[index].style.background = 
        `linear-gradient(to bottom, #${top}, #${bottom})`;
}

document.querySelectorAll('input[name="color_top[]"]').forEach((input, index) => {
    input.addEventListener('input', () => {
        document.querySelectorAll('.color-top')[index].style.backgroundColor = '#' + cleanColor(input.value);
        updatePreview(index);
    });
});

document.querySelectorAll('input[name="color_bottom[]"]').forEach((input, index) => {
    input.addEventListener('input', () => {
        document.querySelectorAll('.color-bottom')[index].style.backgroundColor = '#' + cleanColor(input.value);
        updatePreview(index);
    });
});