/**
 * Created by Nadheesh on 5/30/2016.
 */

var modified = false;

$( ".hide-button" ).click(function() {
    var hideable = $(this).parent();
    if(hideable.hasClass('hideable')){
        modified = true;
        if(hideable.hasClass('hidden-element')){
            $(this).removeClass('glyphicon-plus');
            $(this).addClass('glyphicon-minus');
            hideable.removeClass('hidden-element');
        }else{
            $(this).removeClass('glyphicon-minus');
            $(this).addClass('glyphicon-plus');
            hideable.addClass('hidden-element')
        }
    }

});


function getVisibleElements() {
    //hideable areas in businessAgency template
    //    **timeline
    //    **portfolio
    //    **team
    var visibles, about_visibles, portfolio_visibles, team_visibles;

    visibles = {};
    about_visibles = [];
    portfolio_visibles = [];
    team_visibles = [];

    $('.timeline .hideable').each(function (key, element) {
        if (!$(element).hasClass('hidden-element')) {
            key++;
            about_visibles.push(key);
        }
    });

    $('#portfolio .hideable').each(function (key, element) {
        if (!$(element).hasClass('hidden-element')) {
            key++;
            portfolio_visibles.push(key);
        }
    });


    $('#team .hideable').each(function (key, element) {
        if (!$(element).hasClass('hidden-element')) {
            key++;
            team_visibles.push(key);
        }
    });

    visibles['about'] = about_visibles;
    visibles['portfolio'] = portfolio_visibles;
    visibles['team'] = team_visibles;

    return visibles;
}


function setModified(value){
    modified = value;
}


function getModified(){
   return modified;
}
