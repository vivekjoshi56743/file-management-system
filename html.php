<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form name="car_form" method="post" action="html.php">
            <select name="car" id="car">
                    <option value="">Select Car</option>
                    <option value="BMW|Red">Red BMW</option>
                    <option value="Mercedes|Black">Black Mercedes</option>
            </select>
            <input type="submit" name="submit" id="submit" value="submit">
    </form>
</body>
</html>
<?php
            $result = $_POST['car'];
            $result_explode = explode('|', $result);
            echo "Model: " . $result_explode[0]."<br />";
            echo "Colour: ". $result_explode[1]."<br />";
    ?>