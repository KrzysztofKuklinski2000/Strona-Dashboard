const imageInput = document.querySelectorAll('[data-compress-image]');

const compressionOption = {
    maxSizeMB: 2,
    maxWidthOrHeight: 1920,
    initialQuality: 0.82,
    useWebWorker: true,
};

function bytesToMegabytes(bytes) {
    return (bytes / 1024 / 1024).toFixed(2);
}

function setSubmissionButtonsDisabled(form, disabled) {
    [...form.elements].forEach((button) => {
        if (button.matches('button[type="submit"], input[type="submit"]')) {
            button.disabled = disabled;
        }
    });
}

imageInput.forEach((input) => {
    input.addEventListener('change', async () => {
        const selectedFile = input.files?.[0];
        const form = input.form;

        if (!selectedFile || !form) {
            return;
        }

        input.dataset.compressionState = 'processing'
        setSubmissionButtonsDisabled(form, true);

        try {
            const compressedFile = await imageCompression(
                selectedFile,
                compressionOption
            );

            const optimizedFile = new File(
                [compressedFile],
                selectedFile.name,
                {
                    type: compressedFile.type,
                    lastModified: selectedFile.lastModified,
                }
            );

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(optimizedFile);
            input.files = dataTransfer.files;

            input.dataset.compressionState = 'ready';
        } catch (error) {
            input.value = '';
            input.dataset.compressionState = 'error';

            console.error('Nie udało się skompresować zdjęcia:', error);
        } finally {
            setSubmissionButtonsDisabled(form, false);
        }
    });
});
