setSidebarVisibility();

$('#sidebar .heading').click(
    function() {
        toggleVisibilityOfNextElement($(this));
        storeSidebarVisibility();
    }
);

function toggleVisibilityOfNextElement(previousElement) {

    element = previousElement.next();

    if (element.length == 0) {
        return;
    }

    if (element.hasClass('heading')) {
        return;
    }

    if (element.css('display') == 'none') {
        element.css('display', '')
        previousElement.removeClass('collapsed')
    } else {
        element.css('display', 'none')
        previousElement.addClass('collapsed')
    }

    toggleVisibilityOfNextElement(element);
}

function storeSidebarVisibility() {
    var nodes = $('#sidebar li');
    var v = [];
    for (var i = 0; i < nodes.length; i++) {
        node = nodes[i];
        if (node.className.indexOf('heading') != -1) {
            v.push('heading')
        } else if (node.style.display == 'none') {
            v.push('hidden')
        } else {
            v.push('visible')
        }
    }
    localStorage.sidebarVisiblity = v.join(',');
}

function setSidebarVisibility() {
    var v = localStorage.sidebarVisiblity;
    if (v === undefined) {
        return;
    }
    v = v.split(',');

    var nodes = $('#sidebar li');

    // Check for changes: Different count or headings at different positions
    if (nodes.length != v.length) {
        return;
    }
    for (var i = 0; i < nodes.length; i++) {
        node = nodes[i];
        if (node.className.indexOf('heading') != -1) {
            if (v[i] != 'heading') {
                return;
            }
        }
    }

    for (var i = 0; i < nodes.length; i++) {
        node = nodes[i];
        if (node.className.indexOf('heading') == -1) {
            if (v[i] == 'hidden') {
                node.style.display = 'none';
            } else {
                node.style.display = '';
            }
        }
    }

}
