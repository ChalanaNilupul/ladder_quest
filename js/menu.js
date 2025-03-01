
function openTab(tabName) {
    $('.tabs').css('display','flex');
    let tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabName).classList.add('active');
}

function closeTab(){
    $('.tabs').css('display','none');
}