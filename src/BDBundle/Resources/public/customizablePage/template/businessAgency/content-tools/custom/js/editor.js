/**
 * Created by Nadheesh on 5/27/2016.
 */

function imageUploader(dialog) {
    var image, xhr, xhrComplete, xhrProgress;

    // Set up the event handlers

    //user cancel image upload
    dialog.addEventListener('imageuploader.cancelupload', function () {
        // Cancel the current upload

        // Stop the upload
        if (xhr) {
            xhr.upload.removeEventListener('progress', xhrProgress);
            xhr.removeEventListener('readystatechange', xhrComplete);
            xhr.abort();
        }

        // Set the dialog to empty
        dialog.state('empty');
    });

    dialog.addEventListener('imageuploader.clear', function () {
        // Clear the current image
        dialog.clear();
        image = null;
    });

    dialog.addEventListener('imageuploader.fileready', function (ev) {

        // Upload a file to the server
        var formData;
        var file = ev.detail().file;

        // Define functions to handle upload progress and completion
        xhrProgress = function (ev) {
            // Set the progress for the upload
            dialog.progress((ev.loaded / ev.total) * 100);
        }

        xhrComplete = function (ev) {
            var response;

            // Check the request is complete
            if (ev.target.readyState != 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrProgress = null
            xhrComplete = null

            // Handle the result of the upload
            if (parseInt(ev.target.status) == 200) {
                // Unpack the response (from JSON)
                response = JSON.parse(ev.target.responseText);

                // Store the image details
                image = {
                    size: response.size,
                    url: response.url,
                    file_name: response.file_name
                };

                // Populate the dialog
                dialog.populate(image.url, image.size);

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog state to uploading and reset the progress bar to 0
        dialog.state('uploading');
        dialog.progress(0);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('image', file);

        // Make the request
        var path = $('#image_upload_path').val();

        xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', xhrProgress);
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', path, true);
        xhr.send(formData);
    });

    dialog.addEventListener('imageuploader.save', function () {
        var crop, formData;

        // Define a function to handle the request completion
        xhrComplete = function (ev) {
            // Check the request is complete
            if (ev.target.readyState !== 4) {
                return;
            }

            // Clear the request
            xhr = null
            xhrComplete = null

            // Free the dialog from its busy state
            dialog.busy(false);

            // Handle the result of the rotation
            if (parseInt(ev.target.status) === 200) {
                // Unpack the response (from JSON)
                var response = JSON.parse(ev.target.responseText);

                // Trigger the save event against the dialog with details of the
                // image to be inserted.
                dialog.save(
                    response.url,
                    image.size,
                    {
                        'alt': response.alt,
                        'data-ce-max-width': image.size[0]
                    });

            } else {
                // The request failed, notify the user
                new ContentTools.FlashUI('no');
            }
        }

        // Set the dialog to busy while the rotate is performed
        dialog.busy(true);

        // Build the form data to post to the server
        formData = new FormData();
        formData.append('file_name', image.file_name);
        formData.append('url', image.url);

        // Set the width of the image when it's inserted, this is a default
        // the user will be able to resize the image afterwards.


        formData.append('width', image.width);

        // Check if a crop region has been defined by the user
        if (dialog.cropRegion()) {
            formData.append('crop', dialog.cropRegion());
        }

        // Make the request
        var path = $('#image_save_path').val();

        xhr = new XMLHttpRequest();
        xhr.addEventListener('readystatechange', xhrComplete);
        xhr.open('POST', path, true);
        xhr.send(formData);
    });
}



window.addEventListener('load', function() {
    var editor;


    ContentTools.StylePalette.add([
        new ContentTools.Style('Row', 'row', ['h1','h2','h3','h4','h5','h6','p','img']),
        new ContentTools.Style('Column', 'col-md-3', ['h1','h2','h3','h4','h5','h6','p','img']),
		new ContentTools.Style('Intro text', 'intro-lead-in', ['h1','h2','h3','h4','h5','h6','p']),
		new ContentTools.Style('Intro Header', 'intro-heading', ['h1','h2','h3','h4','h5','h6','p']),
		new ContentTools.Style('Section Heading', 'section-heading', ['h1','h2','h3','h4','h5','h6']),
		new ContentTools.Style('Section Sub Heading', 'section-subheading ', ['h1','h2','h3','h4','h5','h6']),
		new ContentTools.Style('Mute text', 'text-muted', ['h1','h2','h3','h4','h5','h6','p']),
		new ContentTools.Style('Image-Responsive', 'img-responsive', ['img']),
		new ContentTools.Style('Image-Centered', 'img-centered', ['img']),
        new ContentTools.Style('Font-awesome Icon', 'fa', ['a','i','span']),
        new ContentTools.Style('FA Icon-twitter', ' fa-twitter', ['a','i','span']),



    ]);

    //tagNames = ContentEdit.TagNames.get();
    //tagNames.register('intro-lead-in','p' );

    // Listen for any new element being added to the editable tree
    ContentEdit.Root.get().bind('attach', function (dom,element) {

        if (element.type() === 'Image') {

            var dom_element = dom.domElement();

            //edit about timeline images
            if (dom_element.className === 'timeline-image') {
                element.addCSSClass('img-circle');
                element.addCSSClass('img-responsive');
                //element.resize(['top', 'left'],100,100);
                element.size([156, 156]);

                //    element.
                //    'alt': response.alt,
                //        'data-ce-max-width': image.size[0]
            }else if (dom_element.className === 'team-member') {
                element.addCSSClass('img-circle');
                element.addCSSClass('img-responsive');
                //element.resize(['top', 'left'],100,100);
                element.size([225, 225]);

                //    element.
                //    'alt': response.alt,
                //        'data-ce-max-width': image.size[0]
            }
            else if (dom_element.id === 'intro') {
                $('header').css('background-image', 'url('+element.attr('src')+')');
                element.parent().detach(element);

            }
            else if (dom_element.className ==='portfolio-image-container'){
                element.size([360,260]);

            }else{

            }

            //remove attr set as image.height=9

            if(element.attr('height') === 0){
                element.removeAttr('height');
            }

        }
    });

    //add custom image uploader to the editor
    ContentTools.IMAGE_UPLOADER = imageUploader;

    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');


    editor.addEventListener('start', function (ev) {

        //remove attr set as image.height=9
        $('.hidden-element').css('display','');
        $('.hideable').addClass('hideable-style');
        //$('.hide-button').css('display','inline-block');

        //disable portfolio links
        $('.portfolio-image-container').parent().attr('href','');


        //var selected =$('#selectable .ui-selected');
        //
        //if (selected.length > 0){
        //    $(selected).removeClass('ui-selected');
        //    this.stop();
        //    console.dir('stop');
        //}else{
        //
        //}


    });

    editor.addEventListener('stop', function (ev) {
        $('.hideable').removeClass('hideable-style');
        //$('.hide-button').css('display','none');
        $('.hidden-element').css('display','none');

        //set portfolio links
        $('.portfolio-image-container').each(function(index){
            index++;
            $(this).parent().attr('href','#portfolioModal'+index);
        });



        //var selectable = $( "#selectable" );
        //selectable.selectable( "enable" );$( "#selectable" ).selectable( "option", "disabled", false );

        //if( selectable.selectable( "option", "disabled" )){
        //}else{
        //   this.start();
        //    console.dir('start');
        //}
    });


    //submit symfony form
    editor.addEventListener('saved', function (ev) {
        var name, payload, regions, xhr, visibles;

        // Check that something changed
        visibles = getVisibleElements();

        regions = ev.detail().regions;
        if (Object.keys(regions).length == 0 && !getModified()) {
            return;
        }

        // Set the editor as busy while we save our changes
        this.busy(true);
        //get all regions(not only modified ones)
        regions = {};
        for (name in this.regions()) {
            regions[name]=this.regions()[name].html();
        }
        regions['header_image'] = $('header').css('background-image');

        // Collect the contents of each region into a FormData instance
        $('#company_page_website').val(JSON.stringify(regions));
        $('#company_page_visible_elements').val(JSON.stringify(visibles));
        $('#company_template_name').val(document.querySelector('meta[name=template]').getAttribute('content'));
        $('#company_page_images').val(JSON.stringify(getImages()));

        $("form[name='company_page']").submit();

    });

    $("form[name='company_page']").on('submit' , function(e) {

        e.preventDefault();
        var path = $('#save_path').val();

        $.ajax({
            type: 'POST',
            url: path,
            data: $(this).serializeArray(),
            success: function (data) {
                editor.busy(false);
                setModified(false);
                new ContentTools.FlashUI('ok');
                console.dir(data);
            },
            error: function (e) {
                console.dir('error');
                editor.busy(false);
                new ContentTools.FlashUI('no');
            },
        });

    });

    function getImages() {
        // Return an object containing image URLs and widths for all regions
        var descendants, i, images;
        images = {};
        for (name in editor.regions()) {
            // Search each region for images
            descendants = editor.regions()[name].descendants();

            for (i = 0; i < descendants.length; i++) {

                // Filter out elements that are not images
                if (descendants[i].type() !== 'Image') {
                    continue;
                }
                images[descendants[i].attr('src')] = descendants[i].size()[0];
            }
        }
        return images;
    }


    //save normally
    //editor.addEventListener('saved', function (ev) {
    //    var name, payload, regions, xhr, visibles;
    //
    //    // Check that something changed
    //    visibles = getVisibleElements();
    //
    //    regions = ev.detail().regions;
    //    if (Object.keys(regions).length == 0 && !getModified()) {
    //        return;
    //    }
    //
    //    // Set the editor as busy while we save our changes
    //    this.busy(true);
    //
    //    //get all regions(not only modified ones)
    //    regions = {};
    //    for (name in this.regions()) {
    //        regions[name]=this.regions()[name].html();
    //    }
    //    regions['header_image'] = $('header').css('background-image');
    //
    //    // Collect the contents of each region into a FormData instance
    //    payload = new FormData();
    //
    //    payload.append('template_name', document.querySelector('meta[name=template]').getAttribute('content'));
    //    payload.append('images', JSON.stringify(getImages()));
    //    payload.append('regions', JSON.stringify(regions));
    //    payload.append('visible-elements', JSON.stringify(visibles));
    //
    //
    //    // Send the update content to the server to be saved
    //    function onStateChange(ev) {
    //        // Check if the request is finished
    //        if (ev.target.readyState == 4) {
    //            console.dir(ev.target);
    //            editor.busy(false);
    //            if (ev.target.status == '200') {
    //                // Save was successful, notify the user with a flash
    //               setModified(false);
    //                new ContentTools.FlashUI('ok');
    //            } else {
    //                // Save failed, notify the user with a flash
    //                new ContentTools.FlashUI('no');
    //            }
    //        }
    //    };
    //
    //    var path = $('#save_path').val();
    //
    //    //save normally
    //    xhr = new XMLHttpRequest();
    //    xhr.addEventListener('readystatechange', onStateChange);
    //    xhr.open('POST',path);
    //    xhr.send(payload);
    //});




});

