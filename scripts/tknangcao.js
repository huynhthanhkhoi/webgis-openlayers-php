// Chuyển tab
function openTab(evt, cityName) {
    var i, contentProductTabs, tabsLinks;
    contentProductTabs = document.getElementsByClassName("contentProductTabs");
    for (i = 0; i < contentProductTabs.length; i++) {
        contentProductTabs[i].style.display = "none";
    }
    tabsLinks = document.getElementsByClassName("tabsLinks");
    for (i = 0; i < tabsLinks.length; i++) {
        tabsLinks[i].className = tabsLinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
// End chuyển tab

// Hiển thị tab1 tìm kiếm thuộc tính
var contents = document.getElementsByClassName('contentProductTabs');
function showContent(id) {
    for (var i = 0; i < contents.length; i++) {
        contents[i].style.display = 'none';
    }
    var content = document.getElementById(id);
    content.style.display = 'block';
}
showContent('tab1');
// End Hiển thị tab1 tìm kiếm thuộc tính