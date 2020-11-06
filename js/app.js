document.addEventListener('DOMContentLoaded', function () {
    let elemsModal = document.querySelector('.modal');
    let instancesModal = M.Modal.init(elemsModal);

    let elemsChips = document.querySelectorAll('.chips');
    let instancesChips = M.Chips.init(elemsChips);

    var elemsTool = document.querySelectorAll('.tooltipped');
    var instancesTool = M.Tooltip.init(elemsTool);

    console.log("Chargement du DOM OK");

});