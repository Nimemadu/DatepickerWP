<?php 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datepicker Example</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <style>
        .ui-datepicker .ui-datepicker-calendar .ui-state-disabled {
            background: #f2f2f2;
            border: 1px solid #ddd;
            color: #999;
        }
    </style>
</head>
<body>

<input type="text" id="datepicker">

<script>
jQuery(document).ready(function($) {
    $.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        method: 'POST',
        data: {
            action: 'fetch_holidays_and_date_range'
        },
        success: function(response) {
            if (response) {
                var holidays = response.holidays.map(date => date.split(' ')[0]); // Extract date portion
                var startDate = new Date(response.date_range.start_date);
                var endDate = new Date(response.date_range.end_date);

                $("#datepicker").datepicker({
                    beforeShowDay: function(date) {
                        var day = date.getDay();
                        var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);

                        if (day === 0 || holidays.indexOf(formattedDate) !== -1) {
                            return [false, "", "Unavailable"];
                        } else {
                            return [true, ""];
                        }
                    },
                    minDate: startDate,
                    maxDate: endDate
                });
            }
        }
    });
});
</script>

</body>
</html>


