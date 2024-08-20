jQuery(document).ready(function($) {

    $('#car-entry-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $('#car-entry-form')[0];
        var formData = new FormData(form);

        $.ajax({
            url: cars.ajax_url, // This is a localized variable, see below
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function(){
                $('.car-loader').show();
            },
            success: function(response) {
                
                $('.car-loader').hide();
                alert('Car details submitted successfully!');
                $('#car-entry-form')[0].reset();
                
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
    
});
