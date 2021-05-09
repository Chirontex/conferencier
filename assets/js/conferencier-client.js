const ConferencierClient = {
    delay: (id, time) => {
        setTimeout((id) => {
            document.getElementById(id).
                setAttribute('style', 'margin: 0px;');
        }, time, id);
    }
};
