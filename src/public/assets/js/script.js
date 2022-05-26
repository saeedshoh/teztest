bsCustomFileInput.init();
$(".select2").select2();

$(".popup-gallery").magnificPopup({
    delegate: "a",
    type: "image",
    tLoading: "Loading image #%curr%...",
    mainClass: "mfp-img-mobile",
    gallery: {enabled: !0, navigateByImgClick: !0, preload: [0, 1]},
    image: {tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'}
});




