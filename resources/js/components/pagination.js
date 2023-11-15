import React from 'react';
import ReactDOM from 'react-dom';

function appendTodo(type) {
    switch (type) {
        case 1:
            console.log();
            break
        case 2:
            console.log('textarea');
            break

        default:
            console.log('text');
            break
    }
}
function Pagination() {

    return (

        <div />
    );
}

export default Pagination;

if (document.getElementById('Pagination')) {
    ReactDOM.render(<Pagination />, document.getElementById('Pagination'));
}
