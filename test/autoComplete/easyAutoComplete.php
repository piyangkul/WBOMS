<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>jQuery UI Autocomplete - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

        <!-- JS file -->
        <script src="../../EasyAutocomplete-1.3.3/jquery.easy-autocomplete.min.js"></script> 

        <!-- CSS file -->
        <link rel="stylesheet" href="../../EasyAutocomplete-1.3.3/easy-autocomplete.min.css"> 

        <!-- Additional CSS Themes file - not required-->
        <link rel="stylesheet" href="../../EasyAutocomplete-1.3.3/easy-autocomplete.themes.min.css"> 
    </head>
    <body>
        <input id="example-ajax-post" />
        <script>
            var options = {
                url: function (phrase) {
                    return "data_autoComplete.php";
                },
                getValue: function (element) {
                    return element.name;
                },
                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {
                        dataType: "json"
                    }
                },
                preparePostData: function (data) {
                    data.phrase = $("#example-ajax-post").val();
                    return data;
                },
                requestDelay: 400
            };
            
            $("#example-ajax-post").easyAutocomplete(options);
        </script>
    </body>
</html>