/**
 * Created by Nadheesh on 5/25/2016.
 */

    //=========================HALO activate start================================
jQuery('.editableParagraph').hallo({
    plugins: {
        'halloformat': {},
        'halloheadings': {},
        'hallolists': {},
        'halloreundo': {},
        'hallojustify': {},
        'hallolink': {},
    },
    toolbar: 'halloToolbarFixed',
    editable : false
}).bind('hallomodified' , function(event,data){
    var input_id = $(event.target).data('input');
    if (input_id !=""){
        $("input[id="+input_id+"]").val(data.content);
//                alert($("input[id="+input_id+"]").val() + data.content +input_id+'asd');
    }
});


jQuery('.editableHeader').hallo({
    plugins: {
        'halloformat': {},
        'halloheadings': {},
        'halloreundo': {}
    },
    toolbar: 'halloToolbarFixed',
    editable : false
}).bind('hallomodified' , function(event,data){
    var input_id = $(event.target).data('input');
    if (input_id !=""){
        $("input[id="+input_id+"]").val(data.content);
//                alert($("input[id="+input_id+"]").val() + data.content +input_id+'asd');
    }
});


jQuery('.editable').hallo({
    editable : false
}).bind('hallomodified' , function(event,data){
    var input_id = $(event.target).data('input');
    if (input_id !=""){
        $("input[id="+input_id+"]").val(data.content);
//                alert($("input[id="+input_id+"]").val() + data.content +input_id+'asd');
    }
});



//=========================HALO Activate end========================================
