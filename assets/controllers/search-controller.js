import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        let input = document.getElementById("search");
let form = document.getElementById("formulaire")
input.addEventListener ('input', handleChange);
function handleChange(){
form.setAttribute('action', '/user/byrecette/'+input.value);
}
    }
}