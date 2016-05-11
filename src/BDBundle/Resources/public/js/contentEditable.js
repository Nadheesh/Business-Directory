/**
 * Created by Nadheesh on 5/23/2016.
 */


//slider contenteditable functions
$('#slides').superslides('stop');


var all = $(".mbox").map(function() {
    return this.innerHTML;
}).get();