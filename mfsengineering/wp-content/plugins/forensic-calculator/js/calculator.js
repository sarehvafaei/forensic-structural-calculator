jQuery(document).ready(function($) {
    $('#beam-deflection-form').on('submit', function(e) {
        e.preventDefault();
        
        const data = {
            length: $('#length').val(),
            load: $('#load').val(),
            elastic_modulus: $('#elastic_modulus').val(),
            moment_of_inertia: $('#moment_of_inertia').val()
        };

        $.ajax({
            url: calculatorAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'calculate_structure',
                nonce: calculatorAjax.nonce,
                type: 'beam-deflection',
                data: data
            },
            success: function(response) {
                if (response.success) {
                    const result = response.data;
                    $('#beam-results')
                        .html(`
                            <h4>Results:</h4>
                            <p>Maximum Deflection: ${result.deflection.toFixed(6)} meters</p>
                        `)
                        .show();
                } else {
                    alert('Calculation failed. Please check your inputs.');
                }
            },
            error: function() {
                alert('Server error. Please try again later.');
            }
        });
    });
});