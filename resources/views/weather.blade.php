<!DOCTYPE html>
<html>
<head>
    <title>L_Weather</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<script>
	var authKey = "{{$authKey}}";
</script>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Get Weather</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="zipcode">Zip Code:</label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter Zip Code">
                            </div>
                            <button type="submit" class="btn btn-primary">Get Weather</button>
                        </form>
                    </div>
                </div>
                <div class="mt-6">
                    <p>Location: <span id="location"></span></p>
                    <p>Result: <span id="result"></span></p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>Temperature</th>
                                <th>Humidity</th>
                                <th>Feels Like</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Today</td>
                                <td><span id="todayTemp"></span></td>
                                <td><span id="todayFeelslike"></span></td>
                                <td><span id="todayHumidity"></span></td>
                            </tr>
                            <tr>
                                <td>Tomorrow</td>
                                <td><span id="tomorrowTemp"></span></td>
                                <td><span id="tomorrowFeelslike"></span></td>
                                <td><span id="tomorrowHumidity"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/weather.js') }}"></script>
</body>
</html>

