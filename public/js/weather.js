$(document).ready(function () {
	$('form').on('submit', function (event) {
        event.preventDefault();
        var zipcode = $('#zipcode').val();
        var url = "api/weather/" + zipcode;


        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-AUTH': authKey
            },
            success: function (response) {
		    $('#location').text(zipcode);
                    $('#result').text(response.status);
                    $('#todayTemp').text(response.today.temp);
                    $('#todayHumidity').text(response.today.humidity);
                    $('#todayFeelslike').text(response.today.feelslike);
                    $('#tomorrowTemp').text(response.tomorrow.temp);
                    $('#tomorrowHumidity').text(response.tomorrow.humidity);
                    $('#tomorrowFeelslike').text(response.tomorrow.feelslike);
            },
            error: function (xhr, status, error) {
                    $('#location').text('');
                    $('#result').text(xhr.responseJSON.status);
                    $('#todayTemp').text('');
                    $('#todayHumidity').text('');
                    $('#todayFeelslike').text('');
                    $('#tomorrowTemp').text('');
                    $('#tomorrowHumidity').text('');
                    $('#tomorrowFeelslike').text('');
		    alert(xhr.responseJSON.message);
            }
        });
    });
});

