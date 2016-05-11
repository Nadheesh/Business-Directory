/**
 * Created by Nadheesh on 5/25/2016.
 */

//Control the main toolbar functionality

$(function() {

    //left side
    $( "#reset" ).button({
        text: false,
        icons: {
            primary: "fa fa-refresh"
        }
    });
    $( "#slider_container_save" )
        .button({
            text: false,
            icons: {
                primary: "fa fa-save"
            },

        });

    $( "#cancel" ).button({
        text: false,
        icons: {
            primary: "fa fa-remove"
        }
    }).click(function() {
//                        var options;
//                        if ( $( this ).text() === "play" ) {
//                            options = {
//                                label: "pause",
//                                icons: {
//                                    primary: "ui-icon-pause"
//                                }
//                            };
//                        } else {
//                            options = {
//                                label: "play",
//                                icons: {
//                                    primary: "ui-icon-play"
//                                }
//                            };
//                        }
//                        $( this ).button( "option", options );
    });

    //right side
    $( "#end" ).button({
            text: false,
            icons: {
                primary: "ui-icon-stop"
            }
        })
        .click(function() {
            $( "#play" ).button( "option", {
                label: "play",
                icons: {
                    primary: "ui-icon-play"
                }
            });
        });
    $( "#slides_g" ).button().change(function(e){
        e.preventDefault();
        smoothScrollById('slides');
        activateContentEditable('slides');
    });
    $( "#about_g" ).button().change(function(e){
        e.preventDefault();
        smoothScrollById('about');
        activateContentEditable('about');
    });
    $( "#shuffle" ).button();
    $( "#repeat" ).buttonset();


    function smoothScrollById(id){
        $('html,body').animate({
            scrollTop: $('#'+id).offset().top}, 1000
        );
    }

    function activateContentEditable(id){

        var editing = $('#guidanceGroup .selected');
        if (editing != null){

            $('#'+editing.name+' .editor')
                .removeClass('editableComponent').hallo({editable:false});

            editing.attr('aria-pressed', false).removeClass('ui-state-active selected');
            console.dir(editing.attr('for')+' '+id);

            if(editing.attr('for')===id+'_g'){
                return 0;
            }

        }

        $('#'+id+' .editor')
            .addClass('editableComponent').hallo({editable:true});


        $("#guidanceGroup label[for="+id+'_g'+"]")
            .attr('aria-pressed', true).addClass('ui-state-active selected');

    }
});