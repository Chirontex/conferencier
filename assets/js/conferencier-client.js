const ConferencierClient = {
    content : '',
    delay: (id, time) => {
        setTimeout((id) => {
            document.getElementById(id).
                setAttribute('style', 'margin: 0px auto;');
        }, time, id);
    }
};
