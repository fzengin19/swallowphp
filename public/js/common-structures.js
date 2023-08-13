function openModal(modalId) {
    $('#' + modalId).addClass('active').focus();
}
function closeModal() {
    $('.cmodal.active').removeClass('active');
}
function moveToTargetModal(target) {
    closeModal();
    openModal(target);
}




$(document).ready(function () {
    function openModal(modalId) {
        $('#' + modalId).addClass('active').focus();
    }
    function closeModal() {
        $('.cmodal.active').removeClass('active');
    }
    function moveToTargetModal(target) {
        closeModal();
        openModal(target);
    }
    
    $(".cmodal").mousedown(function (e) {
        var container = $(".cmodal .cmodal-content");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            closeModal();
        }
    });
    window.onkeydown = function(evt) {
        evt = evt || window.event;
        if (evt.keyCode == 27) {
            closeModal();
        }
        if (evt.keyCode == 13) {
            $('.cmodal.active .btn-submit').click();
        }
    };

    $(".ctab .tab-link").mousedown(function (e) {
        $('.ctab .tab-link.active').removeClass('active');
        e.target.className += ' active';
        $('.ctab .tab-page.active').removeClass('active');
        var pageId = e.target.attributes.target.value;
        $("#" + pageId).addClass('active');
    });

});
