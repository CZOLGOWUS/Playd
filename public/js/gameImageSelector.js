const mainFramePhoto = document.querySelector(".photo-selected img");
const mainFramePhotoSrc = mainFramePhoto.src;

function gallery(activeImgTag, availableImgTags)
{
    availableImgTags.forEach((clickablePhoto) => clickablePhoto.addEventListener("click", () =>
    {
        // 1.pobrac src z clickablePhoto
        let imageSrc = clickablePhoto.src;
        // 2. podmienic src activeImgTag na to pobrane
        activeImgTag.src = imageSrc;
    }))
}

function initSelector() {
    // wspólny rodzic kilkalnej galerii i tego głównego zdjęcia
    const galleryRoot = document.querySelector(".game-photos")

    if (!galleryRoot) return;

    // konwersja na array, bo .querySelectorAll zwraca NodeList które nie ma wszystkich metod tablicy
    const availableImagesTags = Array.from(galleryRoot.querySelectorAll(".photo-in-gallery img"))
    const activeImageTag = galleryRoot.querySelector(".photo-selected img")

    gallery(activeImageTag, availableImagesTags)
}

// po załadowaniu strony uruchom skrypt
window.addEventListener('DOMContentLoaded', initSelector);