(function() {

    let layoutMainMenu =
        document.querySelector('#layout-mainmenu');

    // ---

    let itemsTemplate =
        document.querySelector('template#kpolicar_backendmenupinnedpages_mainmenu-items-extension');

    let previewButton =
        layoutMainMenu.querySelector('.main-menu-container .navbar ul.mainmenu-items[data-main-menu] > li.mainmenu-item.mainmenu-preview');

    let templateContent = itemsTemplate.content.cloneNode(true);
    previewButton.parentNode.prepend(templateContent)



    let dropdownsTemplate =
        document.querySelector('template#kpolicar_backendmenupinnedpages_mainmenu-submenu-dropdowns');

    let templateContent2 = dropdownsTemplate.content.cloneNode(true);
    layoutMainMenu.append(templateContent2)

}());
