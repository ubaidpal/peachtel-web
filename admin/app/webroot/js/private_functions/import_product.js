$(function() {
    var countFile = 0;
    var countFileInc = 0;
    $('#swfupload-control').swfupload({
        upload_url: "bulkUploadImages",
        file_post_name: 'BulkImages',
        file_size_limit : "5024",
        file_types : "*.jpg;*.png;*.gif",
        file_types_description : "Image files",
        flash_url : "../js/multi_load/swfupload/swfupload.swf",
        button_image_url : '../js/multi_load/swfupload/wdp_buttons_upload_114x29.png',
        button_width : 114,
        button_height : 29,
        button_placeholder : $('#multiLoad')[0],
        debug: false
    })
    .bind('fileQueued', function(event, file){
        var listitem='<li id="'+file.id+'" >'+
            '<p class="status" >Pending.</p>'+
            '<span class="cancel">&nbsp;</span>'+
            'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
            '<div class="progressbar" ><div class="progress" ></div></div>'+
            '</li>';
        $('#log').append(listitem);
        
        /** Bind cancel after image Queued */
        $('li#'+file.id+' .cancel').bind('click', function(){
            
            var swfu = $.swfupload.getInstance('#swfupload-control');
            swfu.cancelUpload(file.id);
            $('li#'+file.id).fadeOut('fast');
            countFile--;
            $('#queuestatus').html('<div style="padding: 5px;">Files Selected: '+countFile+"</div>");
            
        });
    })
    .bind('fileQueueError', function(event, file, errorCode, message){
        alert('Size of the file '+file.name+' is greater than limit');
    })
    .bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
        countFile += numFilesSelected;
        $('#queuestatus').html('<div style="padding: 5px;">Files Selected: '+countFile+"</div>");
    })
    .bind('uploadStart', function(event, file){
        $('#log li#'+file.id).find('p.status').text('Uploading...');
        $('#log li#'+file.id).find('span.progressvalue').text('0%');
        $('#log li#'+file.id).find('span.cancel').hide();
        countFileInc++;
    })
    .bind('uploadProgress', function(event, file, bytesLoaded){
        var percentage=Math.round((bytesLoaded/file.size)*100);
        $('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
        $('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
    })
    .bind('uploadSuccess', function(event, file, serverData){
        var item=$('#log li#'+file.id);
        item.find('div.progress').css('width', '100%');
        item.find('span.progressvalue').text('100%');
        item.addClass('success').find('p.status').html('Finished!');
    })
    .bind('uploadComplete', function(event, file){
        $(this).swfupload('startUpload');
        if(countFile == countFileInc) {
            setTimeout(function() {$("#NextusaItakiNetworkProductForm").submit()}, 1000);
        }
    });
    
    $("#NextusaItakiNetworkProductForm .submit input[type='submit']").live('click', function() {
        $('#swfupload-control').swfupload('startUpload');
    });
});